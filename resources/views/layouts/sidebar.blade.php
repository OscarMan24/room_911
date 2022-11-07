<div class="page-sidebar">
    <ul class="list-unstyled accordion-menu">
        <li class="sidebar-title">
            {{ __('Main') }}
        </li>
        @can('users.index')
            <li class="{{ request()->is('panel/users') ? 'active-page' : '' }}">
                <a href="{{ route('index.users') }}"><i data-feather="user"></i>{{ __('Users') }}</a>
            </li>
        @endcan

        @can('departments.index')
            <li class="{{ request()->is('panel/departments') ? 'active-page' : '' }}">
                <a href="{{ route('index.departments') }}"><i data-feather="filter"></i>{{ __('Departments') }}</a>
            </li>
        @endcan

        @can('employees.index')
            <li
                class="{{ request()->is('panel/employees') ? 'active-page' : '' }} {{ request()->is('panel/employees/*') ? 'active-page' : '' }}">
                <a href="{{ route('index.employees') }}"><i data-feather="users"></i>{{ __('Employees') }}</a>
            </li>
        @endcan



        <li class="sidebar-title">
            {{ __('Settings') }}
        </li>

        @can('roles.index')
            <li class="{{ request()->is('panel/rol-and-permissions') ? 'active-page' : '' }}">
                <a href="{{ route('index.rols') }}"><i data-feather="shield"></i>{{ __('Roles') }}</a>
            </li>
        @endcan

        @can('setting.index')
            <li class="{{ request()->is('panel/setting') ? 'active-page' : '' }}">
                <a href="{{ route('index.setting') }}"><i data-feather="sliders"></i>{{ __('Setting') }}</a>
            </li>
        @endcan
    </ul>
</div>
