<x-layouts.app title="Settings">   
   <!-- <div class="row">
        <div class="col-12 col-xl-8">
            <div class="card card-body border-0 shadow mb-4">
                <h2 class="h5 mb-4">General information</h2>

                <form 
                    method="POST" 
                    action="{{ route('settings.general.update') }}"
                    x-data="{ loading: false }"
                    @submit="loading = true"
                >
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div>
                                <label for="name">Business Name</label>
                                <input 
                                    class="form-control" 
                                    type="text" 
                                    id="name"
                                    name="name"
                                    placeholder="Name" 
                                    value="{{ old('name', $organization->name) }}" 
                                    required
                                />
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div>
                                <label for="reg_number">Registration Number</label>
                                <input 
                                    class="form-control" 
                                    type="text" 
                                    id="reg_number"
                                    name="reg_number"
                                    placeholder="20**/******/**" 
                                    value="{{ old('reg_number', $organization->reg_number) }}"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input 
                                    class="form-control" 
                                    id="email" 
                                    type="email" 
                                    name="email"
                                    placeholder="Email" 
                                    value="{{ old('email', $organization->email) }}"
                                    required
                                />
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input 
                                    class="form-control" 
                                    id="phone" 
                                    name="phone"
                                    type="number" 
                                    placeholder="Phone" 
                                    value="{{ old('phone', $organization->phone) }}"
                                />
                            </div>
                        </div>
                    </div>

                    <h2 class="h5 my-4">Address</h2>
                    <div class="row">
                        <div class="col-sm-7 mb-3">
                            <div class="form-group">
                                <label for="street-address">Street Address</label>
                                <input 
                                    class="form-control" 
                                    id="street-address" 
                                    type="text" 
                                    name="street_address"
                                    placeholder="Street"
                                    value="{{ old('street_address', $organization->street_address) }}" 
                                />
                            </div>
                        </div>

                        <div class="col-sm-5 mb-3">
                            <div class="form-group">
                                <label for="suburb">Suburb</label>
                                <input 
                                    class="form-control" 
                                    id="suburb" 
                                    name="suburb"
                                    type="suburb" 
                                    placeholder="Surburb"
                                    value="{{ old('surburb', $organization->surburb) }}"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 mb-3">
                            <div class="form-group">
                                <label for="city">City</label>
                                <input 
                                    class="form-control" 
                                    id="city" 
                                    name="city"
                                    type="text" 
                                    placeholder="City"
                                    value="{{ old('city', $organization->city) }}" 
                                />
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="postal-code">Postal Code</label>
                                <input 
                                    class="form-control" 
                                    id="postal-code" 
                                    type="tel" 
                                    name="postal_code"
                                    placeholder="Code" 
                                    value="{{ old('postal_code', $organization->postal_code) }}" 
                                />
                            </div>
                        </div>

                        <div class="col-sm-5 mb-3">
                            <label for="province">Province</label>
                            <select 
                                class="form-select w-100 mb-0" 
                                id="province" 
                                name="province" 
                                aria-label="province select example"
                            >
                                <option selected>Province</option>

                                @foreach (config('lookup.provinces') as $code => $label)
                                    <option value="{{ $code }}" {{ old('province', $organization->province) === $code ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button 
                            class="btn btn-gray-800 mt-2" 
                            type="submit"
                            :disabled="loading"
                        >
                            <x-ui.buttons.button-loader  />
                            <span x-text="loading ? 'Saving' : 'Save changes'"></span>
                        </button>
                    </div>
                </form>
            </div>

            <div class="card card-body border-0 shadow mb-4 mb-xl-0">
                <h2 class="h5 mb-4">Alerts & Notifications</h2>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex align-items-center justify-content-between px-0 border-bottom">
                        <div>
                            <h3 class="h6 mb-1">Company News</h3>
                            <p class="small pe-4">Get Rocket news, announcements, and product updates</p>
                        </div>
                        <div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="user-notification-1">
                                <label class="form-check-label" for="user-notification-1"></label>
                            </div>
                        </div>
                    </li>

                    <li class="list-group-item d-flex align-items-center justify-content-between px-0 border-bottom">
                        <div>
                            <h3 class="h6 mb-1">Account Activity</h3>
                            <p class="small pe-4">Get important notifications about you or activity you've missed</p>
                        </div>
                        <div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="user-notification-2" checked>
                                <label class="form-check-label" for="user-notification-2"></label>
                            </div>                                            
                        </div>
                    </li>

                    <li class="list-group-item d-flex align-items-center justify-content-between px-0">
                        <div>
                            <h3 class="h6 mb-1">Meetups Near You</h3>
                            <p class="small pe-4">Get an email when a Dribbble Meetup is posted close to my location</p>
                        </div>
                        <div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="user-notification-3" checked>
                                <label class="form-check-label" for="user-notification-3"></label>
                            </div> 
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card shadow border-0 text-center p-0">                    
                        <div class="card-body">
                            @if ($organization->logo_url)
                                <img src="{{ Storage::url($organization->logo_url) }}" class="avatar-xl border rounded-circle mx-auto mb-4" alt="{{ $organization->name }} Logo">
                            @endif
                            
                            <h4 class="h3">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h4>
                            <h5 class="fw-normal mb-4">{{ auth()->user()->role }}</h5>
                            
                            <a class="btn btn-sm btn-gray-800 d-inline-flex align-items-center me-2" href="#">
                                <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"></path></svg>
                                My Profle
                            </a>

                            <form class="d-inline-flex" id="logo-form" method="POST" action="{{ route('settings.general.logo') }}" enctype="multipart/form-data">
                                @csrf

                                <label class="btn btn-sm btn-secondary" for="logo">
                                    Upload Logo
                                </label>
                                <input type="file" id="logo" name="logo" accept="image/*" class="d-none" />
                            </form>

                            <script>
                                document.getElementById('logo').addEventListener('change', function () {
                                    document.getElementById('logo-form').submit();
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.co.za/ajax/libs/cleave.js/1.6.0/cleave.min.js"></script>
        <script>
            new Cleave('#reg_number', {
                delimiters: ['/', '/'],
                blocks: [4, 6, 2],
                numericOnly: true,
            });
        </script>
    @endpush -->

    <div>
        <div class="max-w-4xl">
            
            <x-ui.breadcrumb :items="[
                ['label' => 'Settings', 'url' => route('settings.general.index')],
                ['label' => 'General'],
            ]" />

            <form 
                method="POST" 
                action="{{ route('settings.general.update') }}"
                x-data="{ loading: false }"
                @submit="loading = true"
                class="flex flex-col gap-8"
            >
                @csrf
                @method('PUT')

                <div class="bg-[#ffffff] rounded-2xl border border-[#e5e7eb] shadow-md p-6 md:p-8 flex flex-col gap-6">
                    <div>
                        <h3 class="text-[20px] font-bold tracking-tight text-[#030712] mb-1">Brand Identity</h3>
                        <p class="text-[14px] text-[#6b7280]">Your logo and primary company name.</p>
                    </div>
                    
                    <div class="w-full h-px bg-[#e5e7eb]"></div>

                    <div class="flex items-center gap-6">
                        <div class="w-20 h-20 bg-[#f9fafb] border border-dashed border-[#d1d5db] rounded-xl flex flex-col items-center justify-center text-[#6b7280] hover:bg-[#f2f2ff] hover:border-[#5727e7] hover:text-[#5727e7] cursor-pointer transition-colors flex-shrink-0">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mb-[4px]"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                        </div>

                        <div class="flex flex-col gap-1">
                            <span class="text-[14px] font-medium text-[#030712]">Upload Company Logo</span>
                            <span class="text-[14px] text-[#4b5563]">Maximum 1mb size.</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex flex-col gap-2">
                            <label class="text-[14px] font-medium text-[#030712]">Company Name</label>
                            <input 
                                type="text" 
                                class="w-full bg-[#ffffff] border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-[#5727e7] focus:ring-[1px] focus:ring-[#5727e7] transition-all"
                                value="{{ old('name', $organization->name) }}" 
                            >
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="text-[14px] font-medium text-[#030712]" for="reg_number">Registration Number</label>
                            <input 
                                type="text" 
                                id="reg_number"
                                name="reg_number"
                                value="{{ old('reg_number', $organization->reg_number) }}"
                                placeholder="20**/******/**"
                                class="w-full bg-[#ffffff] border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-[#5727e7] focus:ring-[1px] focus:ring-[#5727e7] transition-all"
                            >
                        </div>
                    </div>
                </div>

                <div class="bg-[#ffffff] rounded-2xl border border-[#e5e7eb] shadow-md p-6 md:p-8 flex flex-col gap-6">
                    <div>
                        <h3 class="text-[20px] font-bold tracking-tight text-[#030712] mb-1">Contact Details</h3>
                        <p class="text-[14px] text-[#6b7280]">Where clients should direct their inquiries.</p>
                    </div>
                    
                    <div class="w-full h-px bg-[#e5e7eb]"></div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex flex-col gap-2">
                            <label class="text-[14px] font-medium text-[#030712]">Billing Email Address</label>
                            <input 
                                type="email" 
                                value="{{ old('email', $organization->email) }}"
                                placeholder="name@company.co.za"
                                class="w-full bg-[#ffffff] border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-[#5727e7] focus:ring-[1px] focus:ring-[#5727e7] transition-all"
                            >
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="text-[14px] font-medium text-[#030712]">Phone Number</label>
                            <input 
                                type="tel" 
                                placeholder="015 456 3***"
                                class="w-full bg-[#ffffff] border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-[#5727e7] focus:ring-[1px] focus:ring-[#5727e7] transition-all"
                            >
                        </div>
                        
                        <div class="flex flex-col gap-2 md:col-span-2">
                            <label class="text-[14px] font-medium text-[#030712]">Company Website</label>
                            <input 
                                type="url" 
                                placeholder="https://company.co.za"
                                class="w-full bg-[#ffffff] border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-[#5727e7] focus:ring-[1px] focus:ring-[#5727e7] transition-all"
                            >
                        </div>
                    </div>
                </div>

                <div class="bg-[#ffffff] rounded-2xl border border-[#e5e7eb] shadow-md p-6 md:p-8 flex flex-col gap-6">
                    <div>
                        <h3 class="text-[20px] font-bold tracking-tight text-[#030712] mb-1">Registered Address</h3>
                        <p class="text-[14px] text-[#6b7280]">The physical location of your business.</p>
                    </div>
                    
                    <div class="w-full h-px bg-[#e5e7eb]"></div>

                    <div class="flex flex-col gap-6">
                        <div class="flex flex-col gap-2">
                            <label class="text-[14px] font-medium text-[#030712]">Street Address</label>
                            <input 
                                type="text" 
                                value="{{ old('street_address', $organization->street_address) }}" 
                                placeholder="123 Business Rd, Suite 100"
                                class="w-full bg-[#ffffff] border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-[#5727e7] focus:ring-[1px] focus:ring-[#5727e7] transition-all"
                            >
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex flex-col gap-2">
                                <label class="text-[14px] font-medium text-[#030712]">City</label>
                                <input 
                                    type="text" 
                                    value="{{ old('city', $organization->city) }}"
                                    placeholder="Metropolis"
                                    class="w-full bg-[#ffffff] border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-[#5727e7] focus:ring-[1px] focus:ring-[#5727e7] transition-all"
                                >
                            </div>

                            <div class="flex flex-col gap-2">
                                <label class="text-[14px] font-medium text-[#030712]">Postal Code</label>
                                <input 
                                    type="text" 
                                    value="{{ old('postal_code', $organization->postal_code) }}"
                                    placeholder="10001"
                                    class="w-full bg-[#ffffff] border border-[#d1d5db] rounded-xl px-4 py-3 text-4 text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-[#5727e7] focus:ring-[1px] focus:ring-[#5727e7] transition-all"
                                >
                            </div>

                            <div class="flex flex-col gap-2">
                                <label class="text-[14px] font-medium text-[#030712]">State / Province</label>
                                <div class="relative"> 
                                    <select 
                                        class="w-full bg-[#ffffff] border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] appearance-none focus:outline-none focus:border-[#5727e7] focus:ring-[1px] focus:ring-[#5727e7] transition-all" 
                                        id="province" 
                                        name="province" 
                                        aria-label="province select example"
                                    >
                                        <option selected>Province</option>

                                        @foreach (config('lookup.provinces') as $code => $label)
                                            <option value="{{ $code }}" {{ old('province', $organization->province) === $code ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-[#6b7280]">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col gap-2">
                                <label class="text-[14px] font-medium text-[#030712]">Country</label>
                                <div class="relative">
                                    <select class="w-full bg-[#ffffff] border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] appearance-none focus:outline-none focus:border-[#5727e7] focus:ring-[1px] focus:ring-[#5727e7] transition-all">
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

            <div class="fixed bottom-0 right-0 left-65 bg-white shadow-lg px-6 py-4 border border-[#e5e7eb]">
                    <div class="flex justify-end">
                        <button 
                            class="w-fit bg-[#5727e7] text-[#ffffff] text-[14px] font-medium px-4 py-2.5 rounded-xl shadow-md hover:bg-[#4a1fd4] transition-colors" 
                            type="submit"
                            :disabled="loading"
                        >
                            <x-ui.buttons.button-loader  />
                            <span x-text="loading ? 'Saving' : 'Save changes'"></span>
                        </button>
                    </div>
            </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.co.za/ajax/libs/cleave.js/1.6.0/cleave.min.js"></script>
        <script>
            new Cleave('#reg_number', {
                delimiters: ['/', '/'],
                blocks: [4, 6, 2],
                numericOnly: true,
            });
        </script>
    @endpush 
</x-layouts.app>