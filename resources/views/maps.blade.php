<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recycling Organizations</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body>
    <nav class="navbar">
        <div class="menu-icon">☰</div>
        <div class="nav-links">
            <a href="#">Home</a>
            <a href="#">About</a>
        </div>
    </nav>

    <div class="search-container">
        <div class="search-box">
            <input type="text" class="search-input" placeholder="Pilih titik awal...">
            <span class="search-icon">⌕</span>
        </div>
        <div class="search-box">
            <input type="text" class="search-input" placeholder="Pilih tujuan...">
            <span class="search-icon">⌕</span>
        </div>
    </div>

    <div class="organization-list">
        <div class="organization-card">
            <div class="org-avatar">
                <img src="{{ asset('images/Ellips47.svg') }}" alt="Organization Avatar">
            </div>
            <div class="org-info">
                <div class="org-name">Bank Sampah Sukma Mulya</div>
                <div class="org-type">Recycling Organization</div>
                <div class="org-address">Jln. Terusan Buah Batu NO. 46</div>
            </div>
        </div>

        <div class="organization-card">
            <div class="org-avatar">
                <img src="{{ asset('images/Ellips47.svg') }}" alt="Organization Avatar">
            </div>
            <div class="org-info">
                <div class="org-name">Bank Sampah Suka Birus</div>
                <div class="org-type">Recycling Organization</div>
                <div class="org-address">Jln. Suka Birus NO. 46</div>
            </div>
        </div>

        <div class="organization-card">
            <div class="org-avatar">
                <img src="{{ asset('images/Ellips47.svg') }}" alt="Organization Avatar">
            </div>
            <div class="org-info">
                <div class="org-name">Bank Sampah Suka Pura</div>
                <div class="org-type">Recycling Organization</div>
                <div class="org-address">Jln. Suka Pura NO. 46</div>
            </div>
        </div>
    </div>

    <button class="back-button">←</button>
</body>

</html>
