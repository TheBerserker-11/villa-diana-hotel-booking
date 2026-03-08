

<?php $__env->startSection('content'); ?>
<div class="py-3 vd-page">

    
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-2">
        <div class="flex-grow-1">
            <h2 class="mb-0">Customer Management</h2>
            <small class="text-muted">Manage registered customers</small>
        </div>

        <div class="d-grid d-sm-flex gap-2">
            <a href="<?php echo e(route('admin.index')); ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>

            <?php if(Route::has('admin.customers.create')): ?>
                <a href="<?php echo e(route('admin.customers.create')); ?>" class="btn btn-success">
                    <i class="bi bi-person-plus me-1"></i> Add Customer
                </a>
            <?php endif; ?>
        </div>
    </div>

    
    <form method="GET" action="<?php echo e(route('admin.customers.index')); ?>" class="mb-3" autocomplete="off">
        <div class="input-group">
            <span class="input-group-text">
                <i class="bi bi-search"></i>
            </span>

            <input
                id="customerSearch"
                type="text"
                name="search"
                class="form-control"
                placeholder="Search name, email, phone..."
                value="<?php echo e($search ?? request('search')); ?>"
                autocomplete="off"
            >

            <?php if(request()->filled('search')): ?>
                <a href="<?php echo e(route('admin.customers.index')); ?>" class="btn btn-outline-secondary">
                    Clear
                </a>
            <?php endif; ?>
        </div>
    </form>

    
    <?php if(session('success')): ?>
        <div class="alert alert-success mb-3">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    
    <?php
        $hasCustomers = isset($customers) && $customers->count();
        $total = $totalCustomers ?? (method_exists($customers, 'total') ? $customers->total() : $customers->count());
        $filterText = request('search');
    ?>

    <?php if($hasCustomers): ?>
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
            <small class="text-muted">
                Total customers: <strong><?php echo e($total); ?></strong>
            </small>

            <?php if(!empty($filterText)): ?>
                <small class="text-muted">
                    Filter: <span class="badge bg-secondary"><?php echo e($filterText); ?></span>
                </small>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    
    <div class="d-md-none" id="customerCards">
        <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div
                class="vd-card mb-3 customer-card"
                data-search="<?php echo e(strtolower($customer->name.' '.$customer->email.' '.($customer->phone ?? ''))); ?>"
            >
                <div class="vd-card-body">
                    <div class="fw-semibold"><?php echo e($customer->name); ?></div>
                    <div class="text-muted small"><?php echo e($customer->email); ?></div>

                    <div class="mt-2">
                        <span class="text-muted small">Phone:</span>
                        <span class="fw-semibold"><?php echo e($customer->phone ?? '—'); ?></span>
                    </div>

                    <div class="mt-3">
                        <form action="<?php echo e(route('admin.customers.destroy', $customer->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>

                            <button
                                type="submit"
                                class="btn btn-sm btn-danger w-100"
                                onclick="return confirm('Delete this customer?')"
                            >
                                <i class="bi bi-trash me-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="vd-card">
                <div class="vd-card-body text-center vd-empty py-4">
                    No customers found.
                </div>
            </div>
        <?php endif; ?>
    </div>

    
    <div class="vd-card d-none d-md-block">
        <div class="vd-card-body p-0">
            <div class="table-responsive">
                <table class="table vd-table-bs mb-0">
                    <thead class="vd-thead">
                        <tr>
                            <th style="min-width:200px;">Name</th>
                            <th style="min-width:240px;">Email</th>
                            <th style="min-width:160px;">Phone</th>
                            <th style="width:120px;">Actions</th>
                        </tr>
                    </thead>

                    <tbody id="customerTableBody">
                        <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr
                                class="customer-row"
                                data-search="<?php echo e(strtolower($customer->name.' '.$customer->email.' '.($customer->phone ?? ''))); ?>"
                            >
                                <td class="fw-semibold"><?php echo e($customer->name); ?></td>
                                <td><?php echo e($customer->email); ?></td>
                                <td><?php echo e($customer->phone ?? '—'); ?></td>
                                <td>
                                    <form action="<?php echo e(route('admin.customers.destroy', $customer->id)); ?>"
                                          method="POST"
                                          class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this customer?')"
                                        >
                                            <i class="bi bi-trash me-1"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="text-center vd-empty py-4">
                                    No customers found.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    
    <?php if(isset($customers) && method_exists($customers, 'links') && $customers->hasPages()): ?>
        <div class="vd-card mt-3 vd-pagination-card">
            <div class="vd-card-body py-3 px-3 px-md-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                    <small class="text-muted">
                        Showing <?php echo e($customers->firstItem() ?? 0); ?> to <?php echo e($customers->lastItem() ?? 0); ?>

                        of <?php echo e($customers->total()); ?> customers
                    </small>

                    <div>
                        <?php echo e($customers->onEachSide(1)->withQueryString()->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\V18\resources\views/admin/customers/index.blade.php ENDPATH**/ ?>