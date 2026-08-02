<header class="w-full h-18 fixed top-0 bg-[#ffffff] border-b border-[#e5e7eb] px-6 flex items-center justify-between z-10 shrink-0">
  
  <!-- Left: Global Search -->
  <div class="relative w-full max-w-md">
    <div class="absolute inset-y-0 left-0 pl-[16px] flex items-center pointer-events-none text-[#6b7280]">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
    </div>
    <input 
      type="text" 
      placeholder="Search invoices, clients, or transactions..." 
      class="w-full bg-[#f9fafb] border border-[#e5e7eb] rounded-[12px] pl-[44px] pr-[16px] py-[10px] font-satoshi text-[14px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:bg-[#ffffff] focus:border-[#5727e7] focus:ring-[1px] focus:ring-[#5727e7] transition-all"
    >
    <!-- Keyboard shortcut hint -->
    <div class="absolute inset-y-0 right-0 pr-[12px] flex items-center pointer-events-none">
      <span class="font-satoshi text-[12px] font-[500] text-[#6b7280] bg-[#ffffff] border border-[#e5e7eb] rounded-[6px] px-[6px] py-[2px] shadow-[0_1px_2px_0_rgba(0,0,0,0.06)]">
        ⌘K
      </span>
    </div>
  </div>
  
  <!-- Right: Quick Actions -->
  <div class="flex items-center gap-[16px]">
    
    <!-- Notifications -->
    <button class="relative w-[40px] h-[40px] flex items-center justify-center rounded-[12px] text-[#4b5563] border border-[#e5e7eb] bg-[#ffffff] hover:bg-[#f9fafb] hover:text-[#030712] transition-colors shadow-[0_1px_2px_0_rgba(0,0,0,0.06)]">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
      <!-- Unread Pulse Indicator -->
      <span class="absolute top-[8px] right-[10px] w-[8px] h-[8px] bg-[#f25330] rounded-full border-[1.5px] border-[#ffffff]"></span>
    </button>

    <!-- Divider -->
    <div class="w-[1px] h-[24px] bg-[#e5e7eb]"></div>
    
    <!-- Quick Add / Create -->
    <button class="bg-[#5727e7] text-[#ffffff] font-satoshi text-[14px] font-[500] px-[16px] py-[10px] rounded-[12px] shadow-[0_1px_2px_0_rgba(0,0,0,0.06)] hover:bg-[#4a1fd4] transition-colors flex items-center gap-[8px]">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
      Create
    </button>
    
  </div>
</header>