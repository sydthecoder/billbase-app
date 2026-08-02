@php
    $navItems = [
        [
            'label' => 'Dashboard',
            'route' => 'dashboard',
            'icon'  => '<path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>',
        ],
        [
            'label' => 'Customers',
            'route' => 'customers.index',
            'icon'  => '<path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>',
        ],
        [
            'label' => 'Products',
            'route' => 'products.index',
            'icon'  => '<path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path>',
        ],
        [
            'label' => 'Invoices',
            'route' => 'invoices.index',
            'icon'  => '<path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>',
        ],
        [
            'label' => 'Recurring Invoices',
            'route' => 'invoices.index',
            'icon'  => '<path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>',
        ],
        [
            'label' => 'Quotes',
            'route' => 'quotes.index',
            'icon'  => '<path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>',
        ],
    ];

    $settingsItems = [
        ['label' => 'General',         'route' => 'settings.index'],
        ['label' => 'Mail',            'route' => 'settings.index'],
        ['label' => 'Payment Gateway', 'route' => 'settings.index'],
        ['label' => 'Bank Account',    'route' => 'settings.index'],
    ];

    $settingsActive = request()->routeIs('settings.*');
@endphp

<aside class="w-65 bg-white fixed top-0 left-0 h-full border-r border-[#e5e7eb]">
    <div class="h-18 flex items-center px-6 border-b border-[#e5e7eb]">
        <a href="">
            <img src="{{ asset('logo.png') }}" alt="BillBase" class="h-12">
        </a>
    </div>

    <nav class="flex-1 overflow-y-auto p-6 flex flex-col gap-2">
        <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-3 text-[16px] font-medium text-[#4b5563] hover:bg-[#f9fafb] hover:text-[#030712] transition-colors">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            Overview
        </a>

        <a href="#" class="flex items-center justify-between px-3 py-2.5 rounded-3 text-[16px] font-medium text-[#4b5563] hover:bg-[#f9fafb] hover:text-[#030712] transition-colors">
            <div class="flex items-center gap-3">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line></svg>
            Invoices
            </div>
            <span class="bg-[#f2f2ff] text-[#5727e7] text-3 px-2 py-0.5 rounded-md font-semibold">14</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-3 text-[16px] font-medium text-[#4b5563] hover:bg-[#f9fafb] hover:text-[#030712] transition-colors">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            Clients
        </a>
        
        <div class="w-full h-px bg-[#e5e7eb] my-2"></div>
        
        <div class="flex flex-col gap-1">
            <button class="w-full flex items-center justify-between px-3 py-3 rounded-3 text-[16px] font-semibold text-[#030712] transition-colors">
                <div class="flex items-center gap-3">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                    Settings
                </div>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="transform rotate-180 transition-transform"><path d="M6 9l6 6 6-6"/></svg>
            </button>
            
            <div class="flex flex-col gap-1 pl-9 pr-2">
                <a href="#" class="block px-3 py-2 rounded-md text-[14px] font-semibold text-[#5727e7] bg-[#f2f2ff] transition-colors">
                    General
                </a>

                <a href="#" class="block px-3 py-2 rounded-md text-[14px] font-medium text-[#4b5563] hover:text-[#030712] hover:bg-[#f9fafb] transition-colors">
                    Delivery & Security
                </a>

                <a href="#" class="block px-3 py-2 rounded-md text-[14px] font-medium text-[#4b5563] hover:text-[#030712] hover:bg-[#f9fafb] transition-colors">
                    Payment Gateways
                </a>

                <a href="#" class="block px-3 py-2 rounded-md text-[14px] font-medium text-[#4b5563] hover:text-[#030712] hover:bg-[#f9fafb] transition-colors">
                    Team Members
                </a>
            </div>
        </div>
    </nav>
        
    <div class="p-4 border-t border-[#e5e7eb]">
        <div class="bg-[#f2f2ff] border border-[#5727e7]/20 rounded-lg flex items-center gap-3 p-2 rounded-3 hover:bg-[#f9fafb] cursor-pointer transition-colors">
            <div class="w-10 h-10 rounded-[50px] bg-[#f2f2ff] border border-[#5727e7] flex items-center justify-center text-[#5727e7] font-semibold text-[14px]">RS</div>
            
            <div class="flex flex-col flex-1 overflow-hidden">
                <span class="text-sm font-semibold text-[#030712] truncate">
                    {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                </span>
            </div>
        </div>
    </div>
</aside>