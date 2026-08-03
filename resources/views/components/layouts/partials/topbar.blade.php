<header class="right-0 left-0 md:left-65 h-18 fixed top-0 bg-white border-b border-[#e5e7eb] px-6 flex items-center justify-between z-10 shrink-0">
  
    <div class="relative w-full max-w-xs">
        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#6b7280]">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        </div>

        <input 
            type="text" 
            placeholder="Search dashboard" 
            class="w-full bg-[#f9fafb] border border-[#e5e7eb] rounded-xl pl-11 pr-4 py-2.5 text-[14px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:bg-white focus:border-[#008374] focus:ring-[1px] focus:ring-[#008374] transition-all"
        >

        <div class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
            <span class= text-lg font-medium text-[#6b7280] bg-white border border-[#e5e7eb] rounded-md px-1.5 py-05 shadow-md">
                ⌘K
            </span>
        </div>
    </div>
    
    <div class="flex items-center gap-4">
        <button class="bg-primary-500 text-white font-medium px-4 py-2.5 rounded-xl shadow-md hover:bg-primary-600 transition-colors inline-flex items-center gap-2">
            <x-lucide-plus class="h-5 w-5" />
            Create
        </button>

        <div class="w-0.5 h-8 bg-[#e5e7eb]"></div>

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