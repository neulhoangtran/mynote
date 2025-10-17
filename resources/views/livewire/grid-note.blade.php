<div class="w-screen h-screen bg-darkbg text-gray-200 flex flex-col overflow-hidden">
    <!-- Header -->
    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-700 bg-darkpanel flex-none">
        <div class="flex items-center gap-3">
            <a href="/" class="flex items-center space-x-2">
                <span class="text-2xl font-bold text-blue-400">MyNote</span>
                <span class="text-gray-500 text-sm">beta</span>
            </a>
            <!-- Dropdown chọn dashboard -->
            <select id="select-layout" wire:model.live="selectedDashboardId"
                    class="bg-gray-800 border border-gray-700 rounded px-3 py-1 text-gray-200 focus:outline-none focus:ring focus:ring-blue-600">
                @foreach($dashboards as $db)
                    <option value="{{ $db->id }}">{{ $db->name }}</option>
                @endforeach
            </select>

            <!-- Nút thêm dashboard -->
            <button wire:click="openAddDashboardModal"
                    class="bg-blue-700 hover:bg-blue-800 px-3 py-1 rounded text-white text-sm">
                + Add Dashboard
            </button>
        </div>

        <div class="flex items-center gap-2">
            <!-- 🧱 Nút Save Layout -->
            <button id="save-layout-btn" 
                    class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded text-white">
                💾 Save Layout
            </button>

            <!-- Nút Add Note -->
            <button wire:click="openModal"
                    class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded text-white">
                + Add Note
            </button>
        </div>
    </div>


    <!-- Gridstack Container -->
    <div id="grid" class="grid-stack flex-1 overflow-auto bg-darkbg p-6" style="min-height: 100vh" wire:ignore></div>

   <!-- Modal chọn note -->
    @if($showModal)
        <div x-data @click.self="$wire.showModal = false"
            x-init="$el.focus()"
            tabindex="0"
            @click.self="$wire.showModal = false"
            @keydown.escape.window="$wire.showModal = false"
            class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50">
            <div class="bg-darkpanel rounded-lg p-6 w-1/3 border border-gray-700 relative">
                <!-- 🔹 Nút đóng -->
                <button wire:click="$set('showModal', false)"
                        class="absolute top-4 right-4 text-gray-400 hover:text-white text-xl font-bold">
                    ✕
                </button>

                <h3 class="text-lg font-semibold mb-4">Chọn Note để thêm</h3>
                <div class="max-h-[60vh] overflow-y-auto space-y-2">
                    @if($availableNotes->isEmpty())
                        <p class="text-gray-400 text-sm italic">Không còn ghi chú nào để thêm.</p>
                    @else
                        @foreach($availableNotes as $note)
                            <div class="border border-gray-700 p-3 rounded hover:bg-[#1e293b] cursor-pointer"
                                wire:click="addNote({{ $note->id }})">
                                <p class="font-semibold">{{ $note->note_title }}</p>
                                <div class="text-sm text-gray-400 line-clamp-2">{!! strip_tags($note->note_text) !!}</div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Modal thêm dashboard -->
    @if($showAddDashboardModal)
        <div x-data @click.self="$wire.showAddDashboardModal = false"
            x-init="$el.focus()"
            tabindex="0"
            @click.self="$wire.showModal = false"
            @keydown.escape.window="$wire.showModal = false"
             class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50">
            <div class="bg-darkpanel rounded-lg p-6 w-1/3 border border-gray-700">
                <h3 class="text-lg font-semibold mb-4 text-blue-400">Thêm Dashboard mới</h3>
                <input type="text" wire:model="newDashboardName"
                       placeholder="Nhập tên dashboard..."
                       class="w-full bg-gray-800 border border-gray-700 rounded px-3 py-2 text-gray-200 focus:outline-none focus:ring focus:ring-blue-600 mb-4">
                <div class="flex justify-end gap-2">
                    <button wire:click="$set('showAddDashboardModal', false)"
                            class="px-3 py-1 bg-gray-600 rounded hover:bg-gray-700">Hủy</button>
                    <button wire:click="saveNewDashboard"
                            class="px-3 py-1 bg-blue-700 rounded hover:bg-blue-800 text-white">Lưu</button>
                </div>
            </div>
        </div>
    @endif
    <script>

        function deleteNote(itemId) {
            if (confirm('Bạn có chắc muốn xóa note này khỏi dashboard?')) {
                Livewire.dispatch('remove-note', { id: itemId });
            }
        }

        document.addEventListener('livewire:init', () => {
            const grid = GridStack.init({ float: false });
            Livewire.on('notify', (data) => {
                alert(data.message || 'Layout saved!');
            });
            Livewire.on('selected-dashboard-changed', (id) => {
                localStorage.setItem('selectedDashboardId', id);
            });

            Livewire.on('render-grid', (data) => {
                const notes = data.notes || [];
                grid.removeAll();
                
                notes.forEach(n => {
                    const el = document.createElement('div');
                    el.classList.add('grid-stack-item');
                    el.setAttribute('gs-id', n.id);
                    el.setAttribute('gs-x', n.x ?? 0);
                    el.setAttribute('gs-y', n.y ?? 0);
                    el.setAttribute('gs-w', n.w ?? 4);
                    el.setAttribute('gs-h', n.h ?? 2);
                    el.innerHTML = `
                        <div class="group grid-stack-item-content bg-[#1e293b] border border-gray-700 rounded p-3 overflow-auto relative">
                            <button 
                                onclick="deleteNote(${n.id})"
                                class="absolute top-1 right-1 bg-red-600 hover:bg-red-700 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                                ✕
                            </button>
                            <h4 class="font-semibold text-blue-400 mb-2">${n.title ?? ''}</h4>
                            <div class="text-sm text-gray-300">${n.content ?? ''}</div>
                        </div>`;
                    setTimeout(function(){
                        grid.makeWidget(el);
                    },100)
                });
            });

            // 🔹 Lấy layout hiện tại
            function collectLayout() {
                return grid.engine.nodes.map(node => ({
                    id: node.el.getAttribute('gs-id'),
                    x: node.x,
                    y: node.y,
                    w: node.w,
                    h: node.h,
                }));
            }

            // const savedId = localStorage.getItem('selectedDashboardId');
            // if (savedId) {
            //     // console.log(123123);
            //     Livewire.dispatch('load-dashboard-from-storage', { id: savedId });
            // }
            

            // 💾 Nút Save Layout
            document.getElementById('save-layout-btn').addEventListener('click', () => {
                const layout = collectLayout();
                Livewire.dispatch('save-layout', { data: layout });
            });

            Livewire.hook('component.init', ({ component }) => {
                if (component.name === 'grid-note') {
                    const savedId = localStorage.getItem('selectedDashboardId');
                    if (savedId) {
                        console.log('📦 Restoring dashboard:', savedId);
                        setTimeout(() => {
                            Livewire.dispatch('load-dashboard-from-storage', { id: savedId });
                        }, 100); // đợi Livewire mount xong
                    }
                }
            });
        });

        
    </script>

</div>
