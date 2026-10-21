<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login') - cuansampingan Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: '#0D1B2A',
                        'navy-light': '#162436',
                        gold: '#F5C518',
                        'gold-dark': '#D4A90E',
                        teal: '#1DB89A',
                        'teal-dark': '#17967E',
                        'gray-soft': '#A8B8C8',
                        'gray-border': '#1E2F42',
                        danger: '#E05252',
                        success: '#2ECC71',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Plus+Jakarta+Sans:wght@600;700&display=swap" rel="stylesheet">
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-navy font-sans antialiased text-gray-200 flex items-center justify-center min-h-screen">
    
    <div class="w-full max-w-md px-6 py-12 bg-navy-light shadow-2xl sm:rounded-xl border border-gray-border">
        <div class="text-center mb-8 flex flex-col items-center">
            <img src="{{ asset('images/logo.png') }}" alt="Logo cuansampingan" class="h-14 w-auto object-contain mb-3">
            <h1 class="text-3xl font-display font-bold text-gold">cuansampingan</h1>
            <p class="text-sm text-gray-400 mt-2">Admin Control Panel</p>
        </div>
        
        @yield('content')
    </div>

</body>
</html>
