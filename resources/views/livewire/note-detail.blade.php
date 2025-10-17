<div>
    @if($show && $note)
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-70 z-50" x-on:keydown.escape.window="$wire.close()">
        <div class="bg-[#1e293b] text-gray-200 rounded-lg shadow-lg w-4/5 max-h-[90vh] overflow-y-auto p-6 border border-gray-600 relative">
            
            <!-- Close -->
            <button wire:click="close"
                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-200 text-lg">✕</button>

            <h2 class="text-lg font-semibold mb-4">🗒️ {{ $note->note_title }}</h2>

            @if($note->note_type === 'text')
                <!-- Note Text -->
                <div class="prose prose-invert max-w-none">
                    {!! $note->note_text !!}
                </div>

            @elseif($note->note_type === 'code')
                <!-- Code Note -->
                @php
                    $files = is_array($note->note_code)
                        ? $note->note_code
                        : json_decode($note->note_code, true);
                @endphp

                <div class="space-y-4">
                    @foreach($files ?? [] as $file)
                        <div class="bg-[#0f172a] border border-gray-700 rounded p-3">
                            <p class="font-mono text-sm text-blue-400 mb-2">{{ $file['path'] ?? 'unnamed' }}</p>
                            <div x-data 
                                x-init="CodeMirror.fromTextArea($refs.view{{ $loop->index }}, {
                                    lineNumbers: true,
                                    readOnly: true,
                                    theme: 'dracula',
                                    mode: 'javascript'
                                })">
                                <textarea x-ref="view{{ $loop->index }}" class="hidden">{{ $file['content'] ?? '' }}</textarea>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    @endif
</div>
