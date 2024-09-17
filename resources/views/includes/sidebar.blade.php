<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #F4F6F9;">
    <!-- Brand Logo -->
    <div style="padding: 10px; display: flex; justify-content: center; align-items: center;">
        <img src="{{ asset('dist/img/newlogo.png') }}" alt="MYLAB Logo" style="max-height: 110px;">
    </div>

    <!-- Sidebar -->
    <div class="sidebar" style="height: calc(100vh - 110px); overflow-y: auto;"> 
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Dashboard Link -->
                <li class="nav-item" style="border-bottom: 1px solid #4f59621f;">
                    <a href="{{ route('dashboard.mainDashboard.index') }}" class="nav-link {{ request()->routeIs('dashboard.mainDashboard.index') ? 'active' : '' }}" style="{{ request()->routeIs('dashboard.mainDashboard.index') ? 'background-color: #dcdde1; color: #000;' : 'color: black;' }}">
                        <i class="bi bi-house-check-fill" style="color: black;"></i>
                        <p class="p-aside-text">Dashboard</p>
                    </a>
                </li>

                <!-- Other Single Links -->
                <li class="nav-item">
                    <a href="{{ route('dashboard.specialities.index') }}" class="nav-link {{ request()->routeIs('dashboard.specialities.index') ? 'active' : '' }}" style="{{ request()->routeIs('dashboard.specialities.index') ? 'background-color: #dcdde1; color: #000;' : 'color: black;' }}">
                        <i class="bi bi-text-paragraph"></i>
                        <p class="p-aside-text">Specialties</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard.institutions.index') }}" class="nav-link {{ request()->routeIs('dashboard.institutions.index') ? 'active' : '' }}" style="{{ request()->routeIs('dashboard.institutions.index') ? 'background-color: #dcdde1; color: #000;' : 'color: black;' }}">
                        <i class="bi bi-text-paragraph"></i>
                        <p class="p-aside-text">Institutions</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard.diagnoses.index') }}" class="nav-link {{ request()->routeIs('dashboard.diagnoses.index') ? 'active' : '' }}" style="{{ request()->routeIs('dashboard.diagnoses.index') ? 'background-color: #dcdde1; color: #000;' : 'color: black;' }}">
                        <i class="bi bi-text-paragraph"></i>
                        <p class="p-aside-text">Diagnoses</p>
                    </a>
                </li>
                <li class="nav-item" style="border-bottom: 1px solid #4f59621f;">
                    <a href="{{ route('dashboard.tumors.index') }}" class="nav-link {{ request()->routeIs('dashboard.tumors.index') ? 'active' : '' }}" style="{{ request()->routeIs('dashboard.tumors.index') ? 'background-color: #dcdde1; color: #000;' : 'color: black;' }}">
                        <i class="bi bi-text-paragraph"></i>
                        <p class="p-aside-text">Tumors</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard.tests.index') }}" class="nav-link {{ request()->routeIs('dashboard.tests.index') ? 'active' : '' }}" style="{{ request()->routeIs('dashboard.tests.index') ? 'background-color: #dcdde1; color: #000;' : 'color: black;' }}">
                        <i class="bi bi-bookmarks-fill"></i>
                        <p class="p-aside-text">Tests</p>
                    </a>
                </li>
                <li class="nav-item" style="border-bottom: 1px solid #4f59621f;">
                    <a href="{{ route('dashboard.track-lab_orders.index') }}" class="nav-link {{ request()->routeIs('dashboard.track-lab_orders.index') ? 'active' : '' }}" style="{{ request()->routeIs('dashboard.track-lab_orders.index') ? 'background-color: #dcdde1; color: #000;' : 'color: black;' }}">
                        <i class="bi bi-bookmarks-fill"></i>
                        <p class="p-aside-text">Test Tracking</p>
                    </a>
                </li>

                <!-- Accounts Dropdown -->
                <li class="nav-item has-treeview {{ request()->is('dashboard/doctors*') || request()->is('dashboard/labs*') || request()->is('dashboard/patients*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('dashboard/doctors*') || request()->is('dashboard/labs*') || request()->is('dashboard/patients*') ? 'active' : '' }}" style="{{ request()->is('dashboard/doctors*') || request()->is('dashboard/labs*') || request()->is('dashboard/patients*') ? 'background-color: #dcdde1; color: #000;' : 'color: black;' }}">
                        <i class="bi bi-person-bounding-box"></i>
                        <p class="p-aside-text">Accounts<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('dashboard.doctors.index') }}" class="nav-link {{ request()->routeIs('dashboard.doctors.index') ? 'active' : '' }}" style="{{ request()->routeIs('dashboard.doctors.index') ? 'background-color: #dcdde1; color: #000;' : '' }}">
                                <i class="bi bi-person-bounding-box"></i>
                                <p class="p-aside-text">Doctors</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.labs.index') }}" class="nav-link {{ request()->routeIs('dashboard.labs.index') ? 'active' : '' }}" style="{{ request()->routeIs('dashboard.labs.index') ? 'background-color: #dcdde1; color: #000;' : '' }}">
                                <i class="bi bi-bookmarks-fill"></i>
                                <p class="p-aside-text">Labs</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.patients.index') }}" class="nav-link {{ request()->routeIs('dashboard.patients.index') ? 'active' : '' }}" style="{{ request()->routeIs('dashboard.patients.index') ? 'background-color: #dcdde1; color: #000;' : '' }}">
                                <i class="bi bi-person-lines-fill"></i>
                                <p class="p-aside-text">Patients</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('dashboard.couriers.index') }}" class="nav-link {{ request()->routeIs('dashboard.couriers.index') ? 'active' : '' }}" style="{{ request()->routeIs('dashboard.couriers.index') ? 'background-color: #dcdde1; color: #000;' : '' }}">
                                <i class="bi bi-person-lines-fill"></i>
                                <p class="p-aside-text">Couriers</p>
                            </a>
                        </li>


                    </ul>
                </li>

                <!-- Points Dropdown -->
                <li class="nav-item has-treeview {{ request()->is('dashboard/points-transactions*') || request()->is('dashboard/points-transfer*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('dashboard/points-transactions*') || request()->is('dashboard/points-transfer*') ? 'active' : '' }}" style="{{ request()->is('dashboard/points-transactions*') || request()->is('dashboard/points-transfer*') ? 'background-color: #dcdde1; color: #000;' : 'color: black;' }}">
                        <i class="bi bi-currency-exchange"></i>
                        <p class="p-aside-text">Points<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('dashboard.total.points.index') }}" class="nav-link {{ request()->routeIs('dashboard.total.points.index') ? 'active' : '' }}" style="{{ request()->routeIs('dashboard.total.points.index') ? 'background-color: #dcdde1; color: #000;' : '' }}">
                                <i class="bi bi-list"></i>
                                <p class="p-aside-text">History Transactions</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.points.transfer.requests') }}" class="nav-link {{ request()->routeIs('dashboard.points.transfer.requests') ? 'active' : '' }}" style="{{ request()->routeIs('dashboard.points.transfer.requests') ? 'background-color: #dcdde1; color: #000;' : '' }}">
                                <i class="bi bi-arrow-right-left"></i>
                                <p class="p-aside-text">Daily Requests</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Users Management Dropdown -->
                <li class="nav-item has-treeview {{ request()->is('dashboard/users*') || request()->is('dashboard/roles*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('dashboard/users*') || request()->is('dashboard/roles*') ? 'active' : '' }}" style="{{ request()->is('dashboard/users*') || request()->is('dashboard/roles*') ? 'background-color: #dcdde1; color: #000;' : 'color: black;' }}">
                        <i class="bi bi-people-fill"></i>
                        <p class="p-aside-text">Users Management<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('dashboard.users.index') }}" class="nav-link {{ request()->routeIs('dashboard.users.index') ? 'active' : '' }}" style="{{ request()->routeIs('dashboard.users.index') ? 'background-color: #dcdde1; color: #000;' : '' }}">
                                <i class="bi bi-person"></i>
                                <p class="p-aside-text">Users</p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="{{ route('dashboard.labUsers.index') }}" class="nav-link {{ request()->routeIs('dashboard.labUsers.index') ? 'active' : '' }}" style="{{ request()->routeIs('dashboard.labUsers.index') ? 'background-color: #dcdde1; color: #000;' : '' }}">
                                <i class="bi bi-shield-lock"></i>
                                <p class="p-aside-text">Labs Accounts</p>
                            </a>
                        </li> --}}
                    </ul>
                </li>

                
                <!-- Sponsors Management Dropdown -->
                <li class="nav-item has-treeview {{ request()->is('dashboard/sponsors*') || request()->is('dashboard/sponsors*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('dashboard/sponsors*') || request()->is('dashboard/sponsors*') ? 'active' : '' }}" style="{{ request()->is('dashboard/sponsors*') || request()->is('dashboard/sponsors*') ? 'background-color: #dcdde1; color: #000;' : 'color: black;' }}">
                        <i class="bi bi-people-fill"></i>
                        <p class="p-aside-text">Sponsors<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('dashboard.sponsors.index')}}" class="nav-link {{ request()->routeIs('dashboard.sponsors.index') ? 'active' : '' }}" style="{{ request()->routeIs('dashboard.sponsors.index') ? 'background-color: #dcdde1; color: #000;' : '' }}">
                                <i class="bi bi-person"></i>
                                <p class="p-aside-text">Sponsors</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('dashboard.sponsored-tests.index')}}" class="nav-link {{ request()->routeIs('dashboard.sponsored-tests.index') ? 'active' : '' }}" style="{{ request()->routeIs('dashboard.sponsored-tests.index') ? 'background-color: #dcdde1; color: #000;' : '' }}">
                                <i class="bi bi-person"></i>
                                <p class="p-aside-text">Sponsored Tests</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('dashboard.doctors-sponsored-requests.index')}}" class="nav-link {{ request()->routeIs('dashboard.doctors-sponsored-requests.index') ? 'active' : '' }}" style="{{ request()->routeIs('dashboard.doctors-sponsored-requests.index') ? 'background-color: #dcdde1; color: #000;' : '' }}">
                                <i class="bi bi-person"></i>
                                <p class="p-aside-text" style="font-size: 15px;">Doctors Sponsored Requests</p>
                            </a>
                        </li>

                  
                    </ul>
                </li>

            
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>