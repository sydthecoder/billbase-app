<!DOCTYPE html>
<html lang="en">

<head> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Volt - Free Bootstrap 5 Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    @vite('resources/css/app.css')

    <style>
        [x-cloak] { display: none !important; }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body>        

    <div class="flex">
        <x-layouts.partials.sidebar />
    
        <div class="pl-65">
            <x-layouts.partials.topbar />

            <main class="min-h-[80vh] mt-20">
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
