<aside class="app-sidebar control-sidebar-push bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{route("home")}}" class="brand-link">
            <span class="brand-text fw-light">RakBukuKu</span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('admin.dashboard')}}" class="nav-link">
                        <i class="nav-icon bi bi-house-door"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route("users.index")}}" class="nav-link">
                        <i class="nav-icon bi bi-person-fill"></i>
                        <p>Users</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route("categories.index")}}" class="nav-link">
                        <i class="nav-icon bi bi-tags-fill"></i>
                        <p>Categories</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route("racks.index")}}" class="nav-link">
                        <i class="nav-icon bi bi-bookshelf"></i> <!-- Updated icon -->
                        <p>Racks</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route("books.index")}}" class="nav-link">
                        <i class="nav-icon bi bi-book-fill"></i>
                        <p>Books</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route("records.index")}}" class="nav-link">
                        <i class="nav-icon bi bi-file-earmark-text"></i>
                        <p>Records</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.monitor')}}" class="nav-link">
                        <i class="nav-icon bi bi-eye-fill"></i>
                        <p>Monitor</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
