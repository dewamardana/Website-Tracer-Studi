    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
<<<<<<< HEAD
          <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboard/kategori*') ? 'active' : '' }}" aria-current="page" href="/dashboard/kategori">
              <span data-feather="home"></span>
              Kategori
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboard/menutemplate*') ? 'active' : '' }}" aria-current="page" href="/dashboard/menutemplate">
              <span data-feather="file"></span>
              Template
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboard/form*') ? 'active' : '' }}" aria-current="page" href="/dashboard/form">
              <span data-feather="file"></span>
              Formulir
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboard/user') ? 'active' : '' }}" href="dashboard/user">
              <span data-feather="file"></span>
              User
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboard/analytics') ? 'active' : '' }}" href="/dashboard/analytics">
              <span data-feather="activity"></span>
              Analytics
            </a>
          </li>
=======
          @can('admin')
              <li class="nav-item">
                <a class="nav-link {{ Request::is('dashboard/kategori*') ? 'active' : '' }}" aria-current="page" href="/dashboard/kategori">
                  <span data-feather="home"></span>
                  Kategori
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ Request::is('dashboard/menutemplate*') ? 'active' : '' }}" aria-current="page" href="/dashboard/menutemplate">
                  <span data-feather="file"></span>
                  Template
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ Request::is('dashboard/form*') ? 'active' : '' }}" aria-current="page" href="/dashboard/form">
                  <span data-feather="file"></span>
                  Formulir
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ Request::is('dashboard/user') ? 'active' : '' }}" href="/dashboard/user">
                  <span data-feather="file"></span>
                  User
                </a>
              </li>
          @elsecan('dosen')
              <li class="nav-item">
                <a class="nav-link {{ Request::is('dashboard/menutemplate*') ? 'active' : '' }}" aria-current="page" href="/dashboard/menutemplate">
                  <span data-feather="file"></span>
                  Template
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ Request::is('dashboard/form*') ? 'active' : '' }}" aria-current="page" href="/dashboard/form">
                  <span data-feather="file"></span>
                  Formulir
                </a>
              </li>
          @else
              
          @endcan

>>>>>>> 250ab6d41aa9fde7ed758faa268346ec9e2b0f5b
        </ul>

      </div>
    </nav>