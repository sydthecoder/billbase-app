<x-layouts.app title="Mail Settings">
    <div>
        <div class="max-w-6xl">

            <x-ui.breadcrumb :items="[
                ['label' => 'Settings', 'url' => route('settings.general.index')],
                ['label' => 'Mail'],
            ]" />

            @if ($mailSetting?->is_verified)
                <div class="mb-6 flex items-center gap-2 bg-[#f0fdf4] border border-[#bbf7d0] text-[#15803d] rounded-xl px-4 py-3 text-[14px] font-medium">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                    Mail settings verified
                </div>
            @else
                <div x-data="{ open: true }" x-show="open" class="mb-6 flex items-start gap-3 bg-[#fffbeb] border border-[#fde68a] text-[#92400e] rounded-xl px-4 py-3 text-[14px]">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="flex-shrink-0 mt-[2px]"><path d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/></svg>
                    <div class="flex-1">
                        <span class="font-semibold">Mail not verified!</span> Configure then send a test email.
                    </div>
                    <button type="button" @click="open = false" class="text-[#92400e] hover:text-[#78350f]">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 pb-24">
                <div class="xl:col-span-2">
                    <form
                        method="POST"
                        action="{{ route('settings.mail.update') }}"
                        x-data="{ loading: false }"
                        @submit="loading = true"
                    >
                        @csrf
                        @method('PUT')

                        <div class="bg-white rounded-2xl border border-[#e5e7eb] shadow-md p-6 md:p-8 flex flex-col gap-6">
                            <div>
                                <h3 class="text-[20px] font-bold tracking-tight text-[#030712] mb-1">SMTP</h3>
                                <p class="text-[14px] text-[#6b7280]">Credentials used to send invoices and notifications.</p>
                            </div>

                            <div class="w-full h-px bg-[#e5e7eb]"></div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="flex flex-col gap-2">
                                    <label class="text-[14px] font-medium text-[#030712]" for="from_name">From Name</label>
                                    <input
                                        type="text"
                                        id="from_name"
                                        name="from_name"
                                        placeholder="From Name"
                                        value="{{ old('from_name', $mailSetting?->from_name) }}"
                                        required
                                        class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                                    >
                                </div>

                                <div class="flex flex-col gap-2">
                                    <label class="text-[14px] font-medium text-[#030712]" for="from_email">From Email</label>
                                    <input
                                        type="email"
                                        id="from_email"
                                        name="from_email"
                                        placeholder="From Email"
                                        value="{{ old('from_email', $mailSetting?->from_email) }}"
                                        required
                                        class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                                    >
                                </div>

                                <div class="flex flex-col gap-2">
                                    <label class="text-[14px] font-medium text-[#030712]" for="config_host">SMTP Host</label>
                                    <input
                                        type="text"
                                        id="config_host"
                                        name="config[host]"
                                        placeholder="SMTP Host"
                                        value="{{ old('config.host', $mailSetting?->config['host'] ?? '') }}"
                                        required
                                        class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                                    >
                                </div>

                                <div class="flex flex-col gap-2">
                                    <label class="text-[14px] font-medium text-[#030712]" for="config_port">SMTP Port</label>
                                    <input
                                        type="number"
                                        id="config_port"
                                        name="config[port]"
                                        placeholder="SMTP Port"
                                        value="{{ old('config.port', $mailSetting?->config['port'] ?? '587') }}"
                                        required
                                        class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                                    >
                                </div>

                                <div class="flex flex-col gap-2">
                                    <label class="text-[14px] font-medium text-[#030712]" for="config_encryption">Encryption</label>
                                    <div class="relative">
                                        <select
                                            id="config_encryption"
                                            name="config[encryption]"
                                            class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] appearance-none focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                                        >
                                            @foreach (['tls' => 'TLS', 'ssl' => 'SSL', 'starttls' => 'STARTTLS'] as $value => $label)
                                                <option value="{{ $value }}"
                                                    {{ old('config.encryption', $mailSetting?->config['encryption'] ?? 'tls') === $value ? 'selected' : '' }}>
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
                                    <label class="text-[14px] font-medium text-[#030712]" for="config_username">SMTP Username</label>
                                    <input
                                        type="text"
                                        id="config_username"
                                        name="config[username]"
                                        placeholder="SMTP Username"
                                        value="{{ old('config.username', $mailSetting?->config['username'] ?? '') }}"
                                        required
                                        class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                                    >
                                </div>

                                <div class="flex flex-col gap-2">
                                    <label class="text-[14px] font-medium text-[#030712]" for="config_password">SMTP Password</label>
                                    <input
                                        type="password"
                                        id="config_password"
                                        name="config[password]"
                                        placeholder="{{ $mailSetting ? '***********' : 'SMTP Password' }}"
                                        class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                                    >
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button
                                    class="w-fit bg-primary-500 text-white font-medium px-4 py-2.5 rounded-xl shadow-md hover:bg-[#4a1fd4] transition-colors"
                                    type="submit"
                                    :disabled="loading"
                                >
                                    <x-ui.button-loader />
                                    <span x-text="loading ? 'Saving' : 'Save changes'"></span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="xl:col-span-1">
                    <form
                        method="POST"
                        action="{{ route('settings.mail.test') }}"
                        x-data="{ loading: false }"
                        @submit="loading = true"
                    >
                        @csrf

                        <div class="bg-white rounded-2xl border border-[#e5e7eb] shadow-md p-6 md:p-8 flex flex-col gap-6">
                            <div>
                                <h3 class="text-[20px] font-bold tracking-tight text-[#030712] mb-1">Test Email</h3>
                                <p class="text-[14px] text-[#6b7280]">Confirm your SMTP setup works.</p>
                            </div>

                            <div class="w-full h-px bg-[#e5e7eb]"></div>

                            <div class="flex flex-col gap-2">
                                <label class="text-[14px] font-medium text-[#030712]" for="recipient">Send Email To</label>
                                <input
                                    type="email"
                                    id="recipient"
                                    name="recipient"
                                    placeholder="Recipient"
                                    value="{{ old('recipient', auth()->user()->email) }}"
                                    required
                                    class="w-full bg-white border border-[#d1d5db] rounded-xl px-4 py-3 text-[16px] text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-primary-500 focus:ring-[1px] focus:ring-primary-500 transition-all"
                                >
                            </div>

                            <button
                                class="w-fit bg-white border border-[#d1d5db] text-[#030712] font-medium px-4 py-2.5 rounded-xl hover:bg-[#f9fafb] transition-colors"
                                type="submit"
                                :disabled="loading"
                            >
                                <x-ui.button-loader />
                                <span x-text="loading ? 'Sending' : 'Send test'"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>