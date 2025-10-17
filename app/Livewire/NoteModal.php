<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Tag;
use App\Models\Note;

class NoteModal extends Component
{
    public $show = false;
    public $note_title = '';
    public $note_type = 'text';
    public $note_text = '';
    public $files = [];
    public $tags = [];
    public $selectedTags = [];
    public $keywords = '';
    public $note_id = null;

    protected $listeners = [
        'note-text-updated' => 'setNoteText',
        'note-files-updated' => 'setNoteFiles',
        'open-note-modal' => 'open',
        'open-edit-note' => 'loadNote', 
    ];

    public function mount()
    {
        $this->tags = Tag::orderBy('tag_name')->get();
    }

    public function open()
    {
        $this->resetForm();
        $this->show = true;
    }

    public function close()
    {
        $this->note_id = null;
        $this->show = false;
    }

    public function updatedNoteType()
    {
        $this->note_text = '';
        $this->files = [];

        if ($this->note_type === 'code') {
            $this->files[] = [
                'path' => 'main.js',
                'content' => '// Start coding here...'
            ];
        }
    }

    public function setNoteText($html)
    {
        $this->note_text = $html;
    }

    public function setNoteFiles($files)
    {
        $this->files = $files;
    }

    public function saveNote()
    {
        $this->validate([
            'note_title' => 'required|min:3|max:100',
        ]);

        if ($this->note_id) {
            // 🔹 Cập nhật note hiện có
            $note = \App\Models\Note::find($this->note_id);
            if ($note) {
                $note->update([
                    'note_title' => $this->note_title,
                    'note_type' => $this->note_type,
                    'note_text' => $this->note_text,
                    'note_code' => $this->files,
                    'keywords' => $this->keywords,
                ]);

                $note->tags()->sync($this->selectedTags);
            }
        } else {
            // 🔹 Tạo note mới
            $note = \App\Models\Note::create([
                'note_title' => $this->note_title,
                'note_type' => $this->note_type,
                'note_text' => $this->note_text,
                'note_code' => $this->files,
                'keywords' => $this->keywords,
            ]);

            if (!empty($this->selectedTags)) {
                $note->tags()->sync($this->selectedTags);
            }
        }

        $this->dispatch('note-created', $note->id);
        $this->close();
    }

    private function resetForm()
    {
        $this->note_title = '';
        $this->note_type = 'text';
        $this->note_text = '';
        $this->files = [];
        $this->selectedTags = [];
        $this->keywords = '';
        $this->note_id = null;
    }

    public function loadNote($note)
    {
        $this->resetForm();

        $this->show = true;

        // Gán dữ liệu vào form
        $this->note_title = $note['note_title'] ?? '';
        $this->note_type = $note['note_type'] ?? 'text';
        $this->note_text = $note['note_text'] ?? '';
        $this->files = $note['note_code'] ?? [];
        $this->keywords = $note['keywords'] ?? '';

        // Tags (chuyển sang ID)
        $this->selectedTags = collect($note['tags'] ?? [])->pluck('id')->toArray();

        // Giữ ID để update
        $this->note_id = $note['id'] ?? null;
    }


    public function toggleTag($tagId)
    {
        if (in_array($tagId, $this->selectedTags)) {
            // Nếu đã có -> bỏ ra
            $this->selectedTags = array_diff($this->selectedTags, [$tagId]);
        } else {
            // Nếu chưa có -> thêm vào
            $this->selectedTags[] = $tagId;
        }
    }

    public function render()
    {
        return view('livewire.note-modal');
    }
}
