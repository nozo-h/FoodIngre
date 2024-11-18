<x-guest-layout title="ログインする" action="ログイン">

    <div class="my-6 flex flex-col items-center">
        <a href="/" class="mb-2 text-2xl font-bold text-gray-600">FoodIngre</a>
        <p class="text-md text-gray-700">ログイン</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('user.login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('メールアドレス')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('パスワード')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>


        <div class="flex items-center justify-end mt-4">

            <x-primary-button class="ms-3">
                {{ 'ログイン' }}
            </x-primary-button>
        </div>
    </form>
    <div class="mx-auto mt-1 text-center">
        <a class="underline text-m text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('user.register') }}">新規登録</a>
        <form method="POST" action="{{ route('user.guest.login') }}" class="">
            @csrf
                <button type="submit" class="text-gray-600 font-bold underline">ゲストログイン</button>
        </form>
    </div>
</x-guest-layout>
