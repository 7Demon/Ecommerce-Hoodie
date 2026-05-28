@extends('layouts.app')
@section('title', 'Create Account — HOODIEL')

@section('content')
<section class="flex min-h-screen items-center justify-center px-5 pt-24 pb-16">
    <div class="w-full max-w-md">

        {{-- Header --}}
        <div class="mb-10 text-center">
            <h1 class="font-serif text-3xl font-light tracking-wide text-stone-900">Create Account</h1>
            <p class="mt-2 text-sm text-stone-500">Join us and start your journey</p>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            {{-- Name --}}
            <div>
                <label for="name" class="block text-xs uppercase tracking-widest text-stone-500">Full Name</label>
                <input id="name"
                       type="text"
                       name="name"
                       value="{{ old('name') }}"
                       required autofocus autocomplete="name"
                       class="mt-2 block w-full border-0 border-b border-stone-300 bg-transparent pb-2 pt-1 text-sm text-stone-900 placeholder-stone-300 outline-none transition-colors focus:border-stone-900 @error('name') border-red-400 @enderror">
                @error('name')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-xs uppercase tracking-widest text-stone-500">Email Address</label>
                <input id="email"
                       type="email"
                       name="email"
                       value="{{ old('email') }}"
                       required autocomplete="username"
                       class="mt-2 block w-full border-0 border-b border-stone-300 bg-transparent pb-2 pt-1 text-sm text-stone-900 placeholder-stone-300 outline-none transition-colors focus:border-stone-900 @error('email') border-red-400 @enderror">
                @error('email')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div x-data="{ show: false }">
                <label for="password" class="block text-xs uppercase tracking-widest text-stone-500">Password</label>
                <div class="relative">
                    <input id="password"
                           :type="show ? 'text' : 'password'"
                           name="password"
                           required autocomplete="new-password"
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

            {{-- Confirm Password --}}
            <div x-data="{ show: false }">
                <label for="password_confirmation" class="block text-xs uppercase tracking-widest text-stone-500">Confirm Password</label>
                <div class="relative">
                    <input id="password_confirmation"
                           :type="show ? 'text' : 'password'"
                           name="password_confirmation"
                           required autocomplete="new-password"
                           class="mt-2 block w-full border-0 border-b border-stone-300 bg-transparent pb-2 pr-8 pt-1 text-sm text-stone-900 placeholder-stone-300 outline-none transition-colors focus:border-stone-900 @error('password_confirmation') border-red-400 @enderror">
                    <button type="button" @click="show = !show"
                            class="absolute bottom-2 right-0 text-stone-400 hover:text-stone-700 transition-colors"
                            :aria-label="show ? 'Hide password' : 'Show password'">
                        <span class="material-symbols-outlined text-[18px]" x-text="show ? 'visibility_off' : 'visibility'">visibility</span>
                    </button>
                </div>
                @error('password_confirmation')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit --}}
            <button type="submit"
                    class="w-full bg-stone-900 py-3 text-xs uppercase tracking-[0.2em] text-white transition-colors hover:bg-stone-700 focus:outline-none">
                Create Account
            </button>
        </form>

        {{-- Login Link --}}
        <p class="mt-8 text-center text-sm text-stone-500">
            Already have an account?
            <a href="{{ route('login') }}" class="text-stone-900 underline underline-offset-2 hover:opacity-70 transition-opacity">
                Sign in
            </a>
        </p>

    </div>
</section>
@endsection
