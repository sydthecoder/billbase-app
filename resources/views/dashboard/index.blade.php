<x-layouts.app title="Dashboard">
    <div class="flex-1 overflow-y-auto p-[32px] md:p-[48px]">
      <div class="max-w-[800px] mx-auto">
        
        <!-- Header Stack -->
        <div class="mb-[40px]">
          <h2 class="text-[32px] font-[700] text-[#030712] leading-[1.3] mb-[8px]">Company Details</h2>
          <p class="text-[16px] font-[400] text-[#4b5563] leading-[1.5]">
            Manage your company profile, branding, and core information displayed on all invoices.
          </p>
        </div>

        <!-- Settings Form Container -->
        <div class="flex flex-col gap-[32px]">

          <!-- Card: Company Profile -->
          <div class="bg-[#ffffff] rounded-[16px] border border-[#e5e7eb] shadow-[0_4px_16px_0_rgba(0,0,0,0.06)] p-[24px] md:p-[32px] flex flex-col gap-[24px]">
            <div>
              <h3 class="text-[20px] font-[600] text-[#030712] mb-[4px]">Brand Identity</h3>
              <p class="text-[14px] text-[#6b7280]">Your logo and primary company name.</p>
            </div>
            
            <div class="w-full h-[1px] bg-[#e5e7eb]"></div>

            <div class="flex items-center gap-[24px]">
              <!-- Logo Upload Area -->
              <div class="w-[80px] h-[80px] bg-[#f9fafb] border border-dashed border-[#d1d5db] rounded-[16px] flex flex-col items-center justify-center text-[#6b7280] hover:bg-[#f2f2ff] hover:border-[#5727e7] hover:text-[#5727e7] cursor-pointer transition-colors flex-shrink-0">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mb-[4px]"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
              </div>
              <div class="flex flex-col gap-[4px]">
                <span class="text-[14px] font-[600] text-[#030712]">Upload Company Logo</span>
                <span class="text-[14px] text-[#4b5563]">Recommended size: 512x512px (PNG or JPG).</span>
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-[24px]">
              <div class="flex flex-col gap-[8px]">
                <label class="text-[14px] font-[600] text-[#030712]">Legal Company Name</label>
                <input 
                  type="text" 
                  value="Acme Corp LLC"
                  class="w-full bg-[#ffffff] border border-[#d1d5db] rounded-[12px] px-[16px] py-[12px] text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-[#5727e7] focus:ring-[1px] focus:ring-[#5727e7] transition-all"
                >
              </div>

              <div class="flex flex-col gap-[8px]">
                <label class="text-[14px] font-[600] text-[#030712]">Tax / VAT Number</label>
                <input 
                  type="text" 
                  placeholder="e.g. GB123456789"
                  class="w-full bg-[#ffffff] border border-[#d1d5db] rounded-[12px] px-[16px] py-[12px] text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-[#5727e7] focus:ring-[1px] focus:ring-[#5727e7] transition-all"
                >
              </div>
            </div>
          </div>

          <!-- Card: Contact Information -->
          <div class="bg-[#ffffff] rounded-[16px] border border-[#e5e7eb] shadow-[0_4px_16px_0_rgba(0,0,0,0.06)] p-[24px] md:p-[32px] flex flex-col gap-[24px]">
            <div>
              <h3 class="text-[20px] font-[600] text-[#030712] mb-[4px]">Contact Details</h3>
              <p class="text-[14px] text-[#6b7280]">Where clients should direct their inquiries.</p>
            </div>
            
            <div class="w-full h-[1px] bg-[#e5e7eb]"></div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-[24px]">
              <div class="flex flex-col gap-[8px]">
                <label class="text-[14px] font-[600] text-[#030712]">Billing Email Address</label>
                <input 
                  type="email" 
                  value="billing@acmecorp.com"
                  class="w-full bg-[#ffffff] border border-[#d1d5db] rounded-[12px] px-[16px] py-[12px] text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-[#5727e7] focus:ring-[1px] focus:ring-[#5727e7] transition-all"
                >
              </div>

              <div class="flex flex-col gap-[8px]">
                <label class="text-[14px] font-[600] text-[#030712]">Phone Number</label>
                <input 
                  type="tel" 
                  placeholder="+1 (555) 000-0000"
                  class="w-full bg-[#ffffff] border border-[#d1d5db] rounded-[12px] px-[16px] py-[12px] text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-[#5727e7] focus:ring-[1px] focus:ring-[#5727e7] transition-all"
                >
              </div>
              
              <div class="flex flex-col gap-[8px] md:col-span-2">
                <label class="text-[14px] font-[600] text-[#030712]">Company Website</label>
                <input 
                  type="url" 
                  placeholder="https://acmecorp.com"
                  class="w-full bg-[#ffffff] border border-[#d1d5db] rounded-[12px] px-[16px] py-[12px] text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-[#5727e7] focus:ring-[1px] focus:ring-[#5727e7] transition-all"
                >
              </div>
            </div>
          </div>

          <!-- Card: Business Address -->
          <div class="bg-[#ffffff] rounded-[16px] border border-[#e5e7eb] shadow-[0_4px_16px_0_rgba(0,0,0,0.06)] p-[24px] md:p-[32px] flex flex-col gap-[24px]">
            <div>
              <h3 class="text-[20px] font-[600] text-[#030712] mb-[4px]">Registered Address</h3>
              <p class="text-[14px] text-[#6b7280]">The physical location of your business.</p>
            </div>
            
            <div class="w-full h-[1px] bg-[#e5e7eb]"></div>

            <div class="flex flex-col gap-[24px]">
              <div class="flex flex-col gap-[8px]">
                <label class="text-[14px] font-[600] text-[#030712]">Street Address</label>
                <input 
                  type="text" 
                  placeholder="123 Business Rd, Suite 100"
                  class="w-full bg-[#ffffff] border border-[#d1d5db] rounded-[12px] px-[16px] py-[12px] text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-[#5727e7] focus:ring-[1px] focus:ring-[#5727e7] transition-all"
                >
              </div>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-[24px]">
                <div class="flex flex-col gap-[8px]">
                  <label class="text-[14px] font-[600] text-[#030712]">City</label>
                  <input 
                    type="text" 
                    placeholder="Metropolis"
                    class="w-full bg-[#ffffff] border border-[#d1d5db] rounded-[12px] px-[16px] py-[12px] text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-[#5727e7] focus:ring-[1px] focus:ring-[#5727e7] transition-all"
                  >
                </div>

                <div class="flex flex-col gap-[8px]">
                  <label class="text-[14px] font-[600] text-[#030712]">State / Province</label>
                  <input 
                    type="text" 
                    placeholder="NY"
                    class="w-full bg-[#ffffff] border border-[#d1d5db] rounded-[12px] px-[16px] py-[12px] text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-[#5727e7] focus:ring-[1px] focus:ring-[#5727e7] transition-all"
                  >
                </div>
                
                <div class="flex flex-col gap-[8px]">
                  <label class="text-[14px] font-[600] text-[#030712]">Postal Code</label>
                  <input 
                    type="text" 
                    placeholder="10001"
                    class="w-full bg-[#ffffff] border border-[#d1d5db] rounded-[12px] px-[16px] py-[12px] text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-[#5727e7] focus:ring-[1px] focus:ring-[#5727e7] transition-all"
                  >
                </div>

                <div class="flex flex-col gap-[8px]">
                  <label class="text-[14px] font-[600] text-[#030712]">Country</label>
                  <div class="relative">
                    <select class="w-full bg-[#ffffff] border border-[#d1d5db] rounded-[12px] px-[16px] py-[12px] text-[16px] text-[#030712] appearance-none focus:outline-none focus:border-[#5727e7] focus:ring-[1px] focus:ring-[#5727e7] transition-all">
                      <option>United States</option>
                      <option>United Kingdom</option>
                      <option>Canada</option>
                      <option selected>South Africa</option>
                      <option>Australia</option>
                    </select>
                    <div class="absolute right-[16px] top-1/2 -translate-y-1/2 pointer-events-none text-[#6b7280]">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
          </div>
          
        </div>
      </div>
    </div>
</x-layouts.app>
