<x-layouts.auth title="Login">
    <section class="w-full min-h-screen bg-[#f9fafb] flex flex-col items-center justify-center px-6 py-16">
        
        <a href="#" class="mb-8">
            <img src="{{ asset('logo.png') }}" alt="" class="h-12">
        </a>

        <div class="w-full max-w-md bg-[#ffffff] rounded-2xl border border-[#e5e7eb] shadow-lg p-6 md:p-10">
            
            <div class="text-center mb-8">
                <h1 class="text-[32px] font-bold text-[#030712] leading-[1.3] mb-2">
                    Register
                </h1>
            </div>

            <a href="{{ route('auth.google') }}" class="w-full bg-[#ffffff] border border-[#e5e7eb] text-[#030712] font-medium px-6 py-3 rounded-lg shadow-sm hover:bg-[#f9fafb] transition-colors flex items-center justify-center gap-2 mb-6">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                Continue with Google
            </a>

            <div class="flex items-center gap-4 mb-6">
                <div class="flex-1 h-px bg-[#e5e7eb]"></div>
                <span class="text-[14px] text-[#6b7280]">or log in with email</span>
                <div class="flex-1 h-px bg-[#e5e7eb]"></div>
            </div>

            <form 
                method="POST" 
                action="{{ route('register') }}" 
                class="space-y-6"
                x-data="{ loading: false }"
                @submit="loading = true"
            >
                @csrf
            
                <div class="flex flex-col gap-2">
                    <label for="email" class="text-[14px] font-medium text-[#030712]">Work Email</label>
                    <input 
                        name="email" 
                        type="email" 
                        value="{{ old('email') }}" 
                        id="email" 
                        placeholder="name@company.com" 
                        class="w-full bg-[#ffffff] border border-[#d1d5db] rounded-lg px-4 py-3 text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-[#5727e7] focus:ring-px focus:ring-[#5727e7] transition-all"
                    >
                </div>

                <div class="flex flex-col gap-2">
                    <div class="flex items-center justify-between">
                        <label for="password" class="text-[14px] text-[#030712]">Password</label>
                        <a href="#" class="text-[14px] text-[#5727e7] hover:underline">Forgot password?</a>
                    </div>

                    <input 
                        name="password" 
                        type="password" 
                        value="{{ old('password') }}"  
                        id="password" 
                        placeholder="••••••••" 
                        class="w-full bg-[#ffffff] border border-[#d1d5db] rounded-lg px-4 py-3 text-[#030712] placeholder-[#6b7280] focus:outline-none focus:border-[#5727e7] focus:ring-px focus:ring-[#5727e7] transition-all"
                    >
                </div>

                @if ($errors->any())
                    <div class="bg-red-100 p-3 rounded-lg">
                        @foreach ($errors->all() as $error)
                            <p class="text-red-500">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <button 
                    type="submit"
                    :disabled="loading"
                    class="w-full inline-flex items-center justify-center gap-2 bg-[#5727e7] text-white px-6 py-3 rounded-lg shadow-sm hover:bg-[#4a1fd4] transition-colors"
                >
                    <svg x-show="loading" class="h-4 w-4 animate-spin text-white" xmlns="http://w3.org" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>

                    <span x-text="loading ? 'Processing...' : 'Register'"></span>
                </button>
            </form>
        </div>

        <div class="mt-6 flex items-center gap-6">
            <a href="#" class="text-[14px] text-[#6b7280] hover:text-[#5727e7] transition-colors">Privacy Policy</a>
            <a href="#" class="text-[14px] text-[#6b7280] hover:text-[#5727e7] transition-colors">Contact Support</a>
        </div>

    </section>

</x-layouts.auth>