<x-layouts.auth title="Login">
    <div class="h-screen items-center justify-center flex">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">

            <div class="relative bg-white py-8 px-6 rounded-lg shadow">
                <div>
                    <div class="text-center">
                        <h2 class="mb-8 text-3xl font-bold leading-5 text-dark">
                            Register
                        </h2>         
                    </div>

                    <div class="flex flex-col gap-2">
                        <a href="{{ route('auth.google') }}"
                            class="inline-flex h-11 w-full items-center justify-center gap-3 rounded-lg shadow-sm border border-gray-300 bg-white p-2 text-[14px] font-medium text-dark outline-none focus:ring-2 focus:ring-[#333] focus:ring-offset-1 disabled:cursor-not-allowed disabled:opacity-60"><img
                            src="{{ asset('icons/google-color-svgrepo-com.svg') }}" alt="Google"
                            class="h-5 w-5"
                        >
                            Continue with Google
                        </a>
                    </div>

                    <div class="flex w-full items-center gap-2 py-6 text-sm text-gray-600">
                        <div class="h-px w-full bg-gray-200"></div>
                        OR
                        <div class="h-px w-full bg-gray-200"></div>
                    </div>

                    <form 
                        method="POST" 
                        action="{{ route('register') }}" 
                        class="space-y-5"
                        x-data="{ loading: false }"
                        @submit="loading = true"
                    >
                        @csrf

                        <div>
                            <label for="email" class="sr-only">Email address</label>
                            <input 
                                name="email" 
                                type="email" 
                                value="{{ old('email') }}" 
                                class="block w-full rounded-lg border border-gray-300 px-4 py-2 shadow-sm outline-none placeholder:text-gray-400 focus:ring-2 focus:ring-dark focus:ring-offset-1"
                                placeholder="Email Address"
                                required
                            />
                        </div>

                        <div>
                            <label for="password" class="sr-only">Password</label>
                            <input 
                                name="password" 
                                type="password" 
                                class="mt-2 block w-full rounded-lg border border-gray-300 px-4 py-2 shadow-sm outline-none placeholder:text-gray-400 focus:ring-2 focus:ring-dark focus:ring-offset-1"
                                placeholder="Password"
                                required
                            />
                        </div>

                        <p class="text-[14px] text-gray-500">
                            <a href="/forgot-password" class="text-primary-500 hover:text-blue-600">Forgot your password?</a>
                        </p>

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
                            class="cursor-pointer inline-flex w-full items-center justify-center gap-2 rounded-xl bg-dark p-2 py-3 text-[15px] font-medium text-white outline-none focus:ring-2 focus:ring-dark focus:ring-offset-1 disabled:bg-gray-400"
                        >
                            <svg x-show="loading" class="h-4 w-4 animate-spin text-white" xmlns="http://w3.org" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>

                            <span x-text="loading ? 'Processing...' : 'Register'"></span>
                        </button>
                    </form>

                    <div class="mt-6 text-center text-[14px] text-gray-600">
                        Already have an account?
                        <a href="{{ route('login') }}" class="border-b border-dashed border-gray-400">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layouts.auth>