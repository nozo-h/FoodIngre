<x-admin-original-layout.format title="管理ユーザーを新規作成">
    <div class="max-w-7xl mx-auto">
        <div class="mt-12">
            <h2 class="flex justify-center sm:justify-start sm:ml-4 text-xl max-sm:text-sm">管理ユーザーを新規作成</h2>
        </div>
        <div class="flex flex-col items-center my-5 mt-16">
            <x-input-error class="mb-4" :messages="$errors->all()"/>
            <form method="POST" action="{{ route('admin.admins.store') }}">
                @csrf
                <div class="flex flex-col mb-6">
                    <label for="name" class="mb-1 text-gray-700 text-md font-semibold">ユーザー名</label>
                    <input type="text" name="name" required maxlength="255" class="w-72 sm:w-160 rounded-lg border-gray-500" value="{{old('name')}}" placeholder="例) Taro Yamada">
                </div>
                <div class="flex flex-col mb-6">
                    <label for="nickname" class="mb-1 text-gray-700 text-md font-semibold">ニックネーム</label>
                    <input type="text" name="nickname" required maxlength="255" class="w-72 sm:w-160 rounded-lg border-gray-500" value="{{old('nickname')}}" placeholder="例) Taroya">
                </div>
                <div class="flex flex-col mb-6">
                    <label for="email" class="mb-1 text-gray-700 text-md font-semibold">メールアドレス</label>
                    <input type="email" name="email" required maxlength="255" class="w-72 sm:w-160 rounded-lg border-gray-500" value="{{old('email')}}" placeholder="例) taroya@sample.com">
                </div>
                <div class="flex flex-col mb-6">
                    <label for="authority" class="mb-1 text-gray-700 text-md font-semibold">権限</label>
                    <div class="flex">
                        <label class="mx-4"><input type="radio" name="authority" class="mx-1" value="normal_authority" checked required>一般管理者</label>
                        <label class="mx-4"><input type="radio" name="authority" class="mx-1" value="supreme_authority" required>最高管理者</label>
                    </div>
                </div>
                <div class="flex flex-col mb-6">
                    <label for="password" class="mb-1 text-gray-700 text-md font-semibold">仮パスワード</label>
                    <input type="password" name="password" class="w-72 sm:w-160 rounded-lg border-gray-500" required>
                </div>
                <div class="flex flex-col mb-24">
                    <label for="password_confirmation" class="mb-1 text-gray-700 text-md font-semibold">仮パスワード※再確認</label>
                    <input type="password" name="password_confirmation" class="w-72 sm:w-160 rounded-lg border-gray-500" required>
                </div>
                <div class="flex justify-center mb-12">
                    <a href="{{ url()->previous() }}" class="mx-4 py-2 w-32 rounded bg-gray-500 text-white text-center hover:border-gray-600 hover:bg-gray-600">戻る</a>
                    <button type="submit" class="mx-4 py-2 w-32 rounded bg-sky-700 text-white hover:border-sky-800 hover:bg-sky-800">追加する</button>
                </div>
            </form>
        </div>
    </div>
</x-admin-original-layout.format>