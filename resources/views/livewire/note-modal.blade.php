<div>
@if($show)
<div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-70 z-50">
  <div class="bg-[#1e293b] text-gray-200 rounded-lg shadow-lg w-3/5 max-h-[90vh] overflow-y-auto p-6 border border-gray-600 relative">

    <button wire:click="close"
            class="absolute top-3 right-3 text-gray-400 hover:text-gray-200">✕</button>

    <h2 class="text-lg font-semibold mb-4">
      @if($note_id)
        ✏️ Edit Note
      @else
        📝 New Note
      @endif
    </h2>

    <div class="space-y-4">

      <!-- Tiêu đề -->
      <div>
        <label class="block text-sm mb-1 text-gray-400">Tên Note</label>
        <input type="text" wire:model="note_title"
               class="w-full bg-[#0f172a] border border-gray-700 rounded p-2 text-gray-200 
                      focus:ring-2 focus:ring-blue-500 outline-none">
        @error('note_title') <p class="text-red-400 text-sm">{{ $message }}</p> @enderror
      </div>

      <!-- Loại note -->
      <div class="flex items-center gap-4 mt-2">
        <label class="flex items-center gap-2 cursor-pointer px-3 py-2 rounded-md border transition select-none
            @if($note_type === 'text') bg-blue-600 border-blue-500 text-white shadow 
            @else bg-[#1e293b] border-gray-700 text-gray-300 hover:bg-[#334155] @endif">
          <input type="radio" wire:model.live="note_type" value="text" class="hidden">
          🖋️ <span class="text-sm font-medium">Text / Image</span>
        </label>
        <label class="flex items-center gap-2 cursor-pointer px-3 py-2 rounded-md border transition select-none
            @if($note_type === 'code') bg-blue-600 border-blue-500 text-white shadow 
            @else bg-[#1e293b] border-gray-700 text-gray-300 hover:bg-[#334155] @endif">
          <input type="radio" wire:model.live="note_type" value="code" class="hidden">
          💻 <span class="text-sm font-medium">Code</span>
        </label>
        <!-- 🆕 Loại HTML -->
        <label class="flex items-center gap-2 cursor-pointer px-3 py-2 rounded-md border transition select-none
            @if($note_type === 'html') bg-blue-600 border-blue-500 text-white shadow 
            @else bg-[#1e293b] border-gray-700 text-gray-300 hover:bg-[#334155] @endif">
          <input type="radio" wire:model.live="note_type" value="mixed" class="hidden">
          🌐 <span class="text-sm font-medium">HTML</span>
        </label>
      </div>

      <!-- Editor -->
      <div class="mt-4">
        @if ($note_type === 'text')
          <livewire:text-editor :content="$note_text" wire:key="text-editor" />
        @elseif ($note_type === 'code')
          <livewire:code-editor :files="$files" wire:key="code-editor" />
        @elseif ($note_type === 'mixed')
          <!-- 🆕 Simple HTML textarea -->
          <textarea
            wire:model.defer="note_text"
            class="w-full bg-[#0f172a] border border-gray-700 rounded p-3 text-gray-200 
                  focus:ring-2 focus:ring-blue-500 outline-none min-h-[220px]"
            placeholder="Nhập mã HTML tại đây..."></textarea>
        @endif
      </div>

      <!-- Tags -->
    <div>
        <label class="block text-sm mb-1 text-gray-400">Tags</label>
        <div class="flex flex-wrap gap-2">
            @foreach($tags as $tag)
            @php $selected = in_array($tag->id, $selectedTags); @endphp
            <button 
                wire:click="toggleTag({{ $tag->id }})"
                wire:key="tag-{{ $tag->id }}"
                type="button"
                wire:loading.attr="disabled"
                class="px-3 py-1 rounded-full text-sm border transition
                    @if($selected) bg-blue-600 border-blue-500 text-white shadow 
                    @else bg-[#1e293b] border-gray-600 text-gray-300 hover:bg-[#334155] @endif">
                #{{ $tag->tag_name }}
            </button>
            @endforeach
        </div>
    </div>


      <!-- Keywords -->
      <div>
        <label class="block text-sm mb-1 text-gray-400">Keywords</label>
        <input type="text" wire:model="keywords"
               placeholder="VD: api, login, security"
               class="w-full bg-[#0f172a] border border-gray-700 rounded p-2 text-gray-200
                      focus:ring-2 focus:ring-blue-500 outline-none">
      </div>

    </div>

    <div class="mt-6 text-right">
      <button wire:click="close"
              class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded mr-2">
        Cancel
      </button>
      <button wire:click="saveNote"
          class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
        @if($note_id)
          Update
        @else
          Save
        @endif
      </button>
    </div>
  </div>
</div>
@endif
</div>
