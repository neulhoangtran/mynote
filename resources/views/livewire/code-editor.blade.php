<div class="space-y-3">
  @foreach($files as $i => $file)
    <div class="bg-[#0f172a] border border-gray-700 rounded p-3" wire:key="file-{{ $i }}">
      <div class="flex items-center justify-between mb-2">
        <input type="text" wire:model.live="files.{{ $i }}.path"
               placeholder="File path (vd: src/main.py)"
               class="w-3/4 bg-[#1e293b] border border-gray-700 rounded p-2 text-sm text-gray-200 
                      focus:ring-2 focus:ring-blue-500 outline-none">
        <button wire:click="removeFile({{ $i }})"
                class="text-red-400 hover:text-red-600 text-sm">✕</button>
      </div>
      <div wire:ignore x-data x-init="
          const modeByExt = (path) => {
            const ext = (path.split('.').pop() || '').toLowerCase();
            return {js:'javascript',py:'python',php:'php',sql:'sql',html:'htmlmixed',css:'css'}[ext] || 'javascript';
          };
          const cm = CodeMirror.fromTextArea($refs.ta, {
            lineNumbers: true,
            mode: modeByExt(@js($file['path'] ?? '')),
            theme: 'dracula'
          });
          cm.setValue(@js($file['content'] ?? ''));
          cm.on('change', () => $wire.set('files.{{ $i }}.content', cm.getValue()));
      ">
        <textarea x-ref="ta" class="hidden"></textarea>
      </div>
    </div>
  @endforeach

  <button wire:click="addFile"
          class="bg-gray-700 hover:bg-gray-600 text-white text-sm px-3 py-1.5 rounded">
    + Add File
  </button>
</div>

