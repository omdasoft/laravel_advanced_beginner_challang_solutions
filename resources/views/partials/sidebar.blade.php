<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.html">
            <span class="align-middle">{{ auth()->user()->first_name }}</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-item {{ (request()->is('admin/dashboard')) ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.dashboard') }}">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>
            
            @role('admin')
                <li class="sidebar-item {{ (request()->is('admin/users') || request()->is('admin/users/*')) ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.users.index') }}">
                        <i class="align-middle" data-feather="users"></i> <span class="align-middle">Users</span>
                    </a>
                </li>

                <li class="sidebar-item {{ (request()->is('admin/clients') || request()->is('admin/clients/*')) ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.clients.index') }}">
                        <i class="align-middle" data-feather="credit-card"></i> <span class="align-middle">Clients</span>
                    </a>
                </li>
            @endrole

            <li class="sidebar-item {{ (request()->is('admin/projects') || request()->is('admin/projects/*')) ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.projects.index')}}">
                    <i class="align-middle" data-feather="check-square"></i> <span class="align-middle">Projects</span>
                </a>
            </li>

            <li class="sidebar-item {{ (request()->is('admin/tasks') || request()->is('admin/tasks/*')) ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.tasks.index') }}">
                    <i class="align-middle" data-feather="list"></i> <span class="align-middle">Tasks</span>
                 </a>
            </li>
        </ul>
    </div>
</nav>