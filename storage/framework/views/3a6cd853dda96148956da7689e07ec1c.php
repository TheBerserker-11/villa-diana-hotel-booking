<div class="container-xxl vd-testimonial my-5 py-5 wow zoomIn" data-wow-delay="0.1s">
    <div class="vd-testimonial-bg"></div>
    <div class="vd-testimonial-overlay"></div>

    <div class="container position-relative">
        <div class="text-center mb-4 mb-md-5">
            <span class="vd-badge">Guest Stories</span>
            <h2 class="vd-title mt-2 mb-2">
                Moments Made at <span class="vd-gold">Villa Diana</span>
            </h2>
            <p class="vd-subtitle mb-0">
                Real experiences from guests who celebrated, relaxed, and enjoyed their stay.
            </p>
        </div>

        <div class="owl-carousel testimonial-carousel py-2 py-md-4">
            <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="vd-card position-relative h-100">
                    <div class="vd-card-top d-flex align-items-center justify-content-between mb-2">
                        <div class="vd-stars" aria-label="5 stars">
                            ★★★★★
                        </div>
                        <div class="vd-quote-mark" aria-hidden="true">“</div>
                    </div>

                    <p class="vd-text mb-4">
                        <?php echo e($review->content); ?>

                    </p>

                    <div class="vd-divider my-3"></div>

                    <div class="vd-profile d-flex align-items-center gap-3">
                        <img
                            class="vd-avatar flex-shrink-0"
                            src="<?php echo e($review->avatar ? asset('storage/' . $review->avatar) : 'https://i.pinimg.com/1200x/eb/7e/eb/eb7eeb473794bd14c39f3a3b19d70b65.jpg'); ?>"
                            alt="<?php echo e($review->name); ?> avatar"
                        >

                        <div class="vd-meta">
                            <h6 class="vd-name mb-0"><?php echo e($review->name); ?></h6>
                            <?php if($review->location): ?>
                                <small class="vd-loc d-block"><?php echo e($review->location); ?></small>
                            <?php endif; ?>
                        </div>

                        <i class="fa fa-quote-right vd-quote-icon ms-auto" aria-hidden="true"></i>
                    </div>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\V18\resources\views/sections/testimonial.blade.php ENDPATH**/ ?>