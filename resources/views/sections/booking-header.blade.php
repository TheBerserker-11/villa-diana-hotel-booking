<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<section class="vd-booking-wrap">
    <div class="container">
        <div class="vd-booking-card wow fadeIn" data-wow-delay="0.1s">
            <div class="vd-booking-head">
                <div>
                    <h3 class="vd-booking-title mb-1">Check Booking Availability</h3>
                    <p class="vd-booking-sub mb-0">Pick your dates, guests, and room type — we’ll show what’s available.</p>
                </div>
            </div>

            <form id="availabilityForm" method="GET" action="{{ route('rooms.index') }}" class="vd-booking-form">
                <div class="row g-3 align-items-end">

                    <div class="col-12 col-md-4">
                        <label class="vd-label" for="check_in">Check-in</label>
                        <div class="js-field-feedback-wrap" data-for="check_in">
                            @error('check_in')
                                <div class="invalid-feedback d-block js-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="vd-field vd-date">
                            <i class="fa fa-calendar-alt"></i>
                            <input
                                name="check_in"
                                type="text"
                                id="check_in"
                                class="form-control vd-input @error('check_in') is-invalid @enderror"
                                placeholder="Select date"
                                value="{{ request()->query('check_in') }}"
                                readonly
                            >
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <label class="vd-label" for="check_out">Check-out</label>
                        <div class="js-field-feedback-wrap" data-for="check_out">
                            @error('check_out')
                                <div class="invalid-feedback d-block js-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="vd-field vd-date">
                            <i class="fa fa-calendar-alt"></i>
                            <input
                                name="check_out"
                                type="text"
                                id="check_out"
                                class="form-control vd-input @error('check_out') is-invalid @enderror"
                                placeholder="Select date"
                                value="{{ request()->query('check_out') }}"
                                readonly
                            >
                        </div>
                    </div>

                    <div class="col-12 col-md-4 vd-guests-wrap">
                        <label class="vd-label">Guests</label>

                        @php
                            $adultCount  = (int) request()->query('adults', 1);
                            $childCount  = (int) request()->query('children', 0);
                            $infantCount = (int) request()->query('infants', 0);
                            $totalGuests = max(1, $adultCount + $childCount + $infantCount);
                        @endphp

                        <button
                            id="vdGuestsToggle"
                            class="vd-guest-toggle"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#vdGuestsPanel"
                            aria-expanded="false"
                            aria-controls="vdGuestsPanel"
                        >
                            <span class="vd-guest-left">
                                <i class="fa fa-users"></i>
                                <span>
                                    <strong id="vdGuestTotal">{{ $totalGuests }}</strong>
                                    <span id="vdGuestLabel">guest{{ $totalGuests > 1 ? 's' : '' }}</span>
                                </span>
                            </span>
                            <span class="vd-guest-right">
                                Edit <i class="fa fa-chevron-down ms-2"></i>
                            </span>
                        </button>

                        <div class="collapse" id="vdGuestsPanel">
                            <div class="vd-guest-panel">

                                <div class="vd-guest-row">
                                    <div>
                                        <div class="vd-guest-name">Adults</div>
                                        <div class="vd-guest-sub">Ages 13 or above</div>
                                    </div>
                                    <div class="input-group guest-counter vd-counter" data-type="adult">
                                        <button type="button" class="vd-counter-btn decrement" aria-label="Decrease adults">−</button>
                                        <input id="vdAdults" type="number" name="adults" class="vd-counter-input" value="{{ request()->query('adults', 1) }}" min="1" max="22" inputmode="numeric">
                                        <button type="button" class="vd-counter-btn increment" aria-label="Increase adults">+</button>
                                    </div>
                                </div>

                                <div class="vd-guest-row">
                                    <div>
                                        <div class="vd-guest-name">Children</div>
                                        <div class="vd-guest-sub">Ages 2–12</div>
                                    </div>
                                    <div class="input-group guest-counter vd-counter" data-type="child">
                                        <button type="button" class="vd-counter-btn decrement" aria-label="Decrease children">−</button>
                                        <input id="vdChildren" type="number" name="children" class="vd-counter-input" value="{{ request()->query('children', 0) }}" min="0" max="22" inputmode="numeric">
                                        <button type="button" class="vd-counter-btn increment" aria-label="Increase children">+</button>
                                    </div>
                                </div>

                                <div class="vd-guest-row">
                                    <div>
                                        <div class="vd-guest-name">Infants</div>
                                        <div class="vd-guest-sub">Under 2</div>
                                    </div>
                                    <div class="input-group guest-counter vd-counter" data-type="infant">
                                        <button type="button" class="vd-counter-btn decrement" aria-label="Decrease infants">−</button>
                                        <input id="vdInfants" type="number" name="infants" class="vd-counter-input" value="{{ request()->query('infants', 0) }}" min="0" max="10" inputmode="numeric">
                                        <button type="button" class="vd-counter-btn increment" aria-label="Increase infants">+</button>
                                    </div>
                                </div>

                                <div class="vd-guest-row">
                                    <div>
                                        <div class="vd-guest-name">Pets</div>
                                        <div class="vd-guest-sub">Bringing a service animal?</div>
                                    </div>
                                    <div class="input-group guest-counter vd-counter" data-type="pet">
                                        <button type="button" class="vd-counter-btn decrement" aria-label="Decrease pets">−</button>
                                        <input id="vdPets" type="number" name="pets" class="vd-counter-input" value="{{ request()->query('pets', 0) }}" min="0" max="5" inputmode="numeric">
                                        <button type="button" class="vd-counter-btn increment" aria-label="Increase pets">+</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="vd-booking-foot">
                    <div class="vd-booking-note">
                        <i class="fa fa-info-circle me-2"></i>
                        Booked Rooms are automatically disabled.
                    </div>

                    <button type="submit" class="vd-booking-btn">
                        <i class="fa fa-search me-2"></i> Check Availability
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const bookedRanges = @json($bookedRanges ?? []);

  const form = document.getElementById('availabilityForm');

  const checkInEl = document.getElementById('check_in');
  const checkOutEl = document.getElementById('check_out');

  const adultsEl = document.getElementById('vdAdults');
  const childrenEl = document.getElementById('vdChildren');
  const infantsEl = document.getElementById('vdInfants');

  const totalEl = document.getElementById('vdGuestTotal');
  const labelEl = document.getElementById('vdGuestLabel');

  const panel = document.getElementById('vdGuestsPanel');
  const toggle = document.getElementById('vdGuestsToggle');

  const MAX_TOTAL_GUESTS = 22;

  const clamp = (n, min, max) => {
    n = parseInt(n, 10);
    if (Number.isNaN(n)) n = min;
    return Math.max(min, Math.min(max, n));
  };

  const totals = () => {
    const adults = parseInt(adultsEl?.value || '1', 10) || 1;
    const children = parseInt(childrenEl?.value || '0', 10) || 0;
    const infants = parseInt(infantsEl?.value || '0', 10) || 0;
    return { adults, children, infants, total: adults + children + infants };
  };

  const updateSummary = () => {
    const { total } = totals();
    if (totalEl) totalEl.textContent = total;
    if (labelEl) labelEl.textContent = total === 1 ? 'guest' : 'guests';
  };

  const isValidDate = (s) => /^\d{4}-\d{2}-\d{2}$/.test(String(s || '').trim());

  const showFieldError = (input, msg) => {
    if (!input) return;
    input.classList.add('is-invalid');

    const col = input.closest('.col-12') || input.closest('.col-md-4') || input.parentElement;
    if (!col) return;

    const fieldKey = input.id || input.name || '';
    let wrap = col.querySelector(`.js-field-feedback-wrap[data-for="${fieldKey}"]`);

    if (!wrap) {
      wrap = document.createElement('div');
      wrap.className = 'js-field-feedback-wrap';
      if (fieldKey) wrap.dataset.for = fieldKey;

      const label = col.querySelector('.vd-label');
      if (label) {
        label.insertAdjacentElement('afterend', wrap);
      } else {
        col.prepend(wrap);
      }
    }

    let fb = wrap.querySelector('.invalid-feedback.js-feedback');
    if (!fb) {
      fb = document.createElement('div');
      fb.className = 'invalid-feedback js-feedback d-block';
      wrap.appendChild(fb);
    }
    fb.textContent = msg;

    input.scrollIntoView({ behavior: 'smooth', block: 'center' });
    setTimeout(() => input.focus(), 150);
  };

  const clearFieldError = (input) => {
    if (!input) return;
    input.classList.remove('is-invalid');

    const col = input.closest('.col-12') || input.closest('.col-md-4') || input.parentElement;
    if (!col) return;

    const fieldKey = input.id || input.name || '';
    const wrap = col.querySelector(`.js-field-feedback-wrap[data-for="${fieldKey}"]`) || col.querySelector('.js-field-feedback-wrap');
    const fb = wrap?.querySelector('.invalid-feedback.js-feedback');
    if (fb) fb.remove();
  };

  document.querySelectorAll('.guest-counter').forEach(counter => {
    const input = counter.querySelector('input');
    const dec = counter.querySelector('.decrement');
    const inc = counter.querySelector('.increment');
    const type = counter.dataset.type;

    const rules = {
      adult:  { min: 1, max: 22 },
      child:  { min: 0, max: 22 },
      infant: { min: 0, max: 10 },
      pet:    { min: 0, max: 5 },
    };

    const { min, max } = rules[type] || { min: 0, max: 99 };
    if (!input) return;

    input.value = clamp(input.value, min, max);

    dec?.addEventListener('click', () => {
      input.value = clamp((parseInt(input.value || '0', 10) - 1), min, max);
      updateSummary();
    });

    inc?.addEventListener('click', () => {
      if (type !== 'pet') {
        const { total } = totals();
        if (total >= MAX_TOTAL_GUESTS) return;
      }
      input.value = clamp((parseInt(input.value || '0', 10) + 1), min, max);
      updateSummary();
    });

    input.addEventListener('input', () => {
      if (input.value === '') return;
      input.value = clamp(input.value, min, max);
      updateSummary();
    });

    input.addEventListener('blur', () => {
      input.value = clamp(input.value, min, max);
      updateSummary();
    });
  });

  updateSummary();

  const fpLocale = {
    firstDayOfWeek: 1,
    weekdays: {
      shorthand: ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'],
      longhand: ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
    },
    months: {
      shorthand: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
      longhand: ['January','February','March','April','May','June','July','August','September','October','November','December'],
    }
  };

  const checkInValue = "{{ request()->query('check_in') }}";
  const checkOutValue = "{{ request()->query('check_out') }}";

  const getShowMonths = () => (window.innerWidth >= 992 ? 2 : 1);

  let checkOutPicker;

  const checkInPicker = flatpickr('#check_in', {
    minDate: 'today',
    dateFormat: 'Y-m-d',
    defaultDate: checkInValue || null,
    showMonths: getShowMonths(),
    clickOpens: false,
    allowInput: false,
    disableMobile: true,
    weekNumbers: false,
    locale: fpLocale,
    disable: bookedRanges,
    onChange: (_, dateStr) => {
      clearFieldError(checkInEl);

      if (!checkOutPicker) return;

      const nextDay = new Date(dateStr + 'T00:00:00');
      nextDay.setDate(nextDay.getDate() + 1);

      checkOutPicker.set('minDate', nextDay);

      if ((checkOutEl?.value || '') && checkOutEl.value <= dateStr) {
        checkOutPicker.clear();
        checkOutEl.value = '';
      }

      setTimeout(() => checkOutPicker.open(), 150);
    }
  });

  checkOutPicker = flatpickr('#check_out', {
    minDate: checkInValue
      ? (() => {
          const nextDay = new Date(checkInValue + 'T00:00:00');
          nextDay.setDate(nextDay.getDate() + 1);
          return nextDay;
        })()
      : 'today',
    dateFormat: 'Y-m-d',
    defaultDate: checkOutValue || null,
    showMonths: getShowMonths(),
    clickOpens: false,
    allowInput: false,
    disableMobile: true,
    weekNumbers: false,
    locale: fpLocale,
    disable: bookedRanges,
    onChange: () => clearFieldError(checkOutEl),
  });

  const togglePicker = (picker) => {
    if (!picker) return;
    picker.isOpen ? picker.close() : picker.open();
  };

  checkInEl?.addEventListener('click', (e) => {
    e.preventDefault();
    togglePicker(checkInPicker);
  });

  checkOutEl?.addEventListener('click', (e) => {
    e.preventDefault();
    if (!checkInEl?.value) {
      showFieldError(checkInEl, 'Please select your check-in date first.');
      return;
    }
    togglePicker(checkOutPicker);
  });

  window.addEventListener('resize', () => {
    const months = getShowMonths();
    checkInPicker?.set('showMonths', months);
    checkOutPicker?.set('showMonths', months);
  });

  form?.addEventListener('submit', (e) => {
    clearFieldError(checkInEl);
    clearFieldError(checkOutEl);

    const checkIn = (checkInEl?.value || '').trim();
    const checkOut = (checkOutEl?.value || '').trim();

    if (!isValidDate(checkIn)) {
      e.preventDefault();
      showFieldError(checkInEl, 'Please select your check-in date.');
      return;
    }

    if (!isValidDate(checkOut)) {
      e.preventDefault();
      showFieldError(checkOutEl, 'Please select your check-out date.');
      return;
    }

    if (checkOut <= checkIn) {
      e.preventDefault();
      showFieldError(checkOutEl, 'Check-out must be after check-in.');
      return;
    }

    const { total } = totals();
    if (total < 1) {
      e.preventDefault();
      alert('Please select guest quantity (at least 1 guest).');

      if (panel && window.bootstrap && bootstrap.Collapse) {
        bootstrap.Collapse.getOrCreateInstance(panel).show();
      }
      adultsEl?.focus();
    }
  });

  document.addEventListener('click', (e) => {
    if (!panel || !toggle) return;
    const inside = panel.contains(e.target) || toggle.contains(e.target);
    if (!inside && panel.classList.contains('show')) {
      if (window.bootstrap && bootstrap.Collapse) {
        bootstrap.Collapse.getOrCreateInstance(panel).hide();
      } else if (window.jQuery) {
        window.jQuery(panel).collapse('hide');
      }
    }
  });

  if (window.jQuery && window.jQuery.fn && window.jQuery.fn.select2) {
    window.jQuery('.vd-select2').each(function () {
      const $el = window.jQuery(this);
      if ($el.data('select2')) return;
      $el.select2({
        width: '100%',
        minimumResultsForSearch: 8,
        dropdownParent: window.jQuery('.vd-booking-card')
      });
    });
  }
});
</script>
