<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
<<<<<<< HEAD
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Kuisioner Dashboard</a>
=======
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="/">Kuisioner Dashboard</a>
>>>>>>> 250ab6d41aa9fde7ed758faa268346ec9e2b0f5b
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
  <div class="navbar-nav">
    <div class="nav-item text-nowrap">
      <form action="{{ route('logout') }}" method="POST"> 
        @csrf
        <button>Logout</button>
      </form>
    </div>
  </div>
</header>
