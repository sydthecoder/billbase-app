<!DOCTYPE html>
<html lang="en">

<head> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Volt - Free Bootstrap 5 Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    @vite('resources/css/app.css')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geomini:wght@200..800&display=swap" rel="stylesheet">

    <style>
        [x-cloak] { display: none !important; }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body>        

    <div>
        <x-layouts.partials.sidebar />
    
        <div class="md:pl-65">
            <x-layouts.partials.topbar />

            <main class="min-h-[80vh] mt-16 p-6">
                {{ $slot }}
            </main>
            
            <x-layouts.partials.footer />
        </div> 
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/notyf/3.10.0/notyf.min.js"></script>
    @stack('scripts')
    <script src="{{ asset('js/main.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const notyf = new Notyf({
                position: {
                    x: 'center',
                    y: 'bottom',
                }
            });

            @if (session('success'))
                notyf.success("{{ session('success') }}");
            @endif

            @if ($errors->any())
                notyf.error("Something went wrong.");
            @endif
        });
    </script>
</body>
</html>
