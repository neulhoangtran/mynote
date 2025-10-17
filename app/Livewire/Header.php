<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Tag;

class Header extends Component
{
    public $search = '';
    public $tags = [];
    public $showModal = false;

    public function updatedSearch()
    {
        $this->dispatch('search-updated', $this->search);
        // $this->loadTags();
    }


    public function selectTag($tagName)
    {
        $this->search = $tagName;
        $this->dispatch('search-updated', $this->search);
        $this->tags = [];
    }

    // public function loadTags()
    // {
    //     $this->tags = \App\Models\Tag::where('tag_name', 'like', "%{$this->search}%")->limit(5)->get();
    // }

    public function toggleModal()
    {
        $this->showModal = !$this->showModal;
    }

    public function render()
    {
        return view('livewire.header');
    }
}
