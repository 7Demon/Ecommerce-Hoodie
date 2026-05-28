@extends('layouts.app')
@section('title', 'Sign In — HOODIEL')

@section('content')
<section class="flex min-h-screen items-center justify-center px-5 pt-24 pb-16">
    <div class="w-full max-w-md">

        {{-- Header --}}
        <div class="mb-10 text-center">
            <h1 class="font-serif text-3xl font-light tracking-wide text-stone-900">Welcome Back</h1>
            <p class="mt-2 text-sm text-stone-500">Sign in to continue to your account</p>
        </div>

        {{-- Session Status --}}
        @if (session('status'))
            <div class="mb-6 rounded-sm bg-stone-50 border border-stone-200 px-4 py-3 text-sm text-stone-700">
                {{ session('status') }}
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            {{-- Email --}}
            <div>
                <label for="email" class="block text-xs uppercase tracking-widest text-stone-500">Email Address</label>
                <input id="email"
                       type="email"
                       name="email"
                       value="{{ old('email') }}"
                       required autofocus autocomplete="username"
                       class="mt-2 block w-full border-0 border-b border-stone-300 bg-transparent pb-2 pt-1 text-sm text-stone-900 placeholder-stone-300 outline-none transition-colors focus:border-stone-900 @error('email') border-red-400 @enderror">
                @error('email')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div x-data="{ show: false }">
                <div class="flex items-center justify-between">
                    <label for="password" class="block text-xs uppercase tracking-widest text-stone-500">Password</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-xs text-stone-400 underline-offset-2 hover:text-stone-700 hover:underline transition-colors">
                            Forgot password?
                        </a>
                    @endif
                </div>
                <div class="relative">
                    <input id="password"
                           :type="show ? 'text' : 'password'"
                           name="password"
                           required autocomplete="current-password"
                           class="mt-2 block w-full border-0 border-b border-stone-300 bg-transparent pb-2 pr-8 pt-1 text-sm text-stone-900 placeholder-stone-300 outline-none transition-colors focus:border-stone-900 @error('password') border-red-400 @enderror">
                    <button type="button" @click="show = !show"
                            class="absolute bottom-2 right-0 text-stone-400 hover:text-stone-700 transition-colors"
                            :aria-label="show ? 'Hide password' : 'Show password'">
                        <span class="material-symbols-outlined text-[18px]" x-text="show ? 'visibility_off' : 'visibility'">visibility</span>
                    </button>
                </div>
                @error('password')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember Me --}}
            <div class="flex items-center gap-2">
                <input id="remember_me" type="checkbox" name="remember"
                       class="h-3.5 w-3.5 rounded-none border-stone-300 text-stone-900 focus:ring-stone-900">
                <label for="remember_me" class="text-xs text-stone-500">Remember me</label>
            </div>

            {{-- Submit --}}
            <button type="submit"
                    class="w-full bg-stone-900 py-3 text-xs uppercase tracking-[0.2em] text-white transition-colors hover:bg-stone-700 focus:outline-none">
                Sign In
            </button>
        </form>

        {{-- Register Link --}}
        <p class="mt-8 text-center text-sm text-stone-500">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-stone-900 underline underline-offset-2 hover:opacity-70 transition-opacity">
                Create one
            </a>
        </p>

    </div>
</section>
@endsection
