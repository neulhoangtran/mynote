<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Note;

class NoteList extends Component
{
    use WithPagination;

    public $search = '';
    public $tagFilter = null;

    protected $paginationTheme = 'tailwind';

    protected $listeners = [
        'note-created' => '$refresh',
        'search-updated' => 'updateSearch',   // 👈 khi header gửi event
        'tags-filter-changed' => 'filterByTags',      // 👈 khi sidebar gửi event
        
    ];

    public function updateSearch($term)
    {
        $this->search = $term;
        $this->resetPage();
    }

    public function filterByTag($tagId)
    {
        $this->tagFilter = $tagId;
        $this->resetPage();
    }

    public function filterByTags($tagIds)
    {
        $this->tagFilter = $tagIds;
        $this->resetPage();
    }

    public function openDetail($id)
    {
        // Gửi sự kiện trực tiếp tới component NoteDetail trên trang
        $this->dispatch('open-note-detail', id: $id)->to(NoteDetail::class);
    }

    public function deleteNote($id)
    {
        $note = \App\Models\Note::find($id);
        if (!$note) return;
        
        \App\Models\DashboardItem::where('note_id', $id)->delete();

        // Xóa note và detach tag liên quan
        $note->tags()->detach();
        $note->delete();
        // 🔹 1. Xóa khỏi mọi DashboardItem có note_id này

        // Cập nhật lại danh sách
        $this->dispatch('note-created'); // để refresh list
    }

    public function editNote($id)
    {
        $note = \App\Models\Note::with('tags')->find($id);
        if (!$note) return;

        $this->dispatch('open-edit-note', note: $note)->to(\App\Livewire\NoteModal::class);
    }


    public function render()
    {
        $query = Note::with('tags')->latest();

        if (!empty($this->tagFilter)) {
            $query->whereHas('tags', fn($q) => $q->whereIn('tags.id', $this->tagFilter));
        }

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('note_title', 'like', "%{$this->search}%")
                ->orWhere('keywords', 'like', "%{$this->search}%");
            });
        }

        $notes = $query->paginate(100); // 👈 phải là paginate() hoặc get()

        return view('livewire.note-list', [
            'notes' => $notes,
        ]);
    }

}
