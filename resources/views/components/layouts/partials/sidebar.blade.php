@php
    $settingsLinks = [
        ['route' => 'settings.general.index', 'active' => 'settings.general.*', 'label' => 'General'],
        ['route' => 'settings.mail.index', 'active' => 'settings.mail.*', 'label' => 'Email'],
        ['route' => 'settings.preferences.index', 'active' => 'settings.preferences.*', 'label' => 'Preferences'],
    ];
@endphp

<aside class="hidden md:block md:w-65 bg-white fixed top-0 left-0 h-full border-r border-[#e5e7eb]">
    <div class="h-18 flex items-center px-6 border-b border-[#e5e7eb]">
        <a href="{{ url('/') }}">
            <img src="{{ asset('logo.png') }}" alt="BillBase" class="h-12">
        </a>
    </div>

    <nav class="flex-1 overflow-y-auto p-6 flex flex-col gap-2">
        <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-3 text-[16px] font-medium text-[#4b5563] hover:bg-[#f9fafb] hover:text-[#030712] transition-colors">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            Overview
        </a>

        <a href="{{ route('invoices.index') }}"
           class="flex items-center justify-between px-3 py-2.5 rounded-3 text-[16px] font-medium transition-colors {{ request()->routeIs('invoices.*') ? 'text-[#030712] bg-[#f2f2ff]' : 'text-[#4b5563] hover:bg-[#f9fafb] hover:text-[#030712]' }}">
            <div class="flex items-center gap-3">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line></svg>
                Invoices
            </div>
            <span class="bg-[#f2f2ff] text-[#5727e7] text-3 px-2 py-0.5 rounded-md font-semibold">14</span>
        </a>

        <a href="{{ route('customers.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-3 text-[16px] font-medium transition-colors {{ request()->routeIs('customers.*') ? 'text-[#030712] bg-[#f2f2ff]' : 'text-[#4b5563] hover:bg-[#f9fafb] hover:text-[#030712]' }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            Customers
        </a>

        <div class="w-full h-px bg-[#e5e7eb] my-2"></div>

        <div class="flex flex-col gap-1" x-data="{ open: {{ request()->routeIs('settings.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" type="button"
                    class="w-full flex items-center justify-between px-3 py-3 rounded-3 text-[16px] font-semibold text-[#030712] transition-colors">
                <div class="flex items-center gap-3">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                    Settings
                </div>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     class="transition-transform" :class="open ? 'rotate-180' : ''">
                    <path d="M6 9l6 6 6-6"/>
                </svg>
            </button>

            <div x-show="open" x-transition class="flex flex-col gap-1 pl-9 pr-2">
                @foreach ($settingsLinks as $link)
                    <a href="{{ route($link['route']) }}"
                       class="block px-3 py-2 rounded-md text-[14px] transition-colors {{ request()->routeIs($link['active']) ? 'font-semibold text-[#5727e7] bg-[#f2f2ff]' : 'font-medium text-[#4b5563] hover:text-[#030712] hover:bg-[#f9fafb]' }}">
                        {{ $link['label'] }}
                    </a>
                @endforeach

                <a href="#" class="block px-3 py-2 rounded-md text-[14px] font-medium text-[#4b5563] hover:text-[#030712] hover:bg-[#f9fafb] transition-colors">
                    Team Members
                </a>
            </div>
        </div>
    </nav>

    <div class="p-4 border-t border-[#e5e7eb]">
        <div class="bg-[#f2f2ff] border border-[#5727e7]/20 rounded-lg flex items-center gap-3 p-2 rounded-3 hover:bg-[#f9fafb] cursor-pointer transition-colors">
            <div class="w-10 h-10 rounded-[50px] bg-[#f2f2ff] border border-[#5727e7] flex items-center justify-center text-[#5727e7] font-semibold text-[14px]">
                {{ Str::substr(auth()->user()->first_name, 0, 1) }}{{ Str::substr(auth()->user()->last_name, 0, 1) }}
            </div>

            <div class="flex flex-col flex-1 overflow-hidden">
                <span class="text-sm font-semibold text-[#030712] truncate">
                    {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                </span>
            </div>
        </div>
    </div>
</aside>