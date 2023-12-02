<aside
    class="sidebar navbar navbar-expand-lg bg-dark d-flex flex-column gap-4 align-content-lg-center mx-2 my-2 rounded">
    <h5 class="navbar-brand">Konveksi Rapih</h5>
    <div class="collapse navbar-collapse flex-grow-0" id="navbarNavDropdown">
        <ul class="navbar-nav d-flex flex-column gap-1 px-2 ">
            <li class="navbar-item rounded {{ Request::path() === 'admin/dashboard' ? 'bg-info' : '' }}">
                <a href="{{ route('admin') }}" class="nav-link ">
                    <div class="d-flex gap-3">
                        <span class="material-icons"> dashboard</span>
                        <p class="m-0 p-0">Dashboard</p>
                    </div>
                </a>
            </li>
            <li class="navbar-item rounded {{ Request::path() === 'admin/product' ? 'bg-info' : '' }}">
                <a href="{{ route('product') }}" class="nav-link">
                    <div class="d-flex gap-3">
                        <span class="material-icons"> inventory</span>
                        <p class="m-0 p-0">Product</p>
                    </div>
                </a>
            </li>
            <li class="navbar-item rounded {{ Request::path() === 'admin/user_management' ? 'bg-info' : '' }}">
                <a href="{{ route('user_management') }}" class="nav-link">
                    <div class="d-flex gap-3">
                        <span class="material-icons"> people_alt</span>
                        <p class="m-0 p-0">Admin Management</p>
                    </div>
                </a>
            </li>
            <li class="navbar-item rounded {{ Request::path() === 'admin/user_management' ? 'bg-info' : '' }}">
                <a href="{{ route('user_management') }}" class="nav-link">
                    <div class="d-flex gap-3">
                        <span class="material-icons"> people_alt</span>
                        <p class="m-0 p-0">User Management</p>
                    </div>
                </a>
            </li>
            <li class="navbar-item rounded {{ Request::path() === 'admin/incomesummary' ? 'bg-info' : '' }}">
                <a href="{{ route('incomesummary') }}" class="nav-link">
                    <div class="d-flex gap-3">
                        <span class="material-icons">arrow_forward</span>
                        <p class="m-0 p-0">Income Summary</p>
                    </div>
                </a>
            </li>
            <li class="navbar-item rounded {{ Request::path() === 'admin/expensessummary' ? 'bg-info' : '' }}">
                <a href="{{ route('expensessummary') }}" class="nav-link">
                    <div class="d-flex gap-3">
                        <span class="material-icons">arrow_back</span>
                        <p class="m-0 p-0">Expenses Summary</p>
                    </div>
                </a>
            </li>
            <li class="navbar-item rounded {{ Request::path() === 'admin/report' ? 'bg-info' : '' }}">
                <a href="{{ route('report') }}" class="nav-link">
                    <div class="d-flex gap-3">
                        <span class="material-icons"> analytics</span>
                        <p class="m-0 p-0">Report</p>
                    </div>
                </a>
            </li>
            <li class="navbar-item rounded {{ Request::path() === 'admin' ? 'bg-info' : '' }}">
                <a href="logout" class="nav-link">
                    <div class="d-flex gap-3">
                        <span class="material-icons"> logout</span>
                        <p class="m-0 p-0">logout</p>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</aside>
