<div class="col-lg-3">
    <div class="sidebar shadow-sm">
        <div class="sidebar-header text-center py-3">
            <h4><i class="bi bi-plugin"></i> {{ config('app.name') }}</h4>
        </div>
        <div class="sidebar-body">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link text-success">
                        <span class="icon"><i class="bi bi-check2-circle"></i></span>
                        <span>Welcome</span>
                    </a>
                </li>

                <li class="nav-item @if(file_exists(storage_path('app/requirementChecked'))) passed @endif">
                    <a class="nav-link ">
                        <span class="checked-icon"><i class="bi bi-check2-circle"></i></span>
                        <span class="icon"><i class="bi bi-building"></i></span>
                        <span>Check Requirements</span>
                    </a>
                </li>

                <li class="nav-item @if(file_exists(storage_path('app/permissionChecked'))) passed @endif">
                    <a class="nav-link">
                        <span class="checked-icon"><i class="bi bi-check2-circle"></i></span>
                        <span class="icon"><i class="bi bi-lock"></i></span>
                        <span>Check Permissions</span>
                    </a>
                </li>

                <li class="nav-item @if(file_exists(storage_path('app/licenseVerified'))) passed @endif">
                    <a class="nav-link">
                        <span class="checked-icon"><i class="bi bi-check2-circle"></i></span>
                        <span class="icon"><i class="bi bi-pass"></i></span>
                        <span>License Verification</span>
                    </a>
                </li>

                <li class="nav-item @if(file_exists(storage_path('app/databaseSetuped'))) passed @endif">
                    <a class="nav-link">
                        <span class="checked-icon"><i class="bi bi-check2-circle"></i></span>
                        <span class="icon"><i class="bi bi-database"></i></span>
                        <span>Database Setup</span>
                    </a>
                </li>

                <li class="nav-item @if(file_exists(storage_path('app/adminSetuped'))) passed @endif">
                    <a class="nav-link">
                        <span class="checked-icon"><i class="bi bi-check2-circle"></i></span>
                        <span class="icon"><i class="bi bi-person-add"></i></span>
                        <span>Admin Setup</span>
                    </a>
                </li>

                <li class="nav-item @if(file_exists(storage_path('app/installed'))) passed @endif">
                    <a class="nav-link disabled" aria-disabled="true">
                        <span class="checked-icon"><i class="bi bi-check2-circle"></i></span>
                        <span class="icon"><i class="bi bi-flag"></i></span>
                        <span>Installation Finished</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
