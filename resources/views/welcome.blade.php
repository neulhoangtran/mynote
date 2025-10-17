<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <title>MyNote</title>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <style>
        body .ql-editor.ql-blank::before {
            color: #fff;
        }
        body .ql-editor.ql-blank::before {
            color: #fff;
        }

        body .ql-snow .ql-stroke {
            stroke: #fff;
        }

        body .ql-snow .ql-picker.ql-header .ql-picker-label::before, 
        body .ql-snow .ql-picker.ql-header .ql-picker-item::before {
            color: #fff;
        }

        body .ql-snow .ql-picker-options .ql-picker-item:before {
            color: #000 !important;
        }
        body .ql-snow .ql-fill, .ql-snow .ql-stroke.ql-fill {
            fill: #fff;
        }
        body .ql-snow .ql-icon-picker .ql-picker-item line.ql-stroke {
            stroke: #444;
        }
    </style>
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#3b82f6',
                        darkbg: '#0f172a',
                        darkpanel: '#1e293b',
                        darktext: '#e2e8f0'
                    }
                }
            }
        }
    </script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.9/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.9/theme/dracula.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.9/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.9/mode/javascript/javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.9/mode/python/python.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.9/mode/php/php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.9/mode/sql/sql.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.9/mode/htmlmixed/htmlmixed.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.9/mode/css/css.min.js"></script>
    <!-- QuillJS -->
    <link href="/public/libs/quill/quill.snow.css" rel="stylesheet" />
    <script src="/public/libs/quill/quill.js"></script>
    <link href="/public/app.css" rel="stylesheet" />
    @livewireStyles
</head>
<body class="dark:bg-darkbg dark:text-darktext min-h-screen flex flex-col font-[Instrument Sans]">
    
    
    
    <!-- Header -->
    <header class="w-full bg-darkpanel border-b border-gray-700 shadow-sm">
        <livewire:header />
    </header>

    <!-- Main content -->
    <main class="flex flex-1">
        <!-- Main Area (9 phần) -->
        <section class="w-9/12 border-r border-gray-700 p-6">
            <livewire:note-list />
        </section>

        <!-- Sidebar (3 phần) -->
        <aside class="w-3/12 bg-darkpanel border-l border-gray-700 p-4">
            <livewire:tag-manager />
        </aside>
    </main>

    <!-- Footer -->
    <footer class="w-full bg-darkpanel border-t border-gray-700 text-center text-gray-500 text-sm py-3">
        <p>© {{ date('Y') }} MyNote — <span class="text-primary">Dark Mode</span> by Laravel + Livewire + TailwindCSS.</p>
    </footer>
    <livewire:note-modal />
    <livewire:note-detail />


    @livewireScripts
</body>
</html>
