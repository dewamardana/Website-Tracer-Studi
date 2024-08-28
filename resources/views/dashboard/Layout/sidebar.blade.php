    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
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
            <a class="nav-link {{ Request::is('dashboard/user') ? 'active' : '' }}" href="dashboard/user">
              <span data-feather="file"></span>
              User
            </a>
          </li>
        </ul>

      </div>
    </nav>