<div wire:ignore x-data
     x-init="
        const quill = new Quill($refs.editor, {
          theme: 'snow',
          placeholder: 'Nhập nội dung...',
          modules: {
            toolbar: [
              ['bold', 'italic', 'underline'],
              ['link', 'image', 'code-block'],
              [{ 'list': 'ordered' }, { 'list': 'bullet' }],
              ['clean']
            ]
          }
        });

        quill.root.innerHTML = @js($content ?? '');

        quill.on('text-change', () => {
          $dispatch('note-text-updated', [quill.root.innerHTML]);
        });

        // Image upload
        quill.getModule('toolbar').addHandler('image', () => {
          const input = document.createElement('input');
          input.type = 'file';
          input.accept = 'image/*';
          input.onchange = async () => {
            const file = input.files[0];
            if (file) {
              const formData = new FormData();
              formData.append('image', file);
              const res = await fetch('/upload-note-image', {
                method: 'POST',
                body: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
              });
              const data = await res.json();
              if (data.url) {
                const range = quill.getSelection();
                quill.insertEmbed(range.index, 'image', data.url);
              }
            }
          };
          input.click();
        });
     ">
  <div x-ref="editor" class="bg-[#0f172a] border border-gray-700 rounded min-h-[220px] text-gray-200"></div>
</div>

