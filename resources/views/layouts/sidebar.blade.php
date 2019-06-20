<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="/dashboard">
                    <i class="nav-icon icon-speedometer"></i> Dashboard
                </a>
            </li>
            @can('read-events')
            <li class="nav-item">
                <a class="nav-link" href="/events">
                    <i class="nav-icon icon-calendar"></i> Eventos
                </a>
            </li>
            @endcan
            @can('read-quotes')
            <li class="nav-item">
                <a class="nav-link" href="/quotes">
                    <i class="nav-icon icon-note"></i> Cotizaciones
                </a>
            </li>
            @endcan
            @can('read-quotescompanies')
            <li class="nav-item">
                <a class="nav-link" href="/quotesCompanies">
                    <i class="nav-icon icon-note"></i> Cotizaciones Empresa
                </a>
            </li>
            @endcan
            @can('read-users','read-roles')
            <li class="nav-title">Settings</li>
            @endcan
            @can('read-users')
            <li class="nav-item">
                <a class="nav-link" href="/users">
                    <i class="nav-icon icon-people"></i> Users
                </a>
            </li>
            @endcan
            @can('read-roles')
            <li class="nav-item">
                <a class="nav-link" href="/roles">
                    <i class="nav-icon icon-key"></i> Roles
                </a>
            </li>
            @endcan
        </ul>
    </nav>
    <sidebar></sidebar>
</div>
