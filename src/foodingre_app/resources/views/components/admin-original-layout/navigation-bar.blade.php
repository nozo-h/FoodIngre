<div class="mx-auto p-2 sm:p-4 bg-sky-600 opacity-90"> 
    <div class="max-w-7xl mx-auto flex justify-between">
        {{-- 通常 --}}
        <div class="flex flex-col">
            <a class="text-white text-2xl sm:text-4xl mt-2 p-0" href="{{ url('/admin/') }}">FoodIngre</a>
            <p class="text-white text-xs sm:text-sm">管理者用アカウント</p>
        </div>
        <div class="hidden sm:flex mx-3 my-auto">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                    <button type="submit" class="mx-3 my-auto text-center text-sm text-white md:w-20 lg:w-24">
                        ログアウト
                    </button>
            </form>
            <span class="mx-3 my-auto text-center text-sm text-white md:w-20 lg:w-24">
                <a href="{{ route('admin.adminProfile.index') }}">{{ auth()->user()->name }}</a>
            </span>
        </div>

        {{-- レスポンシブ対応 --}}
        <div class="sm:hidden cursor-pointer my-auto">
            <button id="menu_button">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>
    </div>
</div>
<div id="menu" class="hidden w-42 h-auto bg-gray-200">
    <ul class="text-left">
        <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
            <li class="mx-8 py-5">
                <button type="submit">
                    ログアウト
                </button>
            </li>
        </form>
            <li class="mx-8 py-5">
                <a href="{{ route('admin.adminProfile.index') }}">{{ auth()->user()->name }}の設定</a>
            </li>
    </ul>
</div>

<script>
    const menuButton = document.getElementById('menu_button')
    menuButton.addEventListener('click', function() {
            document.getElementById('menu').classList.toggle('hidden');
            document.getElementById('menu').classList.toggle('md:hidden');
    })
</script>
