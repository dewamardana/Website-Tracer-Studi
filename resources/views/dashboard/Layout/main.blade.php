<!doctype html>
<html lang="en">
<<<<<<< HEAD

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kuisioner | Dashboard</title>
    <head>
    <!-- CSS lainnya -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
</head>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

     <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('CSS/styleDashboard.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <link rel="stylesheet" href="{{ asset('assets/styles.css') }}">
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="{{ asset('CSS/dashboard.css') }}">
    @livewireStyles

    <style>
        .content {
            display: none;
            /* Sembunyikan semua konten secara default */
        }

        .content.active {
            display: block;
            /* Tampilkan konten yang memiliki class active */
        }

        .nav-item.active {
            font-weight: bold;
            /* Tampilkan perubahan pada sub-nav aktif */
        }
    </style>
</head>

<body>

    @include('dashboard.Layout.header')

    <div class="container-fluid">
        <div class="row">
            @include('dashboard.Layout.sidebar')

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @yield('main')
            </main>
        </div>
    </div>

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
        integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous">
    </script>
    <script src="{{ asset('JS/dashboard.js') }}"></script>
    <script src="https://unpkg.com/feather-icons"></script>

    <script src="{{ asset('assets/github-data.js') }}"></script>
    <script src="{{ asset('assets/stock-prices.js') }}"></script>
    <script src="{{ asset('assets/ohlc.js') }}"></script>
    <script src="{{ asset('assets/irregular-data-series.js') }}"></script>
   
    <script>
        // Ambil semua elemen sub-nav
        const navItems = document.querySelectorAll('.nav-item');

        // Tambahkan event listener untuk setiap item sub-nav
        navItems.forEach(item => {
            item.addEventListener('click', function() {
                // Hapus class active dari semua sub-nav
                navItems.forEach(nav => nav.classList.remove('active'));

                // Tambahkan class active ke item yang diklik
                this.classList.add('active');

                // Ambil nilai data-content dari item yang diklik
                const contentId = this.getAttribute('data-content');

                // Sembunyikan semua konten
                document.querySelectorAll('.content').forEach(content => {
                    content.style.display = 'none';
                    content.classList.remove('active');
                });

                // Tampilkan konten yang dipilih
                const selectedContent = document.getElementById(contentId);
                selectedContent.style.display = 'block';
                selectedContent.classList.add('active');
            });
        });

        // Tampilkan konten ringkasan secara default
        document.querySelector('.nav-item[data-content="ringkasan"]').click();
    </script>
</body>

=======
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kuisioner | Dashboard</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('CSS/styleDashboard.css') }}">


    
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="{{ asset('CSS/dashboard.css') }}">
  </head>
  <body>
    
@include('dashboard.Layout.header')

<div class="container-fluid">
  <div class="row">
    @include('dashboard.Layout.sidebar')

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      @yield('main')
    </main>
  </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

      <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
      <script src="{{ asset('JS/dashboard.js') }}"></script>
      <script src="https://unpkg.com/feather-icons"></script>
      
  </body>
>>>>>>> 250ab6d41aa9fde7ed758faa268346ec9e2b0f5b
</html>
