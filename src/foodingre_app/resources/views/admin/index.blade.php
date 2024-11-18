<x-admin-original-layout.format title="管理者ホーム">
    {{-- サイズがmd以上の場合、表示 --}}
    <div class="flex justify-center max-w-7xl mx-auto max-md:hidden">
        <div class="grid grid-cols-3 grid-rows-2 gap-6 my-12">
            <a href="{{ route('admin.users.index') }}" class="m-auto md:w-60 sm:h-36 border-2 border-gray-500 rounded hover:ease-in duration-100 hover:bg-gray-200 hover:border-sky-300">
                <div class="flex flex-col items-center justify-center h-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-12 h-12">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    <p class="mt-4 text-gray-700 font-semibold">ユーザー管理</p>
                </div>
            </a>
            <a href="" class="m-auto md:w-60 sm:h-36 border-2 border-gray-500 rounded hover:ease-in duration-100 hover:bg-gray-200 hover:border-sky-300">
                <div class="flex flex-col items-center justify-center h-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-12 h-12">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75l-2.489-2.489m0 0a3.375 3.375 0 10-4.773-4.773 3.375 3.375 0 004.774 4.774zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="mt-4 text-gray-700 font-semibold">検索</p>
                </div>
            </a>
            <a href="{{ route('admin.category.index') }}" class="m-auto md:w-60 sm:h-36 border-2 border-gray-500 rounded hover:ease-in duration-100 hover:bg-gray-200 hover:border-sky-300">
                <div class="flex flex-col items-center justify-center h-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-12 h-12">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5v6m3-3H9m4.06-7.19l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                    </svg>                      
                    <p class="mt-4 text-gray-700 font-semibold">カテゴリ管理</p>
                </div>
            </a>
            <a href="{{ route('admin.admins.index') }}" class="m-auto md:w-60 sm:h-36 border-2 border-gray-500 rounded hover:ease-in duration-100 hover:bg-gray-200 hover:border-sky-300">
                <div class="flex flex-col items-center justify-center h-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-12 h-12">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                    </svg>                      
                    <p class="mt-4 text-gray-700 font-semibold">管理ユーザーの管理</p>
                </div>
            </a>
            <a href="{{ route('admin.adminProfile.index') }}" class="m-auto md:w-60 sm:h-36 border-2 border-gray-500 rounded hover:ease-in duration-100 hover:bg-gray-200 hover:border-sky-300">
                <div class="flex flex-col items-center justify-center h-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-12 h-12">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>                      
                    <p class="mt-4 text-gray-700 font-semibold">アカウント設定</p>
                </div>
            </a>
        </div>
    </div>
    {{-- サイズがmd以下の場合、表示 --}}
    <div class="flex justify-center mt-4 md:hidden">
        <ul>
            <li class="my-3 p-4 w-96 bg-gray-200 border border-gray-300 rounded-lg text-xl text-gray-800 hover:bg-sky-200 hover:border hover:border-sky-300 cursor-pointer"><a href="{{ route('admin.users.index') }}">ユーザー管理</a></li>
            <li class="my-3 p-4 w-96 bg-gray-200 border border-gray-300 rounded-lg text-xl text-gray-800 hover:bg-sky-200 hover:border hover:border-sky-300 cursor-pointer"><a href="">検索</a></li>
            <li class="my-3 p-4 w-96 bg-gray-200 border border-gray-300 rounded-lg text-xl text-gray-800 hover:bg-sky-200 hover:border hover:border-sky-300 cursor-pointer"><a href="">カテゴリ管理</a></li>
            <li class="my-3 p-4 w-96 bg-gray-200 border border-gray-300 rounded-lg text-xl text-gray-800 hover:bg-sky-200 hover:border hover:border-sky-300 cursor-pointer"><a href="{{ route('admin.admins.index') }}">管理ユーザーの管理</a></li>
            <li class="my-3 p-4 w-96 bg-gray-200 border border-gray-300 rounded-lg text-xl text-gray-800 hover:bg-sky-200 hover:border hover:border-sky-300 cursor-pointer"><a href="{{ route('admin.adminProfile.index') }}">アカウント設定</a></li>
        </ul>
    </div>
</x-admin-original-layout.format>