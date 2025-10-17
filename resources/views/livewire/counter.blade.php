<div class="text-center p-8">
    <h1 class="text-3xl font-bold mb-4">Livewire Counter</h1>
    <h2 class="text-2xl mb-4">Count: {{ $count }}</h2>

    <button wire:click="increment"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        +
    </button>
</div>
