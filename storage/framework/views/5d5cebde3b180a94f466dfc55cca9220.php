
<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php
    // VAT computations for display (must match controller VAT_RATE)
    $breakfastPrice = 550;
    $breakfastQty = max(0, (int) old('breakfast_qty', request()->query('breakfast_qty', 0)));
    $roomSubTotal = ($pricing['per_night'] ?? 0) * ($pricing['nights'] ?? 1);
    $breakfastTotal = $breakfastQty * $breakfastPrice;
    $subTotal = $roomSubTotal + $breakfastTotal;
    $vatAmount = $subTotal * 0.10;
    $grandTotal = $subTotal + $vatAmount;
?>

<div class="container-xxl py-5">
    <div class="container" style="max-width: 980px;">

        <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
            <div>
                <h2 class="mb-1" style="letter-spacing:-.02em;">Booking Summary</h2>
                <div class="text-muted">Review details before payment</div>
            </div>

            <a href="<?php echo e(route('rooms.index', request()->query())); ?>"
               class="btn btn-outline-secondary px-4 py-2"
               style="border-radius:999px;">
                <i class="fa-solid fa-arrow-left me-2"></i> Back to Rooms
            </a>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius:20px; overflow:hidden;">
            <div class="card-body p-4 p-lg-5">

                <div class="row g-4 g-lg-5 align-items-start">

                    <div class="col-lg-5">
                        <div class="p-3 border bg-white" style="border-radius:18px;">
                            <div class="position-relative">
                                <img
                                    src="<?php echo e(asset('storage/rooms/' . $room->image)); ?>"
                                    class="img-fluid"
                                    style="width:100%; height:260px; object-fit:cover; border-radius:16px;"
                                    alt="Room image"
                                >

                                <span class="position-absolute top-0 start-0 m-3 px-3 py-2 text-white"
                                      style="border-radius:999px; background:rgba(17,24,39,.85); font-size:12px;">
                                    <?php echo e($room->roomtype->name ?? 'Room'); ?>

                                </span>
                            </div>

                            <div class="mt-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0"><?php echo e($room->roomtype->name ?? 'Room'); ?></h4>
                                    <span class="badge bg-light text-dark border" style="border-radius:999px;">
                                        &#8369;<?php echo e(number_format($room->price ?? 0, 0)); ?>/night
                                    </span>
                                </div>

                                <div class="text-muted mt-2">
                                    Includes <strong><?php echo e($room->included_pax ?? 1); ?></strong> pax -
                                    Max <strong><?php echo e($room->max_capacity ?? '-'); ?></strong> pax
                                </div>

                                <?php
                                    $tour = $room->tour_details;
                                    $roomHighlights = collect($tour['room_highlights'] ?? []);
                                    $roomAmenities = collect($tour['comfort_amenities'] ?? []);
                                ?>

                                <?php if($roomHighlights->isNotEmpty()): ?>
                                    <div class="vd-room-extra">
                                        <div class="vd-room-extra__title">Room Highlights</div>
                                        <ul class="vd-room-extra__list mb-0">
                                            <?php $__currentLoopData = $roomHighlights; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li>
                                                    <i class="bi bi-stars"></i>
                                                    <span><?php echo e($item); ?></span>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                                <?php if($roomAmenities->isNotEmpty()): ?>
                                    <div class="vd-room-extra">
                                        <div class="vd-room-extra__title">Comfort &amp; Amenities</div>
                                        <ul class="vd-room-extra__list mb-0">
                                            <?php $__currentLoopData = $roomAmenities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li>
                                                    <i class="bi bi-check2-circle"></i>
                                                    <span><?php echo e($item); ?></span>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7">

                        <div class="row g-3">
                            <div class="col-6">
                                <div class="p-3 border bg-white" style="border-radius:16px;">
                                    <div class="text-muted small">Check-in</div>
                                    <div class="fw-semibold"><?php echo e($fields['check_in']); ?></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 border bg-white" style="border-radius:16px;">
                                    <div class="text-muted small">Check-out</div>
                                    <div class="fw-semibold"><?php echo e($fields['check_out']); ?></div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="p-3 border bg-white" style="border-radius:16px;">
                                    <div class="text-muted small">Guests</div>
                                    <div class="fw-semibold"><?php echo e($totalGuests); ?> total</div>
                                    <div class="text-muted small">
                                        Adults: <?php echo e($fields['adults']); ?>,
                                        Children: <?php echo e($fields['children'] ?? 0); ?>,
                                        Infants: <?php echo e($fields['infants'] ?? 0); ?>

                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="p-3 border bg-white" style="border-radius:16px;">
                                    <div class="text-muted small">Nights</div>
                                    <div class="fw-semibold"><?php echo e($pricing['nights']); ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 p-4 border bg-white" style="border-radius:18px;">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h5 class="mb-0">Price Breakdown</h5>
                                <span class="text-muted small">Auto-computed</span>
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Base rate (per night)</span>
                                <strong>&#8369;<?php echo e(number_format($room->price ?? 0, 0)); ?></strong>
                            </div>

                            <?php if(($pricing['extra_pax'] ?? 0) > 0): ?>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Extra pax fee (per night)</span>
                                    <strong>
                                        <?php echo e($pricing['extra_pax']); ?> x &#8369;<?php echo e(number_format(1200, 0)); ?>

                                    </strong>
                                </div>
                            <?php endif; ?>

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Computed total per night</span>
                                <strong id="computedPerNightAmount">&#8369;<?php echo e(number_format($pricing['per_night'], 0)); ?></strong>
                            </div>

                            <div class="mt-3 p-3 border rounded-3 bg-light-subtle vd-summary-extras">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-semibold">Extras</span>
                                    <span class="text-muted small">Optional add-ons</span>
                                </div>

                                <div class="vd-extra-row">
                                    <div class="vd-extra-copy">
                                        <div class="vd-extra-name">Breakfast</div>
                                        <div class="vd-extra-price">(&#8369;<?php echo e(number_format($breakfastPrice, 0)); ?> each)</div>
                                    </div>

                                    <div class="vd-qty-control" role="group" aria-label="Breakfast quantity selector">
                                        <button type="button" class="vd-qty-btn" id="breakfastMinus" aria-label="Decrease breakfast quantity">-</button>
                                        <input
                                            type="number"
                                            id="breakfastQty"
                                            class="vd-qty-input"
                                            min="0"
                                            max="200"
                                            step="1"
                                            value="<?php echo e($breakfastQty); ?>"
                                            aria-label="Breakfast quantity"
                                        >
                                        <button type="button" class="vd-qty-btn" id="breakfastPlus" aria-label="Increase breakfast quantity">+</button>
                                    </div>
                                </div>
                                <?php $__errorArgs = ['breakfast_qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger small mt-2 text-start"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <hr class="my-3">

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">
                                    Room subtotal (<?php echo e($pricing['nights']); ?> night<?php echo e($pricing['nights'] > 1 ? 's' : ''); ?>)
                                </span>
                                <strong id="roomSubtotalAmount">&#8369;<?php echo e(number_format($roomSubTotal, 0)); ?></strong>
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Extras subtotal</span>
                                <strong id="breakfastTotalAmount">&#8369;<?php echo e(number_format($breakfastTotal, 0)); ?></strong>
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal before VAT</span>
                                <strong id="subTotalAmount">&#8369;<?php echo e(number_format($subTotal, 0)); ?></strong>
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">VAT (10%)</span>
                                <strong id="vatAmount">&#8369;<?php echo e(number_format($vatAmount, 0)); ?></strong>
                            </div>

                            <hr class="my-3">

                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-muted small">Final Total</div>
                                    <div class="fw-semibold">Subtotal + VAT</div>
                                </div>
                                <div class="fs-4 fw-bold" id="grandTotalAmount">
                                    &#8369;<?php echo e(number_format($grandTotal, 0)); ?>

                                </div>
                            </div>

                            
                            <?php if(auth()->guard()->check()): ?>
                                <div class="mt-4">
                                    <button class="btn btn-primary w-100 py-3"
                                            style="border-radius:16px; font-weight:700;"
                                            data-bs-toggle="modal"
                                            data-bs-target="#gcashPayModal">
                                        Proceed to Payment
                                        <i class="fa-solid fa-arrow-right ms-2"></i>
                                    </button>

                                    <div class="text-muted small mt-2">
                                        You'll enter your GCash reference code and upload proof (optional) in the next step.
                                    </div>
                                </div>
                            <?php endif; ?>

                            
                            <?php if(auth()->guard()->guest()): ?>
                                <div class="mt-4 p-3 p-sm-4 border rounded-4 bg-light">
                                    <div class="fw-bold mb-1">Almost there!</div>
                                    <div class="text-muted mb-3">
                                        Please log in or create an account to continue to payment and confirm your booking.
                                    </div>

                                    <div class="d-grid gap-2 d-sm-flex">
                                        <a class="btn btn-primary btn-lg"
                                           href="<?php echo e(route('login', ['redirect' => url()->full()])); ?>">
                                            Login to Continue
                                        </a>

                                        <a class="btn btn-outline-primary btn-lg"
                                           href="<?php echo e(route('register', ['redirect' => url()->full()])); ?>">
                                            Create Account
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>

                        </div> 
                    </div> 
                </div> 

            </div>
        </div>

        
        <?php if(auth()->guard()->check()): ?>
        <div class="modal fade" id="gcashPayModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content" style="border-radius:18px; overflow:hidden;">

                    <div class="modal-header">
                        <h5 class="modal-title">GCash Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body text-center p-4">
                        <p class="mb-2 text-muted">Scan and pay, then enter your reference code.</p>

                        <img src="<?php echo e(asset('img/qrcodes/gcash.jpg')); ?>"
                             alt="GCash QR"
                             class="img-fluid"
                             style="max-width:260px;border-radius:14px;">

                        <hr class="my-3">

                        <form method="POST" action="<?php echo e(route('orders.store')); ?>" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>

                            <input type="hidden" name="room_id" value="<?php echo e($room->id); ?>">
                            <input type="hidden" name="check_in" value="<?php echo e($fields['check_in']); ?>">
                            <input type="hidden" name="check_out" value="<?php echo e($fields['check_out']); ?>">
                            <input type="hidden" name="adults" value="<?php echo e($fields['adults']); ?>">
                            <input type="hidden" name="children" value="<?php echo e($fields['children'] ?? 0); ?>">
                            <input type="hidden" name="infants" value="<?php echo e($fields['infants'] ?? 0); ?>">
                            <input type="hidden" name="pets" value="<?php echo e($fields['pets'] ?? 0); ?>">
                            <input type="hidden" name="breakfast_qty" id="breakfastQtyInput" value="<?php echo e($breakfastQty); ?>">

                            <input type="hidden" name="computed_per_night" value="<?php echo e($pricing['per_night']); ?>">
                            <input type="hidden" name="computed_nights" value="<?php echo e($pricing['nights']); ?>">
                            <input type="hidden" name="computed_total" id="computedTotalInput" value="<?php echo e($grandTotal); ?>">

                            <div class="mb-3 text-start">
                                <label class="form-label">GCash Reference Code</label>
                                <input type="text"
                                       name="reference_code"
                                       class="form-control <?php $__errorArgs = ['reference_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       required
                                       autocomplete="off"
                                       minlength="13"
                                       maxlength="13"
                                       value="<?php echo e(old('reference_code')); ?>"
                                       style="border-radius:12px;">
                                <?php $__errorArgs = ['reference_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="mb-3 text-start">
                                <label class="form-label fw-semibold">Upload Proof (optional)</label>
                                <input type="file"
                                       name="proof_image"
                                       class="form-control <?php $__errorArgs = ['proof_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       accept="image/*"
                                       style="border-radius:12px;">
                                <small class="text-muted">JPG/PNG/WebP up to 5MB.</small>

                                <?php $__errorArgs = ['proof_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="form-check mb-2 text-start">
                                <input class="form-check-input" type="checkbox" id="paidNow" name="paid" value="1">
                                <label class="form-check-label" for="paidNow">
                                    I have already paid via GCash
                                </label>
                                <?php $__errorArgs = ['paid'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="form-check mb-3 text-start">
                                <input class="form-check-input" type="checkbox" id="agreeTerms" name="terms" value="1">
                                <label class="form-check-label" for="agreeTerms">
                                    I agree to the Terms & Conditions
                                </label>
                                <?php $__errorArgs = ['terms'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <button type="submit"
                                    class="btn btn-success w-100 py-2"
                                    style="border-radius:14px; font-weight:700;"
                                    id="confirmPayBtn" disabled>
                                Confirm Booking
                            </button>

                            <div class="small text-muted mt-2">
                                Your booking will be marked <strong>pending</strong> until confirmed by admin.
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const breakfastPrice = 550;
    const nights = Number(<?php echo json_encode((int) ($pricing['nights'] ?? 1), 15, 512) ?>);
    const perNight = Number(<?php echo json_encode((float) ($pricing['per_night'] ?? 0), 15, 512) ?>);
    const roomSubTotal = perNight * nights;

    const breakfastQtyEl = document.getElementById('breakfastQty');
    const breakfastMinus = document.getElementById('breakfastMinus');
    const breakfastPlus = document.getElementById('breakfastPlus');
    const breakfastQtyInput = document.getElementById('breakfastQtyInput');
    const computedTotalInput = document.getElementById('computedTotalInput');

    const roomSubtotalAmount = document.getElementById('roomSubtotalAmount');
    const breakfastTotalAmount = document.getElementById('breakfastTotalAmount');
    const subTotalAmount = document.getElementById('subTotalAmount');
    const vatAmount = document.getElementById('vatAmount');
    const grandTotalAmount = document.getElementById('grandTotalAmount');

    const formatPeso = (amount) => `\u20B1${Number(amount).toLocaleString('en-US', { maximumFractionDigits: 0 })}`;
    const clampQty = (value) => {
        const parsed = parseInt(value, 10);
        if (Number.isNaN(parsed)) return 0;
        return Math.max(0, Math.min(200, parsed));
    };

    const updateTotals = () => {
        const qty = clampQty(breakfastQtyEl?.value ?? 0);
        if (breakfastQtyEl) breakfastQtyEl.value = qty;
        if (breakfastQtyInput) breakfastQtyInput.value = qty;

        const extrasTotal = qty * breakfastPrice;
        const subtotal = roomSubTotal + extrasTotal;
        const vat = subtotal * 0.10;
        const total = subtotal + vat;

        if (roomSubtotalAmount) roomSubtotalAmount.textContent = formatPeso(Math.round(roomSubTotal));
        if (breakfastTotalAmount) breakfastTotalAmount.textContent = formatPeso(Math.round(extrasTotal));
        if (subTotalAmount) subTotalAmount.textContent = formatPeso(Math.round(subtotal));
        if (vatAmount) vatAmount.textContent = formatPeso(Math.round(vat));
        if (grandTotalAmount) grandTotalAmount.textContent = formatPeso(Math.round(total));
        if (computedTotalInput) computedTotalInput.value = Math.round(total);
    };

    breakfastMinus?.addEventListener('click', () => {
        if (!breakfastQtyEl) return;
        breakfastQtyEl.value = clampQty((parseInt(breakfastQtyEl.value || '0', 10) || 0) - 1);
        updateTotals();
    });

    breakfastPlus?.addEventListener('click', () => {
        if (!breakfastQtyEl) return;
        breakfastQtyEl.value = clampQty((parseInt(breakfastQtyEl.value || '0', 10) || 0) + 1);
        updateTotals();
    });

    breakfastQtyEl?.addEventListener('input', updateTotals);
    breakfastQtyEl?.addEventListener('blur', updateTotals);
    updateTotals();

    const modalEl = document.getElementById('gcashPayModal');
    if (!modalEl) return;

    if (modalEl.parentElement !== document.body) {
        document.body.appendChild(modalEl);
    }

    const paid = document.getElementById('paidNow');
    const terms = document.getElementById('agreeTerms');
    const btn = document.getElementById('confirmPayBtn');

    const toggle = () => {
        if (!paid || !terms || !btn) return;
        btn.disabled = !(paid.checked && terms.checked);
    };

    paid?.addEventListener('change', toggle);
    terms?.addEventListener('change', toggle);
    toggle();

    modalEl.addEventListener('shown.bs.modal', function () {
        const ref = modalEl.querySelector('input[name="reference_code"]');
        ref?.focus();
    });

    <?php if($errors->any()): ?>
        if (window.bootstrap) {
            new bootstrap.Modal(modalEl).show();
        }
    <?php endif; ?>
});
</script>

<style>
/* Make the payment modal nicer on desktop */
#gcashPayModal .modal-dialog{
  max-width: 520px;
}

#gcashPayModal .modal-content{
  border-radius: 18px;
}

/* Prevent the modal from becoming too tall */
#gcashPayModal .modal-body{
  max-height: 75vh;
  overflow-y: auto;
  padding: 24px;
}

/* QR image sizing */
#gcashPayModal img[alt="GCash QR"]{
  width: 100%;
  max-width: 280px;
  height: auto;
  border-radius: 14px;
  display: block;
  margin: 0 auto;
}

/* Inputs look better */
#gcashPayModal .form-control{
  height: 46px;
  border-radius: 12px;
  font-size: 15px;
}

.vd-room-extra{
  margin-top: 12px;
  padding-top: 12px;
  border-top: 1px dashed rgba(15, 23, 43, .16);
}

.vd-room-extra__title{
  font-size: .78rem;
  font-weight: 800;
  letter-spacing: .08em;
  text-transform: uppercase;
  color: #374151;
  margin-bottom: .45rem;
}

.vd-room-extra__list{
  list-style: none;
  padding: 0;
  margin: 0;
  display: grid;
  gap: .35rem;
}

.vd-room-extra__list li{
  display: flex;
  align-items: flex-start;
  gap: .45rem;
  color: #4b5563;
  font-size: .93rem;
  line-height: 1.35;
}

.vd-room-extra__list i{
  color: #FEA116;
  margin-top: .08rem;
}
</style>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\V18\resources\views/orders/create.blade.php ENDPATH**/ ?>