<x-layouts.app title="Mail Settings">     
    <div class="row">
        <x-ui.breadcrumb :items="[
            ['label' => 'Settings', 'url' => route('settings.general.index')],
            ['label' => 'Mail'],
        ]" />

        <div class="col-12">
            <div class="col-6">
                @if ($mailSetting?->is_verified)
                    <p style="color: green;">✓ Mail settings verified</p>
                @else
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <span class="fas fa-bullhorn me-1"></span>
                        <strong>Mail Not verified!</strong> Configure then send a test email

                        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-12 col-xl-8">
            <div class="card card-body border-0 shadow mb-4">
                <h2 class="h5 mb-4">SMTP</h2>

                <form 
                    method="POST" 
                    action="{{ route('settings.mail.update') }}"
                    x-data="{ loading: false }"
                    @submit="loading = true"
                >
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div>
                                <label for="from_name">From Name</label>
                                <input 
                                    class="form-control" 
                                    type="text" 
                                    id="from_name"
                                    name="from_name"
                                    placeholder="From Name" 
                                    value="{{ old('from_name', $mailSetting?->from_name) }}" 
                                    required
                                />
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div>
                                <label for="from_email">From Email</label>
                                <input 
                                    class="form-control" 
                                    type="email" 
                                    id="from_email"
                                    name="from_email"
                                    placeholder="From Email" 
                                    value="{{ old('from_email', $mailSetting?->from_email) }}"
                                    required
                                />
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div>
                                <label for="config_host">SMTP Host</label>
                                <input 
                                    class="form-control" 
                                    type="text" 
                                    id="config_host"
                                    name="config[host]"
                                    placeholder="SMTP Host" 
                                    value="{{ old('config.host', $mailSetting?->config['host'] ?? '') }}"
                                    required
                                />
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div>
                                <label for="config_port">SMTP Port</label>
                                <input 
                                    class="form-control" 
                                    type="number" 
                                    id="config_port"
                                    name="config[port]"
                                    placeholder="SMTP Port" 
                                    value="{{ old('config.port', $mailSetting?->config['port'] ?? '587') }}"
                                    required
                                />
                            </div>
                        </div>

                        <div class="col-sm-6 mb-3">
                            <label for="config_encryption">config_encryption</label>
                            <select 
                                class="form-select w-100 mb-0" 
                                id="config_encryption" 
                                name="config[encryption]" 
                            >
                                <option selected>Province</option>

                                @foreach (['tls' => 'TLS', 'ssl' => 'SSL', 'starttls' => 'STARTTLS'] as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old('config.encryption', $mailSetting?->config['encryption'] ?? 'tls') === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div>
                                <label for="config_username">SMTP Username</label>
                                <input 
                                    class="form-control" 
                                    type="text" 
                                    id="config_username"
                                    name="config[username]"
                                    placeholder="SMTP Username" 
                                    value="{{ old('config.username', $mailSetting?->config['username'] ?? '') }}"
                                    required
                                />
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div>
                                <label for="config_password">SMTP Password</label>
                                <input 
                                    class="form-control" 
                                    type="text" 
                                    id="config_password"
                                    name="config[password]"
                                    placeholder="{{ $mailSetting ? '***********' : 'SMTP Password' }}" 
                                />
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button 
                            class="btn btn-gray-800 mt-2" 
                            type="submit"
                            :disabled="loading"
                        >
                            <x-ui.button-loader  />
                            <span x-text="loading ? 'Saving' : 'Save changes'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <div class="card card-body border-0 shadow mb-4">
                <h2 class="h5 mb-4">Test Email</h2>

                <form 
                    method="POST" 
                    action="{{ route('settings.mail.test') }}"
                    x-data="{ loading: false }"
                    @submit="loading = true"
                >
                    @csrf

                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <label for="recipient">Send Email To</label>
                                <input 
                                    class="form-control" 
                                    type="email" 
                                    id="recipient"
                                    name="recipient"
                                    placeholder="Recipient" 
                                    value="{{ old('recipient', auth()->user()->email) }}" 
                                    required
                                />
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button 
                            class="btn btn-secondary mt-2" 
                            type="submit"
                            :disabled="loading"
                        >
                            <x-ui.button-loader  />
                            <span x-text="loading ? 'Sending' : 'Save Test'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app> 