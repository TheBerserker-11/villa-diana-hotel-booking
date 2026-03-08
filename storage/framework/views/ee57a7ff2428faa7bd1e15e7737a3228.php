<div class="container-xxl py-5">
    <div class="container">

        <!-- Section Header -->
        <div class="text-center mb-5">
            <h6 class="section-title text-primary text-uppercase">Our Rooms</h6>
            <h1>Explore Our <span class="text-primary text-uppercase">Rooms</span></h1>

            
            <?php if(isset($totalGuests)): ?>
                <p class="text-muted mb-0" style="max-width:720px;margin:10px auto 0;">
                    Showing rooms that can accommodate <strong><?php echo e($totalGuests); ?></strong>
                    guest<?php echo e($totalGuests > 1 ? 's' : ''); ?> (closest capacity shown first).
                </p>
            <?php endif; ?>
        </div>

        <div class="row g-4">
            <?php $__empty_1 = true; $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $perNight = $room->computed_total_per_night ?? $room->price;
                    $extraPax = $room->computed_extra_pax ?? 0;

                    $includedPax = $room->included_pax ?? null;
                    $maxCap = $room->max_capacity ?? null;
                ?>

                <div class="col-lg-4 col-md-6">
                    <div class="room-item shadow rounded overflow-hidden">

                        <!-- Room Image -->
                        <div class="position-relative">
                            <img src="<?php echo e(asset('storage/rooms/' . $room->image)); ?>"
                                 class="img-fluid"
                                 style="height:200px;width:100%;object-fit:cover;">

                            <small class="position-absolute start-0 top-0 bg-primary text-white rounded py-1 px-3 ms-3">
                                ₱<?php echo e(number_format((float)$perNight, 0)); ?>/Night
                            </small>
                        </div>

                        <!-- Room Info -->
                        <div class="p-4 mt-2">

                            <h5 class="mb-1"><?php echo e($room->roomtype->name ?? 'Room'); ?></h5>

                            <?php if(!is_null($includedPax) && !is_null($maxCap)): ?>
                                <div class="text-muted small mb-1">
                                    Includes <?php echo e($includedPax); ?> pax • Max <?php echo e($maxCap); ?> pax
                                </div>
                            <?php endif; ?>

                            <?php if($extraPax > 0): ?>
                                <div class="text-muted small mb-2">
                                    + <?php echo e($extraPax); ?> extra pax × ₱<?php echo e(number_format(1200, 0)); ?> / night
                                </div>
                            <?php else: ?>
                                <div class="text-muted small mb-2">
                                    Base room rate / night
                                </div>
                            <?php endif; ?>

                            <?php
                                $incs = $room->roomtype?->inclusions ?? collect();

                                $defaultInclusions = collect([
                                    'Free Wi-Fi',
                                    'Air-conditioned Room',
                                    'Private Bathroom',
                                    'Cable TV',
                                    'Complimentary Toiletries',
                                    'Daily Housekeeping',
                                ]);
                            ?>

                            <?php if($incs->count()): ?>
                                <ul class="room-inclusions mb-2">
                                    <?php $__currentLoopData = $incs->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                            <?php echo e($inc->name); ?>

                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <?php if($incs->count() > 3): ?>
                                        <li class="text-muted small">+ <?php echo e($incs->count() - 3); ?> more</li>
                                    <?php endif; ?>
                                </ul>
                            <?php else: ?>
                                <ul class="room-inclusions mb-2">
                                    <?php $__currentLoopData = $defaultInclusions->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                            <?php echo e($inc); ?>

                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <li class="text-muted small">+ <?php echo e($defaultInclusions->count() - 3); ?> more</li>
                                </ul>
                            <?php endif; ?>

                            <div class="mt-3">

                                <div class="d-flex justify-content-between">
                                    <a href="<?php echo e(route('room-tour', ['id' => $room->id] + request()->query())); ?>"
                                    class="btn btn-sm btn-primary">
                                        View Room Tour
                                    </a>

                                    <?php if(($searched ?? false) === true && request()->filled('check_in') && request()->filled('check_out')): ?>
                                        <a class="btn btn-sm btn-success"
                                        href="<?php echo e(route('booking.summary', request()->query() + ['room_id' => $room->id])); ?>">
                                            Book Now
                                        </a>
                                    <?php else: ?>
                                        <p class="text-danger mb-0">Search availability first</p>
                                    <?php endif; ?>
                                </div>

                            <div class="text-end mt-2">
                                <a href="#" class="termsLink small text-muted">
                                    View Terms & Conditions
                                </a>
                            </div>

                        </div>

                        </div>
                    </div>
                </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-center">No rooms available.</p>
            <?php endif; ?>
        </div>

        <!-- ================= TERMS POPUP ================= -->
        <div id="termsPopup" class="popup">
            <div class="popup-content">
                <span class="popup-close">&times;</span>
                <h4>Terms and Conditions</h4>
                <p>
HOTEL TERMS & CONDITIONS
PLEASE BE REMINDED THAT THESE CONDITIONS APPLY TO ALL GUESTS OF THE HOTEL.

1. BOOKINGS
Guests may book in advance or on arrival. Rooms are subject to availability and the hotel reserves the right to refuse booking for good reason. Although payment is generally on departure, guests may be required to provide a deposit on booking or arrival.

2. CHECK-IN AND CHECK-OUT RULES
Guests may check in anytime from 2:00 PM on the day of arrival. If the guest has not checked in by 4:00 PM, the hotel reserves the right to release the room unless the guest has notified the hotel of late arrival. Rooms are held for the entire day of arrival.

On departure, guests must vacate their rooms and check-out no later than 12:00 PM. Failure to do so will entitle the hotel to charge for an additional night.

3. CHARGES
Charges are at the hotel’s current room rates available upon request. Pricelists for additional items, such as restaurant meals and room service, are on display at relevant locations and available on request.

The hotel reserves the right to charge guests for any damage caused to any of the hotel’s property (including furniture and fixtures).

Rooms are allowed a maximum of 2 persons per room. Visitors of guests are allowed until 10:00 PM. After this time, they will be asked to register and will be charged ₱350 per person.

4. PAYMENT
Guests must pay all outstanding charges on departure. The hotel reserves the right to hold any guest who refuses to give payment for services acquired.

5. CANCELLATION
For cancellation of pre-paid bookings, a refund will be given for the fully paid reservations. Deposits will not be returned for cancelled reservations.

6. RIGHT OF REFUSAL
The hotel reserves the right to refuse a guest entry and accommodation if, on arrival, management reasonably considers that the guest is under the influence of alcohol or drugs, unsuitably dressed, or behaving in a threatening, abusive, or otherwise unacceptable manner.

7. DISTURBANCE
The hotel reserves the right to require a guest to leave if he/she is causing disturbance, annoying other guests or hotel staff, or behaving in an unacceptable manner.

8. HOTEL RULES
Guests shall comply with all reasonable rules and procedures in effect at the hotel, including but not limited to health and security procedures and statutory registration requirements.
Guests shall not bring their own food or drink into the hotel for consumption on the premises.
Animals are not allowed in the rooms.
Children under the age of 14 must be supervised by adult guests at all times.

9. LIABILITY
The hotel shall not be liable to guests for any loss or damage to property caused by misconduct or negligence of a guest, an act of God, or where the guest remains in exclusive charge of the property concerned.
The hotel shall not be liable for any failure or delay in performing obligations due to causes beyond its control, including war, riot, natural disaster, epidemic, bad weather, terrorist activity, government or regulatory action, industrial dispute, failure of power, or other similar events.
The hotel is not liable for any loss or damage caused to a guest’s vehicle, unless caused by the hotel’s willful misconduct.
Guests will be liable for any loss, damage, or personal injury they may cause at the hotel.
                </p>
            </div>
        </div>
        <!-- ================= END TERMS POPUP ================= -->

    </div>
</div>

<style>
/* ✅ Inclusions styling */
.room-inclusions{
    list-style: none;
    padding: 0;
    margin: 6px 0 0 0;
    font-size: 13px;
    color: #6c757d;
}
.room-inclusions li{
    display: flex;
    align-items: center;
    margin-bottom: 4px;
}

/* Terms popup */
.popup {
    display: none;
    position: fixed;
    z-index: 9999;
    inset: 0;
    background: rgba(0,0,0,.5);
}
.popup-content {
    background: #fff;
    margin: 10% auto;
    padding: 20px;
    border-radius: 8px;
    width: 90%;
    max-width: 500px;
    white-space: pre-line;
}
.popup-close {
    float: right;
    font-size: 28px;
    cursor: pointer;
}
.popup-close:hover { color: red; }
</style>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const popup = document.getElementById('termsPopup');
    const closeBtn = document.querySelector('.popup-close');

    document.querySelectorAll('.termsLink').forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();
            popup.style.display = 'block';
        });
    });

    if (closeBtn) closeBtn.onclick = () => popup.style.display = 'none';
    window.onclick = e => {
        if (e.target === popup) popup.style.display = 'none';
    };
});
</script>
<?php $__env->stopPush(); ?><?php /**PATH C:\xampp\htdocs\V18\resources\views/sections/room-container-details.blade.php ENDPATH**/ ?>