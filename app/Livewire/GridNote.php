<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Note;
use App\Models\Dashboard;
use App\Models\DashboardItem;

class GridNote extends Component
{
    public $notes = [];
    public $dashboards = [];
    public $selectedDashboardId;
    public $showModal = false;
    public $showAddDashboardModal = false;
    public $newDashboardName = '';
    public $availableNotes = [];

    public function mount()
    {
        // Load danh sách dashboard của user (hoặc tất cả)
        
        // $this->selectedDashboardId = $this->dashboards->first()->id ?? null;

        // $this->loadDashboardItems();
    }

    #[On('load-dashboard-from-storage')]
    public function loadDashboardFromStorage($id)
    {
        $this->dashboards = Dashboard::orderBy('id')->get();
        if ($id && Dashboard::where('id', $id)->exists()) {
            $this->selectedDashboardId = (int) $id;
            $this->loadDashboardItems();
        }
        if (!$this->selectedDashboardId) {
            $this->selectedDashboardId = $this->dashboards->first()->id ?? null;
        }

        // 🔹 Đưa dashboard được chọn lên đầu danh sách
        $this->dashboards = $this->dashboards
            ->sortByDesc(fn($d) => $d->id == $this->selectedDashboardId)
            ->values();

    }

    public function loadDashboardItems()
    {
        if (!$this->selectedDashboardId) return;
        $dashboard = Dashboard::with(['items.note'])->find($this->selectedDashboardId);
        $this->notes = $dashboard?->items->map(fn($i) => [
            'id' => (string)$i->id,
            'title' => $i->note?->note_title,
            'content' => $i->note?->note_text,
            'x' => $i->x, 
            'y' => $i->y,
            'w' => $i->w,
            'h' => $i->h,
        ])->toArray() ?? [];

        $this->dispatch('render-grid', notes: $this->notes);

    }
    

    public function updatedSelectedDashboardId()
    {
        $this->dispatch('selected-dashboard-changed', (int)$this->selectedDashboardId);
        $this->loadDashboardItems();
    }

    public function openAddDashboardModal()
    {
        $this->newDashboardName = '';
        $this->showAddDashboardModal = true;
    }

    public function saveNewDashboard()
    {
        $this->validate(['newDashboardName' => 'required|string|max:100']);

        $dashboard = Dashboard::create([
            'name' => $this->newDashboardName,
        ]);

        $this->dashboards = Dashboard::orderBy('id')->get();
        $this->selectedDashboardId = $dashboard->id;
        $this->showAddDashboardModal = false;
        $this->loadDashboardItems();
    }

    public function openModal()
    {
        if (!$this->selectedDashboardId) return;

        // 🔹 Lấy danh sách note_id đã có trong dashboard hiện tại
        $usedNoteIds = \App\Models\DashboardItem::where('dashboard_id', $this->selectedDashboardId)
            ->pluck('note_id')
            ->filter()
            ->toArray();

        // 🔹 Lấy các note chưa có trong dashboard
        $this->availableNotes = \App\Models\Note::whereIn('note_type', ['text', 'mixed'])
            ->whereNotIn('id', $usedNoteIds)
            ->latest()
            ->get();

        $this->showModal = true;
    }

    #[On('remove-note')]
    public function removeNote($id)
    {
        $itemId = $id ?? null;
        if (!$itemId) return;

        \App\Models\DashboardItem::where('id', $itemId)
            ->where('dashboard_id', $this->selectedDashboardId)
            ->delete();

        $this->loadDashboardItems(); // reload lại lưới
    }

    public function addNote($noteId)
    {
        $note = Note::find($noteId);
        if ($note && $this->selectedDashboardId) {
            $item = DashboardItem::create([
                'dashboard_id' => $this->selectedDashboardId,
                'note_id'      => $note->id,
                'x' => 0,
                'y' => count($this->notes) * 2,
                'w' => 4,
                'h' => 2,
            ]);
        }

        $this->showModal = false;
        $this->loadDashboardItems();
    }

    #[On('save-layout')]
    public function saveLayout($data)
    {
        \Log::info('🧩 Saving layout for dashboard: ' . json_encode($data));
        $layout = $data ?? [];
        if (!$this->selectedDashboardId) return;


        foreach ($layout as $item) {
            \App\Models\DashboardItem::where('id', $item['id'])
                ->where('dashboard_id', $this->selectedDashboardId)
                ->update([
                    'x' => (int)$item['x'],
                    'y' => (int)$item['y'],
                    'w' => (int)$item['w'],
                    'h' => (int)$item['h'],
                ]);
        }

        $this->dispatch('notify', message: 'Layout saved successfully!');
    }


    public function render()
    {
        return view('livewire.grid-note')->layout(null);
    }
}
