<header class="w-full bg-[#1e293b] border-b border-gray-700 px-6 py-3 flex items-center justify-between shadow-sm relative">
    <!-- Logo -->
    <div class="flex items-center space-x-2">
        <span class="text-2xl font-bold text-blue-400">MyNote</span>
        <span class="text-gray-500 text-sm">beta</span>
    </div>

    <!-- Search box -->
    <div class="flex-1 mx-8 relative">
        <!-- Icon search -->
        <button 
            type="button"
            wire:click="$dispatch('search-updated', search)"
            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-400 transition"
        >
            <!-- Heroicon: Magnifying Glass -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M5.5 11a5.5 5.5 0 1 1 11 0 5.5 5.5 0 0 1-11 0z" />
            </svg>
        </button>

        <!-- Input -->
        <input type="text"
            wire:model.live.debounce.500ms="search"
            placeholder="Search notes or tags..."
            class="w-full bg-[#0f172a] border border-gray-700 text-gray-200 rounded-full p-2 px-10 
                    focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-500 transition">
    </div>


    <!-- Profile / user button -->
    <div class="flex items-center space-x-3">
        <!-- New Note Button -->
        <button wire:click="$dispatch('open-note-modal')"
                class="text-sm bg-blue-600 text-white px-3 py-1.5 rounded hover:bg-blue-700 transition">
            + New Note
        </button>
        <!-- Avatar -->
        <a href="/gridnote" class="w-9 h-9 rounded-full bg-gray-700 flex items-center justify-center 
                    text-gray-200 font-semibold border border-gray-600">
            B
        </a>
    </div>

    <!-- Modal New Note -->

</header>
