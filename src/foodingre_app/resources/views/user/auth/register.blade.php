<x-guest-layout title="新規登録する" action="新規登録">

    <div class="my-6 flex flex-col items-center">
        <a href="/" class="mb-2 text-2xl font-bold text-gray-600">FoodIngre</a>
        <p class="text-md text-gray-700">新規登録</p>
    </div>

    <form method="POST" action="{{ route('user.register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('ユーザー名')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('メールアドレス')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Nickname -->
        <div class="mt-4">
            <x-input-label for="nickname" :value="__('ニックネーム')" />
            <x-text-input id="nickname" class="block mt-1 w-full" type="text" name="nickname" :value="old('nickname')" required autocomplete="nickname" />
            <x-input-error :messages="$errors->get('nickname')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('パスワード')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('パスワード（再確認）')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('user.login') }}">
                {{ __('登録済みの場合はログイン') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('登録する') }}
            </x-primary-button>
        </div>
    </form>
    <div class="mx-auto mt-1 text-center">
        <form method="post" action="{{ route('user.guest.login') }}">
        @csrf
        <button type="submit" class="underline text-m text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            ゲストログイン
        </button>
        </form>
    </div>
</x-guest-layout>