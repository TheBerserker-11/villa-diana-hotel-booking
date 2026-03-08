<aside class="admin-sidebar" id="adminSidebar">

    <div class="brand">
        <div class="brand-badge">
            <i class="bi bi-building"></i>
        </div>
        <div>
            <div class="brand-name">Villa Diana</div>
            <div class="brand-sub">Admin Panel</div>
        </div>
    </div>

    <div class="sidebar-user">
        <?php
            $adminAvatar = !empty(auth()->user()->avatar)
                ? asset('storage/' . auth()->user()->avatar)
                : asset('img/default-avatar.jpg');
        ?>
        <div class="avatar avatar-img">
            <img src="<?php echo e($adminAvatar); ?>" alt="Admin Avatar">
        </div>
        <div>
            <div class="user-name"><?php echo e(auth()->user()->name ?? 'Admin'); ?></div>
            <div class="user-role">Administrator</div>
        </div>
    </div>

    <nav class="sidebar-nav">

        <a href="<?php echo e(route('admin.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.index') ? 'active':''); ?>">
            <i class="bi bi-speedometer2 me-2"></i>
            <span class="link-text">Dashboard</span>
        </a>

        <a href="<?php echo e(route('admin.orders.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.orders.*') ? 'active':''); ?>">
            <i class="bi bi-journal-check me-2"></i>
            <span class="link-text">Bookings</span>
        </a>

        <a href="<?php echo e(route('admin.events.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.events.*') ? 'active':''); ?>">
            <i class="bi bi-calendar-event me-2"></i>
            <span class="link-text">Events</span>
        </a>

        <a href="<?php echo e(route('admin.roomtypes.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.roomtypes.*') ? 'active':''); ?>">
            <i class="bi bi-grid me-2"></i>
            <span class="link-text">Room Types</span>
        </a>

        <a href="<?php echo e(route('admin.rooms.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.rooms.*') ? 'active':''); ?>">
            <i class="bi bi-door-open me-2"></i>
            <span class="link-text">Rooms</span>
        </a>

        <a href="<?php echo e(route('admin.customers.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.customers.*') ? 'active':''); ?>">
            <i class="bi bi-people me-2"></i>
            <span class="link-text">Customers</span>
        </a>

        <a href="<?php echo e(route('admin.profile.show')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.profile.*') ? 'active':''); ?>">
            <i class="bi bi-person-gear me-2"></i>
            <span class="link-text">Admin Profile</span>
        </a>

    </nav>

    <div class="sidebar-footer">
        <form method="POST" action="<?php echo e(route('logout')); ?>" class="w-100">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-outline-danger w-100 sidebar-logout">
                <i class="bi bi-box-arrow-right me-2"></i>
                <span class="link-text">Logout</span>
            </button>
        </form>
    </div>

</aside>
<?php /**PATH C:\xampp\htdocs\V18\resources\views/admin/sidebar.blade.php ENDPATH**/ ?>