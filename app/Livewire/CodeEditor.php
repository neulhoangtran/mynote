<?php

namespace App\Livewire;

use Livewire\Component;

class CodeEditor extends Component
{
    public $files = [];

    public function mount($files = [])
    {
        $this->files = $files;
    }

    public function addFile()
    {
        $this->files[] = ['path' => 'file.js', 'content' => ''];
        $this->dispatch('note-files-updated', $this->files);
    }

    public function removeFile($index)
    {
        unset($this->files[$index]);
        $this->files = array_values($this->files);
        $this->dispatch('note-files-updated', $this->files);
    }

    public function updatedFiles()
    {
        $this->dispatch('note-files-updated', $this->files);
    }

    public function render()
    {
        return view('livewire.code-editor');
    }
}
