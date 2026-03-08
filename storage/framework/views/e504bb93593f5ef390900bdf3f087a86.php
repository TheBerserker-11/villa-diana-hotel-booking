<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Carousel -->
    <div class="container-fluid p-0">
        <?php echo $__env->make('sections.carousel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

    
    
        <div class="container-fluid pb-4">
            <div class="ratio ratio-16x9 rounded shadow">
                <iframe 
                    width="100%" 
                    height="100%" 
                    frameborder="0" 
                    allowfullscreen 
                    allow="xr-spatial-tracking; gyroscope; accelerometer" 
                    scrolling="no" 
                    src="https://kuula.co/share/collection/7D9cZ?logo=0&info=0&fs=1&vr=1&initload=0&thumbs=1">
                </iframe>
            </div>
        </div>
    

    <!-- Call To Action Buttons -->
    <div class="container text-center pb-5">
        <h3 class="mb-3">Ready to book your stay?</h3>
        <p class="mb-4">Sign in to manage bookings or start a new reservation.</p>

        <div class="d-grid gap-2 d-sm-flex justify-content-center">
            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-primary btn-lg w-100 w-sm-auto">
                    My Bookings
                </a>
                <a href="<?php echo e(route('rooms.index')); ?>" class="btn btn-outline-primary btn-lg w-100 w-sm-auto">
                    Book Another Room
                </a>
            <?php else: ?>
                <a href="<?php echo e(route('login', ['redirect' => url()->full()])); ?>"
                class="btn btn-primary btn-lg w-100 w-sm-auto">
                    Login
                </a>

                <a href="<?php echo e(route('register', ['redirect' => url()->full()])); ?>"
                class="btn btn-outline-primary btn-lg w-100 w-sm-auto">
                    Create Account
                </a>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    
    <?php if(auth()->guard()->check()): ?>
        <?php echo $__env->make('sections.service', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

    
    <?php echo $__env->make('sections.room-container-brief', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make('sections.how-to-get-here', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make('sections.testimonial', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    
    <?php if(auth()->guard()->check()): ?>
        <?php echo $__env->make('sections.team', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

    <?php echo $__env->make('sections.newsletter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
    <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\V18\resources\views/pages/home.blade.php ENDPATH**/ ?>