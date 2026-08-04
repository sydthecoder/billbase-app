<x-layouts.auth title="Login">
    <section class="w-full flex flex-col items-center justify-center px-6 py-12">
        
        <a href="{{ route('login') }}" class="mb-6">
            <img src="{{ asset('images/brand/logo.png') }}" alt="BillBase Logo" class="h-12">
        </a>

        <div class="w-full space-y-6 max-w-md bg-white rounded-2xl border border-[#e5e7eb] shadow-lg p-6 md:p-10">
            
            <div class="text-center">
                <h1 class="text-3xl font-bold text-dark-500">
                    Login
                </h1>
            </div>

            <a href="{{ route('auth.google') }}" class="w-full bg-white border border-[#e5e7eb] text-dark-500 text-sm font-medium px-6 py-3 rounded-lg shadow-sm hover:bg-[#f9fafb] transition-colors flex items-center justify-center gap-2">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                Continue with Google
            </a>

            <div class="flex items-center gap-4">
                <div class="flex-1 h-px bg-[#e5e7eb]"></div>
                <span class="text-sm text-[#6b7280]">or log in with email</span>
                <div class="flex-1 h-px bg-[#e5e7eb]"></div>
            </div>

            <form 
                method="POST" 
                action="{{ route('login') }}" 
                class="space-y-6"
                x-data="{ loading: false }"
                @submit="loading = true"
            >
                @csrf
            
                <div class="flex flex-col gap-2">
                    <label for="email" class="text-[14px] font-medium text-dark-500">Email</label>
                    <input 
                        name="email" 
                        type="email" 
                        value="{{ old('email') }}" 
                        id="email" 
                        placeholder="name@company.com" 
                        class="w-full bg-white border border-[#d1d5db] rounded-lg px-4 py-3 text-dark-500 placeholder-[#6b7280] focus:outline-none focus:border-primary-500 focus:ring-px focus:ring-primary-500 transition-all"
                    >
                </div>

                <div class="flex flex-col gap-2">
                    <div class="flex items-center justify-between">
                        <label for="password" class="text-[14px] text-dark-500">Password</label>
                        <a href="#" class="text-[14px] text-primary-500 hover:underline">Forgot password?</a>
                    </div>

                    <input 
                        name="password" 
                        type="password" 
                        value="{{ old('password') }}"  
                        id="password" 
                        placeholder="••••••••" 
                        class="w-full bg-white border border-[#d1d5db] rounded-lg px-4 py-3 text-dark-500 placeholder-[#6b7280] focus:outline-none focus:border-primary-500 focus:ring-px focus:ring-primary-500 transition-all"
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
                    class="w-full inline-flex items-center justify-center gap-2 bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-lg shadow-sm transition-colors"
                >
                    <x-ui.button-loader />

                    <span x-text="loading ? 'Processing...' : 'Log In'"></span>
                </button>
            </form>

            <p class="w-full inline-flex justify-center gap-1 text-sm text-gray-500">
                Dont have account?
                <a href="{{ route('register') }}" class="text-primary-500 underline">Register</a>
            </p>
        </div>

        <div class="mt-3">
            <a href="#" class="text-xs text-[#6b7280] hover:text-primary-500 transition-colors">
                &copy; {{ now()->year }} BillBase. All rights reserved.
            </a>
        </div>

    </section>

</x-layouts.auth>