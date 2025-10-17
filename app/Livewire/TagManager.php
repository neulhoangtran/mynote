<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Tag;
use Illuminate\Support\Str;
use Exception;

use Illuminate\Support\Facades\Storage;
class TagManager extends Component
{
    public $tags = [];
    public $selectedTags = [];

    public $newTag = '';
    public $message = '';            // thông báo UI
    public $messageType = 'info';    // success | error | info

    protected $rules = [
        'newTag' => 'required|min:2|max:50',
    ];

    public function mount()
    {
        $this->loadTags();
    }

    public function loadTags()
    {
        $this->tags = Tag::orderBy('tag_name')->get();
    }

    public function addTag()
    {
        // chuẩn hóa dữ liệu nhập
        $this->newTag = trim($this->newTag);
        $this->validate();

        try {
            // Dùng tag_key (slug) để chống trùng (case-insensitive, bỏ dấu/khoảng trắng)
            $key = Str::slug($this->newTag);

            $exists = Tag::where('tag_key', $key)->exists();
            if ($exists) {
                $this->message = '⚠️ Tag này đã tồn tại!';
                $this->messageType = 'error';
                return;
            }

            // Tạo tag mới
            $tag = Tag::create([
                'tag_name' => $this->newTag,
                'tag_key'  => $key,
            ]);

            // Clear input + reload list
            $this->newTag = '';
            $this->loadTags();

            // Tự động chọn tag vừa tạo để áp filter luôn
            $this->selectedTags[] = $tag->id;
            $this->dispatch('tags-filter-changed', $this->selectedTags);

            $this->message = '✅ Thêm tag thành công!';
            $this->messageType = 'success';
        } catch (Exception $e) {
            $this->message = '❌ Lỗi khi thêm tag: ' . $e->getMessage();
            $this->messageType = 'error';
        }
    }

    public function toggleTag($tagId)
    {
        if (in_array($tagId, $this->selectedTags)) {
            // bỏ chọn
            $this->selectedTags = array_values(array_diff($this->selectedTags, [$tagId]));
        } else {
            // chọn
            $this->selectedTags[] = $tagId;
        }

        // bắn event để NoteList (hoặc component khác) lọc theo tag
        $this->dispatch('tags-filter-changed', $this->selectedTags);
    }

    public function selectAll()
    {
        $this->selectedTags = $this->tags->pluck('id')->toArray();
        $this->dispatch('tags-filter-changed', $this->selectedTags);
    }

    public function clearAll()
    {
        $this->selectedTags = [];
        $this->dispatch('tags-filter-changed', $this->selectedTags);
    }

    

    public function render()
    {
        return view('livewire.tag-manager');
    }
}
