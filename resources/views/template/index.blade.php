<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Homepage | {{ $title }}</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('CSS/styleHome.css') }}">
  </head>
  <body>
 
    <section id="Navbar">
      <nav class="navbar navbar-expand-lg" style="background-color: #072AC8;">
        <div class="container-fluid">
          <a class="navbar-brand" href="#" >
            <img src="{{ asset('img/Logo-unud-baru.png') }}" alt="logo Unud" width="80" height="80">
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span data-feather="home"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto">
              <li class="nav-item">
                <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" aria-current="page" href="#">Beranda</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Tentang Unud</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Kehidupan Kampus</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Layanan Online</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </section>
    <div class="content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/feather-icons"></script>   
  </body>
</html>

{{-- https://colorhunt.co/palette/050c9c3572ef3abef9a7e6ff --}}



