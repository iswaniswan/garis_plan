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
                    <i class="fas fa-pen-square"></i><span>Room reservation</span>
                </a>
                <ul class="dropdown-menu">
                    <!-- <li><a class="nav-link" name="activity-event-room" href="layout-default.html">Dashboard</a></li> -->
                    <li><a class="nav-link" name="activity-room_reservation-summary" href="<?= base_url('activity/room/reservation/summary'); ?>">summary</a></li>
                    <li><a class="nav-link d-none" name="activity-room_reservation-order" href="<?= base_url('activity/room/reservation/order'); ?>">order</a></li>
                    <li><a class="nav-link" name="activity-room_reservation-table" href="<?= base_url('activity/room/reservation/table'); ?>">table</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-pen-square"></i><span>Event</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" name="activity-event-summary" href="<?= base_url('activity/event/summary'); ?>">summary</a></li>
                    <li><a class="nav-link d-none" name="activity-event-order" href="<?= base_url('activity/event/order'); ?>">order</a></li>
                    <li><a class="nav-link" name="activity-event-table" href="<?= base_url('activity/event/table'); ?>">table</a></li>
                </ul>
            </li>
            <li>
                <a class="nav-link" name="activity-notification" href="<?= base_url('activity/notification'); ?>">
                    <i class="fas fa-pen-square"></i><span>Notification</span>
                </a>
            </li>

            <li class="menu-header">Report</li>
            <li>
                <a class="nav-link" name="report-room_reservation" href="#">
                    <i class="fas fa-clipboard"></i><span>Room reservation</span>
                </a>
            </li>
            <li>
                <a class="nav-link" name="report-room_reservation" href="#">
                    <i class="fas fa-clipboard"></i><span>Event</span>
                </a>
            </li>
            <li>
                <a class="nav-link" name="report-room_reservation" href="#">
                    <i class="fas fa-clipboard"></i><span>Notification</span>
                </a>
            </li> 
            <li class="menu-header">Settings</li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-cog"></i><span>Data</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" name="settings-data-holiday" href="<?= base_url('settings/data/holiday'); ?>">Holiday</a></li>
                    <li><a class="nav-link d-none" name="settings-data-holiday-order" href="<?= base_url('settings/data/holiday/order'); ?>">order holiday</a></li>
                    <li><a class="nav-link" name="settings-data-room" href="<?= base_url('settings/data/room'); ?>">Room</a></li>
                    <li><a class="nav-link" name="settings-data-facilities" href="<?= base_url('settings/data/facilities'); ?>">Facilities</a></li>
                    <li><a class="nav-link" name="" href="<?= base_url('settings/data/vehicle'); ?>">Vehicle</a></li>
                    <li><a class="nav-link" name="" href="<?= base_url('settings/data/user'); ?>">User</a></li>
                </ul>
            </li>
        </ul>
    </aside>
</div>