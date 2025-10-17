<div class="space-y-3">
  <!-- Note List -->
  @forelse($notes as $note)
    <div class="group relative bg-darkpanel border border-gray-700 rounded p-4 hover:border-blue-500 transition" wire:click="openDetail({{ $note->id }})">
      <!-- 🔹 Nút Edit -->
      <button
        wire:click.stop="editNote({{ $note->id }})"
        class="absolute top-2 right-8 text-gray-400 hover:text-yellow-400 bg-gray-800/80 rounded-full p-1
               opacity-0 group-hover:opacity-100 transition-opacity duration-200"
        title="Chỉnh sửa note này">
        ✏️
      </button>
      <!-- 🔹 Nút xóa (ẩn mặc định, hiện khi hover) -->
      <button
        wire:click.stop="deleteNote({{ $note->id }})"
        wire:confirm="Bạn có chắc muốn xóa note này không?"
        class="absolute top-2 right-2 text-gray-400 hover:text-red-500 bg-gray-800/80 rounded-full p-1
               opacity-0 group-hover:opacity-100 transition-opacity duration-200"
        title="Xóa note này">
        ✕
      </button>
      <h3 class="text-lg font-semibold text-gray-100 mb-2">{{ $note->note_title }}</h3>
      <div class="flex flex-wrap gap-2">
        @foreach($note->tags as $tag)
          <span class="text-xs bg-blue-600/20 text-blue-400 px-2 py-1 rounded-full border border-blue-500/30">
            #{{ $tag->tag_name }}
          </span>
        @endforeach
      </div>
    </div>
  @empty
    <p class="text-gray-500 text-sm italic">Không có note nào.</p>
  @endforelse

  <!-- Pagination -->
    @if($notes instanceof \Illuminate\Contracts\Pagination\Paginator)
    <div class="mt-6">
        {{ $notes->links() }}
    </div>
    @endif

</div>
