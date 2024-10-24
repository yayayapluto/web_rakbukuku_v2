<!--begin::Header-->
<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
        <!-- Start navbar links -->
        <ul class="navbar-nav m-1">
            <li class="nav-item">
                <a class="nav-link border rounded" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
        </ul>
        <!-- End navbar links -->
        
        <strong class="navbar-text">Rakbukuku</strong>
        
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a href="{{ route('logout') }}" class="btn btn-outline-dark ms-3">
                    <i class="bi bi-box-arrow-right"></i> <!-- Sign out icon -->
                    Sign out
                </a>
            </li>
        </ul>
    </div>
</nav>
<!--end::Header-->
