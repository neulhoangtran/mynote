<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class TextEditor extends Component
{
    use WithFileUploads;

    public $content = '';

    public function mount($content = '')
    {
        $this->content = $content;
    }

    public function render()
    {
        return view('livewire.text-editor');
    }
}
