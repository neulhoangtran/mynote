<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <title>MyNote</title>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <!-- PWA  -->
    <!-- <meta name="theme-color" content="#6777ef"/> -->
    <link rel="apple-touch-icon" href="/public/logo.png">
    <link rel="manifest" href="/public/manifest.json">
    <style>
        .grid-stack {
            min-height: 0px; /* hoặc 100px */
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
    
    
    <link rel="stylesheet" href="/public/libs/gridstack.css" />
    <script src="/public/libs/gridstack.js"></script>
    <link href="/public/app.css" rel="stylesheet" />
    @livewireStyles
</head>
<body class="dark:bg-darkbg dark:text-darktext min-h-screen flex flex-col font-[Instrument Sans]">
    
    <!-- Main content -->
    <main class="flex flex-1">
        <livewire:grid-note />
    </main>

    <!-- Footer -->
    <!-- <footer class="w-full bg-darkpanel border-t border-gray-700 text-center text-gray-500 text-sm py-3">
        <p>© {{ date('Y') }} MyNote — <span class="text-primary">Dark Mode</span> by Laravel + Livewire + TailwindCSS.</p>
    </footer> -->
    <livewire:note-modal />
    <livewire:note-detail />


    <script src="/public/sw.js"></script>
    <script>
    if ("serviceWorker" in navigator) {
        // Register a service worker hosted at the root of the
        // site using the default scope.
        navigator.serviceWorker.register("/public/sw.js").then(
        (registration) => {
            console.log("Service worker registration succeeded:", registration);
        },
        (error) => {
            console.error(`Service worker registration failed: ${error}`);
        },
        );
    } else {
        console.error("Service workers are not supported.");
    }
    </script>
     <script src="/public/pwa-install.js"></script>
    @livewireScripts
</body>
</html>
