<header class="custom-header-bg p-4 flex justify-between items-center shadow-md">
    <div class="text-white header-text">
        <i class="fas fa-bars text-2xl"></i>
    </div>
    <nav class="flex space-x-4">
        @if (auth()->check())
            @if (auth()->user()->role == 'recycleorg')
                <a class="text-white font-bold hover:text-gray-300 transition-colors header-text"
                    href="{{ route('home.homeRO') }}">
                    Home
                </a>
            @else
                <a class="text-white font-bold hover:text-gray-300 transition-colors header-text"
                    href="{{ route('home.homeUser') }}">
                    Home
                </a>
            @endif
            <a class="text-white font-bold hover:text-gray-300 transition-colors header-text" href="#">
                About
            </a>
        @endif
    </nav>
</header>
