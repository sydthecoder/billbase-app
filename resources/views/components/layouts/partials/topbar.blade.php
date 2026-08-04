<header class="right-0 left-0 md:left-65 h-18 fixed top-0 bg-white border-b border-[#e5e7eb] px-6 flex items-center justify-between z-10 shrink-0">

    <div class="inline-flex gap-6 w-full">
        <button class="text-[#6b7280]">
            <x-lucide-menu class="h-8 w-8" />
        </button>

        <div class="hidden md:flex relative w-full max-w-xs">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#6b7280]">
                <x-lucide-search class="h-5 w-5" />    
            </div>

            <input 
                type="text" 
                placeholder="Search dashboard" 
                class="w-full bg-[#ffffff] border border-[#d1d5db] rounded-lg pl-11 pr-4 py-3 text-dark-500 placeholder-[#6b7280] focus:outline-none focus:border-primary-500 focus:ring-px focus:ring-primary-500 transition-all"
            >
        </div>
    </div>
    
    <div class="flex items-center gap-4">
        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
            <button
                @click="open = !open"
                class="bg-primary-500 text-white font-medium px-4 py-2.5 rounded-xl shadow-md hover:bg-primary-600 transition-colors inline-flex items-center gap-2"
            >
                <x-lucide-plus class="h-5 w-5" />
                Create
            </button>

            <div
                x-show="open"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute right-0 mt-2 w-50 bg-white border border-gray-200 rounded-lg shadow-lg py-2 z-50"
                style="display: none;"
            >
                <a href="{{ route('customers.create') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-[#4b5563] hover:bg-[#f9fafb] hover:text-primary-500 transition-colors">
                    <x-lucide-user class="w-4 h-4" />
                    New Customer
                </a>

                <a href="{{ route('products.create') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-[#4b5563] hover:bg-[#f9fafb] hover:text-primary-500 transition-colors">
                    <x-lucide-package class="w-4 h-4" />
                    New Product
                </a>

                <a href="{{ route('quotes.create') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-[#4b5563] hover:bg-[#f9fafb] hover:text-primary-500 transition-colors">
                    <x-lucide-file-signature class="w-4 h-4" />
                    New Quote
                </a>

                <a href="{{ route('invoices.create') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-[#4b5563] hover:bg-[#f9fafb] hover:text-primary-500 transition-colors">
                    <x-lucide-receipt-text class="w-4 h-4" />
                    New Invoice
                </a>
            </div>
        </div>

        <form 
            method="POST" 
            action="{{ route('logout') }}"
        >
            @csrf
            
            <button 
                type="submit"
                class="relative w-10 h-10 flex items-center justify-center rounded-xl text-[#4b5563] border border-[#e5e7eb] bg-white hover:bg-red-500 hover:text-white transition-colors shadow-md"
            >
                <x-lucide-log-out class="h-5 w-5" />    
            </button>
        </form>
    </div>
</header>