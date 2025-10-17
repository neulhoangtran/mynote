<div class="p-4 space-y-4 text-gray-200">
    <h3 class="text-sm uppercase tracking-wide text-gray-400 flex items-center justify-between">
        <span>Tags</span>
        <!-- Nút Select / Clear -->
        <div class="flex gap-2">
            <button wire:click="selectAll"
                    class="text-xs px-2 py-1 rounded border border-gray-600 bg-[#1e293b] 
                           hover:bg-blue-600 hover:text-white transition">
                Select All
            </button>
            <button wire:click="clearAll"
                    class="text-xs px-2 py-1 rounded border border-gray-600 bg-[#1e293b] 
                           hover:bg-red-600 hover:text-white transition">
                Clear All
            </button>
        </div>
    </h3>

    <!-- Add new tag -->
    <div class="flex gap-2">
        <input type="text"
               wire:model="newTag"
               placeholder="New tag name..."
               class="flex-1 bg-[#0f172a] border border-gray-700 rounded p-2
                      focus:outline-none focus:ring-2 focus:ring-blue-500
                      placeholder-gray-500 text-gray-200 transition">
        <button wire:click="addTag"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700
                       focus:ring-2 focus:ring-blue-400 transition">
            Add
        </button>
    </div>

    <!-- Thông báo -->
    @if ($message)
        <div 
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 3000)"
            x-show="show"
            x-transition.opacity.duration.500ms
            class="@if($messageType === 'success') bg-green-900 text-green-200 border-green-600
                   @elseif($messageType === 'error') bg-red-900 text-red-200 border-red-600
                   @else bg-gray-800 text-gray-300 border-gray-700 @endif
                   border rounded p-2 text-sm">
            {{ $message }}
        </div>
    @endif
    @error('newTag')
        <p class="text-red-400 text-sm">{{ $message }}</p>
    @enderror

    <!-- Tag list inline (click để chọn/bỏ) -->
    <div class="flex flex-wrap gap-2 pt-1">
        @foreach ($tags as $tag)
            @php $isSelected = in_array($tag->id, $selectedTags); @endphp

            <button
                wire:click="toggleTag({{ $tag->id }})"
                class="px-3 py-1 rounded-full text-sm border transition
                       @if($isSelected)
                           bg-blue-600 border-blue-500 text-white shadow
                       @else
                           bg-[#1e293b] border-gray-600 text-gray-300 hover:bg-[#334155]
                       @endif">
                #{{ $tag->tag_name }}
            </button>
        @endforeach
    </div>
</div>
