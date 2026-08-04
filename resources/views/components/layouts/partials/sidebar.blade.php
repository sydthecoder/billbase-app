@php
    $settingsLinks = [
        ['route' => 'settings.general.index', 'active' => 'settings.general.*', 'label' => 'General'],
        ['route' => 'settings.mail.index', 'active' => 'settings.mail.*', 'label' => 'Email'],
        ['route' => 'settings.preferences.index', 'active' => 'settings.preferences.*', 'label' => 'Preferences'],
    ];

    $invoicesLinks = [
        ['route' => 'settings.general.index', 'active' => 'settings.general.*', 'label' => 'One Time'],
        ['route' => 'settings.mail.index', 'active' => 'settings.mail.*', 'label' => 'Recurring'],
    ];

    $productsLinks = [
        ['route' => 'products.index', 'active' => ['products.index', 'products.create', 'products.show', 'products.edit'], 'label' => 'List'],
        ['route' => 'products.categories.index', 'active' => 'products.categories.*', 'label' => 'Categories'],
    ];
@endphp

<aside class="hidden md:flex md:flex-col md:w-65 bg-white fixed top-0 left-0 h-full border-r border-[#e5e7eb]">
    <div class="h-18 flex items-center px-6 border-b border-[#e5e7eb]">
        <a href="{{ url('/') }}">
            <img src="{{ asset('images/brand/logo.png') }}" alt="BillBase Logo" class="h-10">
        </a>
    </div>

    <nav class="flex-1 overflow-y-auto p-6 flex flex-col gap-2">
        <a 
            href="{{ route('dashboard') }}" 
            class="flex items-center gap-3 px-3 py-2.5 rounded-md font-medium transition-colors {{ request()->routeIs('dashboard*') ? 'text-primary-500 bg-primary-50' : 'text-[#4b5563] hover:bg-[#f9fafb] hover:text-primary-500' }}"
        >
            <x-lucide-layout-dashboard class="w-5 h-5" />
            Overview
        </a>

        <div class="flex flex-col gap-1" x-data="{ open: {{ request()->routeIs('settings.*') ? 'true' : 'false' }} }">
            <button 
                @click="open = !open" type="button"
                class="w-full flex items-center justify-between px-3 py-3 rounded-md font-medium text-[#4b5563] transition-colors"
            >
                <div class="flex items-center gap-3">
                    <x-lucide-receipt-text class="w-5 h-5" />
                    Invoices
                </div>

                <x-lucide-chevron-down class="w-5 h-5" />
            </button>

            <div x-show="open" x-transition class="flex flex-col gap-1 pl-9 pr-2">
                @foreach ($invoicesLinks as $link)
                    <a href="{{ route($link['route']) }}"
                       class="block px-3 py-2 rounded-md text-[14px] transition-colors {{ request()->routeIs($link['active']) ? 'font-semibold text-primary-500 bg-primary-50' : 'font-medium text-[#4b5563] hover:text-primary-500 hover:bg-[#f9fafb]' }}">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>
        </div>

        <a 
            href="{{ route('quotes.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-md font-medium transition-colors {{ request()->routeIs('quotess.*') ? 'text-primary-500 bg-[primary-50' : 'text-[#4b5563] hover:bg-[#f9fafb] hover:text-primary-500' }}"
        >
            <x-lucide-file-signature class="w-5 h-5" />
            Quotes
        </a>

        <a 
            href="{{ route('customers.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-md font-medium transition-colors {{ request()->routeIs('customers.*') ? 'text-primary-500 bg-primary-50' : 'text-[#4b5563] hover:bg-[#f9fafb] hover:text-primary-500' }}"
        >
            <x-lucide-users class="w-5 h-5" />
            Customers
        </a>

        <div class="flex flex-col gap-1" x-data="{ open: {{ request()->routeIs('products.*') ? 'true' : 'false' }} }">
            <button 
                @click="open = !open" type="button"
                class="w-full flex items-center justify-between px-3 py-3 rounded-md font-medium text-[#4b5563] transition-colors"
            >
                <div class="flex items-center gap-3">
                    <x-lucide-package class="w-5 h-5" />
                    Products
                </div>

                <x-lucide-chevron-down class="w-5 h-5" />
            </button>

            <div x-show="open" x-transition class="flex flex-col gap-1 pl-9 pr-2">
                @foreach ($productsLinks as $link)
                    <a href="{{ route($link['route']) }}"
                       class="block px-3 py-2 rounded-md text-[14px] transition-colors {{ request()->routeIs($link['active']) ? 'font-semibold text-primary-500 bg-primary-50' : 'font-medium text-[#4b5563] hover:text-primary-500 hover:bg-[#f9fafb]' }}">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="w-full h-px bg-[#e5e7eb] my-2"></div>

        <div class="flex flex-col gap-1" x-data="{ open: {{ request()->routeIs('settings.*') ? 'true' : 'false' }} }">
            <button 
                @click="open = !open" type="button"
                class="w-full flex items-center justify-between px-3 py-3 rounded-md font-medium text-[#4b5563] transition-colors"
            >
                <div class="flex items-center gap-3">
                    <x-lucide-settings class="w-5 h-5" />
                    Settings
                </div>

                <x-lucide-chevron-down class="w-5 h-5" />
            </button>

            <div x-show="open" x-transition class="flex flex-col gap-1 pl-9 pr-2">
                @foreach ($settingsLinks as $link)
                    <a href="{{ route($link['route']) }}"
                       class="block px-3 py-2 rounded-md text-[14px] transition-colors {{ request()->routeIs($link['active']) ? 'font-semibold text-primary-500 bg-primary-50' : 'font-medium text-[#4b5563] hover:text-primary-500 hover:bg-[#f9fafb]' }}">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>
        </div>
    </nav>

    <div class="mt-auto p-4 border-t border-[#e5e7eb]">
        <div class="bg-[#primary-50 border border-primary-500/20 rounded-lg flex items-center gap-3 p-2 rounded-3 hover:bg-[#f9fafb] cursor-pointer transition-colors">
            <div class="w-10 h-10 rounded-[50px] bg-[primary-50 border border-primary-500 flex items-center justify-center text-primary-500 font-semibold text-[14px]">
                {{ Str::substr(auth()->user()->first_name, 0, 1) }}{{ Str::substr(auth()->user()->last_name, 0, 1) }}
            </div>

            <div class="flex flex-col flex-1 overflow-hidden">
                <span class="text-sm font-semibold text-primary-500 truncate">
                    {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                </span>
            </div>
        </div>
    </div>
</aside>