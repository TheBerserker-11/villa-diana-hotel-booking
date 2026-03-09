<div class="airbnb-search">
    <script>
        const bookedRanges = @json($bookedRanges ?? []);
    </script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- ====================== -->
    <!--       TABS            -->
    <!-- ====================== -->
    <div class="airbnb-tabs">
        <button class="tab active" type="button" data-tab="dates">Dates</button>
        <button class="tab" type="button" data-tab="months">Months</button>
        <button class="tab" type="button" data-tab="flexible">Flexible</button>
    </div>

    <!-- ====================== -->
    <!--      TAB CONTENTS      -->
    <!-- ====================== -->

    <!-- DATES -->
    <div class="tab-content active" id="dates">
        <div class="calendar-container">
            <div class="calendar-block">
                <div class="calendar-title">Check-in</div>
                <div id="calendar-left" class="calendar"></div>
            </div>

            <div class="calendar-block">
                <div class="calendar-title">Check-out</div>
                <div id="calendar-right" class="calendar"></div>
            </div>
        </div>

        <div class="selected-dates">
            <div class="selected-date-box">
                <span class="label">Check-in</span>
                <strong id="display-check-in">Not selected</strong>
            </div>
            <div class="selected-date-box">
                <span class="label">Check-out</span>
                <strong id="display-check-out">Not selected</strong>
            </div>
        </div>
    </div>

    <!-- MONTHS -->
    <div class="tab-content" id="months">
        <div class="months-grid">
            @foreach(['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'] as $month)
                <div class="month-item" data-month="{{ $month }}">{{ $month }}</div>
            @endforeach
        </div>
    </div>

    <!-- FLEXIBLE -->
    <div class="tab-content" id="flexible">
        <div class="flex-options">
            <div class="flex-item" data-flex="weekend">Weekend</div>
            <div class="flex-item" data-flex="week">Week</div>
            <div class="flex-item" data-flex="month">Month</div>
        </div>
    </div>

    <!-- ====================== -->
    <!-- GUEST PICKER          -->
    <!-- ====================== -->
    <div class="guest-selector">
        <div class="guest-row">
            <div>
                <h4>Adults</h4>
                <p>Ages 13 or above</p>
            </div>
            <div class="counter">
                <button type="button" class="minus" data-target="adults">−</button>
                <span id="count-adults">1</span>
                <button type="button" class="plus" data-target="adults">+</button>
            </div>
        </div>

        <div class="guest-row">
            <div>
                <h4>Children</h4>
                <p>Ages 2 – 12</p>
            </div>
            <div class="counter">
                <button type="button" class="minus" data-target="children">−</button>
                <span id="count-children">0</span>
                <button type="button" class="plus" data-target="children">+</button>
            </div>
        </div>

        <div class="guest-row">
            <div>
                <h4>Infants</h4>
                <p>Under 2</p>
            </div>
            <div class="counter">
                <button type="button" class="minus" data-target="infants">−</button>
                <span id="count-infants">0</span>
                <button type="button" class="plus" data-target="infants">+</button>
            </div>
        </div>

        <div class="guest-row">
            <div>
                <h4>Pets</h4>
                <p>Bringing a service animal?</p>
            </div>
            <div class="counter">
                <button type="button" class="minus" data-target="pets">−</button>
                <span id="count-pets">0</span>
                <button type="button" class="plus" data-target="pets">+</button>
            </div>
        </div>
    </div>

    <!-- ====================== -->
    <!--  HIDDEN LARAVEL INPUTS -->
    <!-- ====================== -->
    <input type="hidden" name="check_in" id="check_in" value="{{ request('check_in') }}">
    <input type="hidden" name="check_out" id="check_out" value="{{ request('check_out') }}">

    <input type="hidden" name="adults" id="input-adults" value="{{ request('adults', 1) }}">
    <input type="hidden" name="children" id="input-children" value="{{ request('children', 0) }}">
    <input type="hidden" name="infants" id="input-infants" value="{{ request('infants', 0) }}">
    <input type="hidden" name="pets" id="input-pets" value="{{ request('pets', 0) }}">
</div>

<style>
.airbnb-tabs {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
}

.airbnb-tabs .tab {
    padding: 8px 20px;
    border: none;
    background: none;
    font-size: 16px;
    cursor: pointer;
    border-bottom: 2px solid transparent;
    font-weight: 600;
}

.airbnb-tabs .tab.active {
    border-bottom: 2px solid black;
}

.tab-content {
    display: none;
}
.tab-content.active {
    display: block;
}

.calendar-container {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.calendar-block {
    flex: 1;
    min-width: 280px;
}

.calendar-title {
    font-size: 15px;
    font-weight: 700;
    margin-bottom: 10px;
    color: #222;
}

.calendar {
    width: 100%;
    min-height: 340px;
    border: 1px solid #ddd;
    border-radius: 14px;
    padding: 12px;
    background: #fff;
}

.selected-dates {
    display: flex;
    gap: 14px;
    margin-top: 18px;
    flex-wrap: wrap;
}

.selected-date-box {
    flex: 1;
    min-width: 220px;
    border: 1px solid #e5e5e5;
    border-radius: 12px;
    padding: 12px 14px;
    background: #fafafa;
}

.selected-date-box .label {
    display: block;
    font-size: 12px;
    color: #777;
    margin-bottom: 4px;
}

.months-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
}

.month-item {
    padding: 12px;
    text-align: center;
    border: 1px solid #ddd;
    cursor: pointer;
    border-radius: 10px;
}
.month-item:hover {
    background: #f7f7f7;
}

.flex-options {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}
.flex-item {
    padding: 12px 20px;
    border: 1px solid #ddd;
    cursor: pointer;
    border-radius: 10px;
}
.flex-item:hover {
    background: #f7f7f7;
}

.guest-selector {
    margin-top: 25px;
    border-top: 1px solid #ddd;
    padding-top: 20px;
}

.guest-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 0;
    border-bottom: 1px solid #eee;
    gap: 12px;
}

.guest-row h4 {
    margin: 0;
    font-size: 16px;
}

.guest-row p {
    margin: 0;
    font-size: 12px;
    color: gray;
}

.counter {
    display: flex;
    align-items: center;
    gap: 10px;
}

.counter button {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 1px solid #bbb;
    background: white;
    cursor: pointer;
    font-size: 18px;
    line-height: 1;
}

.counter span {
    width: 24px;
    display: inline-block;
    text-align: center;
    font-weight: 600;
}

.flatpickr-day.flatpickr-disabled,
.flatpickr-day.flatpickr-disabled:hover {
    background: #f3f4f6 !important;
    color: #b91c1c !important;
    text-decoration: line-through;
    cursor: not-allowed !important;
}

.flatpickr-day.selected,
.flatpickr-day.startRange,
.flatpickr-day.endRange {
    background: #111827 !important;
    border-color: #111827 !important;
    color: #fff !important;
}

@media (max-width: 768px) {
    .calendar-container {
        flex-direction: column;
    }

    .months-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {
    /* ---------------- Tabs ---------------- */
    document.querySelectorAll(".tab").forEach(tab => {
        tab.addEventListener("click", () => {
            document.querySelector(".tab.active")?.classList.remove("active");
            tab.classList.add("active");

            document.querySelector(".tab-content.active")?.classList.remove("active");
            document.getElementById(tab.dataset.tab)?.classList.add("active");
        });
    });

    /* ---------------- Guest Counters ---------------- */
    const config = {
        adults:  { min: 1, max: 22, value: parseInt(document.getElementById("input-adults")?.value || "1", 10) || 1 },
        children:{ min: 0, max: 22, value: parseInt(document.getElementById("input-children")?.value || "0", 10) || 0 },
        infants: { min: 0, max: 10, value: parseInt(document.getElementById("input-infants")?.value || "0", 10) || 0 },
        pets:    { min: 0, max: 5, value: parseInt(document.getElementById("input-pets")?.value || "0", 10) || 0 }
    };

    const updateCounterUI = (type) => {
        document.getElementById(`count-${type}`).textContent = config[type].value;
        document.getElementById(`input-${type}`).value = config[type].value;
    };

    Object.keys(config).forEach(type => updateCounterUI(type));

    Object.keys(config).forEach(type => {
        const minus = document.querySelector(`.minus[data-target="${type}"]`);
        const plus = document.querySelector(`.plus[data-target="${type}"]`);

        plus?.addEventListener("click", () => {
            if (config[type].value < config[type].max) {
                config[type].value++;
                updateCounterUI(type);
            }
        });

        minus?.addEventListener("click", () => {
            if (config[type].value > config[type].min) {
                config[type].value--;
                updateCounterUI(type);
            }
        });
    });

    /* ---------------- Dates ---------------- */
    const checkInInput = document.getElementById("check_in");
    const checkOutInput = document.getElementById("check_out");
    const displayCheckIn = document.getElementById("display-check-in");
    const displayCheckOut = document.getElementById("display-check-out");

    const formatDisplayDate = (dateStr) => {
        if (!dateStr) return "Not selected";
        const date = new Date(dateStr + "T00:00:00");
        return date.toLocaleDateString("en-US", {
            year: "numeric",
            month: "short",
            day: "numeric"
        });
    };

    const initialCheckIn = checkInInput?.value || null;
    const initialCheckOut = checkOutInput?.value || null;

    if (displayCheckIn) displayCheckIn.textContent = formatDisplayDate(initialCheckIn);
    if (displayCheckOut) displayCheckOut.textContent = formatDisplayDate(initialCheckOut);

    let checkOutPicker;

    const checkInPicker = flatpickr("#calendar-left", {
        inline: true,
        minDate: "today",
        dateFormat: "Y-m-d",
        defaultDate: initialCheckIn,
        disable: bookedRanges,
        onChange: function(selectedDates, dateStr) {
            if (checkInInput) checkInInput.value = dateStr;
            if (displayCheckIn) displayCheckIn.textContent = formatDisplayDate(dateStr);

            if (checkOutInput && checkOutInput.value && checkOutInput.value <= dateStr) {
                checkOutInput.value = "";
                if (displayCheckOut) displayCheckOut.textContent = "Not selected";
                checkOutPicker.clear();
            }

            if (checkOutPicker) {
                const nextDay = new Date(dateStr + "T00:00:00");
                nextDay.setDate(nextDay.getDate() + 1);
                checkOutPicker.set("minDate", nextDay);
            }
        }
    });

    checkOutPicker = flatpickr("#calendar-right", {
        inline: true,
        minDate: initialCheckIn ? new Date(new Date(initialCheckIn + "T00:00:00").setDate(new Date(initialCheckIn + "T00:00:00").getDate() + 1)) : "today",
        dateFormat: "Y-m-d",
        defaultDate: initialCheckOut,
        disable: bookedRanges,
        onChange: function(selectedDates, dateStr) {
            if (checkOutInput) checkOutInput.value = dateStr;
            if (displayCheckOut) displayCheckOut.textContent = formatDisplayDate(dateStr);
        }
    });
});
</script>
