<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="#" onClick="location.reload();">GARIS</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="#" onClick="location.reload();">G</a>
        </div>
        <ul class="sidebar-menu" id="sidebar_menu">
            <li class="menu-header">Dashboard</li>
            <li class="nav-item dropdown active">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-th"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="#" onClick="location.reload();">Calendar</a></li>
                </ul>
            </li>
            <li class="menu-header">Activity</li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-columns"></i><span>Event</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" name="activity-event-room" href="layout-default.html">Room</a></li>
                    <li><a class="nav-link" name="activity-event-reservation" href="<?= base_url('activity/event/reservation'); ?>">Reservation</a></li>
                    <li><a class="nav-link" name="activity-event-dayoff" href="<?= base_url('activity/event/dayoff'); ?>">Day off</a></li>
                </ul>
            </li>
            
            <!-- <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-columns"></i><span>Booking trip</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="layout-default.html">Order</a></li>
                    <li><a class="nav-link" href="layout-default.html">Check</a></li>
                </ul>
            </li> -->

            <li class="nav-item dropdown">
                <li class="menu-header">Report</li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link has-dropdown">
                        <i class="fas fa-columns"></i><span>Reserved room</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="#">Room</a></li>
                    </ul>
                </li>

                <!-- <li class="nav-item dropdown">
                    <a href="#" class="nav-link has-dropdown">
                        <i class="fas fa-columns"></i> <span>Booked trip</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="forms-advanced-form.html">Trip</a></li>
                    </ul>
                </li>                         -->

            <li class="menu-header">Settings</li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-columns"></i><span>Data</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a name="settings-data-room" href="<?= base_url('settings/data/room'); ?>">Room</a></li>
                    <li><a name="settings-data-facilities" href="<?= base_url('settings/data/facilities'); ?>">Facilities</a></li>
                    <li><a href="<?= base_url('settings/data/vehicle'); ?>">Vehicle</a></li>
                    <li><a href="<?= base_url('settings/data/user'); ?>">User</a></li>
                </ul>
            </li>
        </ul>
    </aside>
</div>