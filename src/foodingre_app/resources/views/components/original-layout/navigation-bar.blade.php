<div class="mx-auto p-2 sm:p-4 bg-green-700 opacity-90"> 
    <div class="max-w-7xl mx-auto flex justify-between">
        {{-- 通常 --}}
        {{-- 未ログイン時 --}}
        <a class="text-white text-2xl sm:text-4xl my-2 p-0" href="{{ url('/') }}">FoodIngre</a>

        @if (!auth()->user())
        <div class="hidden sm:flex">
            <span class="mx-3 my-auto text-center text-sm text-white md:w-20 lg:w-24">
                <a href="{{ url('/login') }}">ログイン</a>
            </span>
            <span class="mx-3 my-auto text-center text-sm text-white md:w-20 lg:w-24">
                <a href="{{ url('/register') }}">新規登録</a>
            </span>
            <span class="text-center text-sm text-white mx-3 my-auto md:w-20 lg:w-24">
            <form method="POST" action="{{ route('user.guest.login') }}" class="">
                @csrf
                    <button type="submit">ゲスト<br>ログイン</button>
                </form>
            </span>
        </div>
        @else
        <div class="hidden sm:flex">
            <span class="mx-2 my-auto text-center text-sm text-white hover:text-gray-300 md:w-20 lg:w-24">
                <a href="{{ route('user.post.create') }}" class="text-center cursor-pointer">新規投稿</a>
            </span>
            <span class="mx-2 my-auto text-center text-sm text-white hover:text-gray-300 cursor-pointer md:w-20 lg:w-24">
                <a href="{{ route('user.userProfile.index', ['id' => auth()->user()->id]) }}">{{ auth()->user()->name }}</a>
            </span>
            <form method="POST" action="{{ route('user.logout') }}" class="mx-3 my-auto">
                @csrf
                <span class="mx-2 text-center text-sm text-white hover:text-gray-300 cursor-pointer md:w-20 lg:w-24">
                    <button type="submit">ログアウト</button>
                </span>
            </form>
        </div>

        @endif
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
        @if (!auth()->user())
        <li class="mx-8 py-5"><a href="{{ url('login') }}">ログイン</a></li>
        <li class="mx-8 py-5"><a href="{{ url('register') }}">新規登録</a></li>
        <li class="mx-8 py-5">
            <form method="POST" action="{{ route('user.guest.login') }}">
                @csrf
                <button type="submit">ゲストログイン</button>
            </form>
        </li>
        @else
        <li class="mx-8 py-5">
            <a href="{{ route('user.post.create') }}">新規投稿</a>
        </li>
        <li class="mx-8 py-5">
            <a href="{{ route('user.userProfile.index', ['id' => auth()->user()->id]) }}">{{ auth()->user()->name }}</a>
        </li>
        <li class="mx-8 py-5">
            <form method="POST" action="{{ route('user.logout') }}">
                @csrf
                <button type="submit">ログアウト</button>
            </form>
        </li>
        @endif
    </ul>
</div>




<script>
    const menuButton = document.getElementById('menu_button')
    menuButton.addEventListener('click', function() {
            document.getElementById('menu').classList.toggle('hidden');
            document.getElementById('menu').classList.toggle('md:hidden');
    })
</script>
