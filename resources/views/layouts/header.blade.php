<div id="menu">
    <div id="menu-background"></div>
    <div class="menu-container">
        <header class="header-menu">
            <div class="menu-icon" id="menu-icon-open">
                <span class="material-symbols-rounded">menu_open</span>
            </div>
            <div class="menu-title">
                <span>Menu</span>
            </div>
        </header>
        <div class="menu-list">
            @if (auth()->check())
                <div class="menu-item" id="menu-profile">
                    <a href="{{ route('account.profile') }}" class="flex items-center">
                        <span class="material-symbols-rounded">account_circle</span>
                        <span class="menu-item-text">Profile</span>
                    </a>
                </div>
                @if (auth()->user()->role == 'recycleorg')
                    <div class="menu-item" id="menu-profile">
                        <a href="{{ route('account.notificationRequest') }}" class="flex items-center">
                            <span class="material-symbols-rounded">notifications</span>
                            <span class="menu-item-text">Notification Request</span>
                        </a>
                    </div>
                    <div class="menu-item" id="menu-profile">
                        <span class="material-symbols-rounded">history</span>
                        <span class="menu-item-text">Riwayat Recycling</span>
                    </div>
                @else
                    <div class="menu-item" id="menu-profile">
                        <a href="{{ route('account.notificationReport') }}" class="flex items-center">
                            <span class="material-symbols-rounded">notifications</span>
                            <span class="menu-item-text">Notification Report</span>
                        </a>
                    </div>
                    <div class="menu-item" id="menu-profile">
                        <img src="{{ asset('images/Cup.svg') }}" alt="Cup Icon" class="menu-icon">
                        <a href="{{ route('pointReward.pointReward') }}" class="flex items-center">
                            <span class="menu-item-text">Points and Reward</span>
                        </a>
                    </div>
                @endif
            @endif

        </div>
        <div id="logout">
            <a href="{{ route('account.logout') }}" class="flex items-center">
                <span class="material-symbols-rounded">logout</span>
                <span class="menu-item-text">Logout</span>
            </a>
        </div>
    </div>
</div>
<header class="header-main">
    <div class="menu-icon" id="menu-icon-close">
        <span class="material-symbols-rounded">menu</span>
    </div>
    <div>
        <a href="{{ url('/') }}">
            <img src="{{ asset('images/ea$yTrash.svg') }}" alt="logo-icon" class="logo-icon">
        </a>
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


{{-- <body>
    <div id="menu">
        <div id="menu-background"></div>
        <div class="menu-container">
            <header class="header-menu">
                <div class="menu-icon" id="menu-icon-open">
                    <span class="material-symbols-rounded">menu_open</span>
                </div>
                <div class="menu-title">
                    <span>Menu</span>
                </div>
            </header>
            <div class="menu-list">
                <div class="menu-item" id="menu-profile">
                    <span class="material-symbols-rounded">account_circle</span>
                    <span class="menu-item-text">Profile</span>
                </div>
                <div class="menu-item" id="menu-profile">
                    <span class="material-symbols-rounded">notifications</span>
                    <span class="menu-item-text">Notification Request</span>
                </div>
                <div class="menu-item" id="menu-profile">
                    <span class="material-symbols-rounded">history</span>
                    <span class="menu-item-text">Riwayat Recycling</span>
                </div>
            </div>
            <div id="logout">
                <span class="material-symbols-rounded">logout</span>
                <span class="menu-item-text">Logout</span>
            </div>
        </div>
    </div>
    <div class="container">
        <header class="header-main">
            <div class="menu-icon" id="menu-icon-close">
                <span class="material-symbols-rounded">menu</span>
            </div>
            <nav>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                </ul>
            </nav>
        </header>
    </div>
    <script>
        document.getElementById("menu-icon-close").onclick = function() {
            document.getElementById("menu").style.display = "block";
        };
        document.getElementById("menu-icon-open").onclick = function() {
            document.getElementById("menu").style.display = "none";
        };
        document.getElementById("menu-background").onclick = function() {
            document.getElementById("menu").style.display = "none";
        }
    </script>
</body> --}}
