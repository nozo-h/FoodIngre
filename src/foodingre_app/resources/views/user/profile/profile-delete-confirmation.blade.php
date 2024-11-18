<x-original-layout.format title="アカウント削除の最終確認">
    <div class="max-w-7xl mx-auto">
        <div class="mt-12">
            <h2 class="flex justify-center sm:justify-start sm:ml-4 text-xl">アカウント削除の最終確認</h2>
        </div>
        <div class="flex max-md:flex-col justify-between max-md:items-center mx-10 mt-10">
            <p class="max-md:text-center">
                <span>{{auth()->user()->name}}さん</span><br>
                本当にアカウントを削除しますか？<br>削除すると二度と戻すことはできませんのでご注意ください。
            </p>
            <div class="flex max-md:flex-col">
                <a href="{{ route('user.userProfile.edit') }}" class="flex items-center justify-center max-md:mt-10 max-md:mb-5 md:ml-10 h-12 w-48 border border-gray-500 rounded bg-gray-500 text-white hover:border-gray-600 hover:bg-gray-600 ">戻る</a>
                <form method="POST" action="{{ route('user.userProfile.delete', ['id' => auth()->user()->id ]) }}">
                    @csrf
                    @method('delete')
                    <button class="max-md:mb-5 md:ml-10 h-12 w-48 border border-red-300 rounded bg-red-300 text-black font-bold text-center hover:border-red-500 hover:bg-red-500 hover:text-white">アカウントを削除する</button>
                </form>
            </div>
        </div>
    </div>
</x-original-layout.format>