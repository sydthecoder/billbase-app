<div class="row">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js"></script>
    <script>
        new Cleave('#reg_number', {
            delimiters: ['/', '/'],
            blocks: [4, 6, 2],
            numericOnly: true,
        });
    </script>
@endpush