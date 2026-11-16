<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PANTAS — Pantau Sampah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/landing.css') }}">
</head>

<body>@include('landing.partials.navbar')<main>
        @include('landing.partials.hero')@include('landing.partials.tentang')@include('landing.partials.fitur')@include('landing.partials.jadwal')@include('landing.partials.edukasi')
    </main>@include('landing.partials.footer')
    <script src="https://unpkg.com/lucide@0.462.0/dist/umd/lucide.min.js"></script>
    <script>
        window.lucide?.createIcons();
        document.addEventListener('click', e => {
            const menu = document.querySelector('.portal-menu');
            if (!menu.contains(e.target)) menu.removeAttribute('open');
        });
    </script>
</body>

</html>
