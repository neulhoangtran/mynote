<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Note;

class NoteDetail extends Component
{
    public $show = false;
    public $note;

    protected $listeners = [
        'open-note-detail' => 'open',
    ];

    public function open($id)
    {
        $this->note = \App\Models\Note::with('tags')->find($id);
        $this->show = true;
    }

    public function close()
    {
        $this->show = false;
        $this->note = null;
    }

    public function render()
    {
        return view('livewire.note-detail');
    }
}
