<x-admin-original-layout.format title="プロフィールを編集">
    <div class="max-w-7xl mx-auto">
        <div class="mt-12">
            <h2 class="flex justify-center sm:justify-start sm:ml-4 text-xl">プロフィールを編集</h2>
        </div>
        <div class="flex flex-col items-center m-5">
            <div class="flex flex-col items-center my-10">
                {{-- 仮アイコン --}}
                <svg class="w-32 h-32 text-gray-800 dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/>
                </svg>
                <button type="button" class="mt-8 px-7 py-2 border border-gray-500 rounded bg-gray-500 text-white hover:border-gray-600 hover:bg-gray-600">プロフィール画像を変更</button>
            </div>
            <x-input-error class="mb-4" :messages="$errors->all()"/>
            <form method="POST" action="{{ route('admin.adminProfile.update', ['id' => auth()->user()->id]) }}">
                @csrf
                @method('PUT')
                <div class="flex flex-col mb-6">
                    <label for="name" class="mb-1 text-gray-700 text-md font-semibold">ユーザー名</label>
                    <input type="text" name="name" required maxlength="255" class="w-72 sm:w-160 rounded-lg border-gray-500" value="{{ auth()->user()->name }}">
                </div>
                <div class="flex flex-col mb-6">
                    <label for="nickname" class="mb-1 text-gray-700 text-md font-semibold">ニックネーム</label>
                    <input type="text" name="nickname" required maxlength="255" class="w-72 sm:w-160 rounded-lg border-gray-500" value="{{ auth()->user()->nickname }}">
                </div>
                <div class="flex flex-col mb-6">
                    <label for="email" class="mb-1 text-gray-700 text-md font-semibold">メールアドレス</label>
                    <input type="email" name="email" required maxlength="255" class="w-72 sm:w-160 rounded-lg border-gray-500" value="{{ auth()->user()->email }}">
                </div>
                <div class="flex flex-col mb-6">
                    <label for="password" class="mb-1 text-gray-700 text-md font-semibold">パスワード（変更する場合）</label>
                    <input type="password" name="password" class="w-72 sm:w-160 rounded-lg border-gray-500">
                </div>
                <div class="flex flex-col mb-24">
                    <label for="password_confirmation" class="mb-1 text-gray-700 text-md font-semibold">パスワード（変更する場合）※再確認</label>
                    <input type="password" name="password_confirmation" class="w-72 sm:w-160 rounded-lg border-gray-500">
                </div>
                <div class="flex justify-center mb-12">
                    <a href="{{ route('admin.index') }}" class="mx-4 py-2 w-32 border border-gray-500 rounded bg-gray-500 text-white text-center hover:border-gray-600 hover:bg-gray-600">戻る</a>
                    <button type="submit" class="mx-4 py-2 w-32 border border-sky-700 rounded bg-sky-700 text-white hover:border-sky-800 hover:bg-sky-800">変更する</button>
                </div>
            </form>
            <div class="flex justify-center mb-10">
                <a href="{{ route('admin.adminProfile.deleteConfirmation') }}" class="py-2 w-44 border border-red-300 rounded bg-red-300 text-black text-center hover:border-red-500 hover:bg-red-500 hover:text-white">アカウントを削除</a>
            </div>
        </div>
    </div>
</x-admin-original-layout.format>