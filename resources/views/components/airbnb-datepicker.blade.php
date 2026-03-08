<div class="airbnb-search">

    <!-- ====================== -->
    <!--       TABS            -->
    <!-- ====================== -->
    <div class="airbnb-tabs">
        <button class="tab active" data-tab="dates">Dates</button>
        <button class="tab" data-tab="months">Months</button>
        <button class="tab" data-tab="flexible">Flexible</button>
    </div>

    <!-- ====================== -->
    <!--      TAB CONTENTS      -->
    <!-- ====================== -->

    <!-- DATES -->
    <div class="tab-content active" id="dates">
        <div class="calendar-container">
            <div id="calendar-left" class="calendar"></div>
            <div id="calendar-right" class="calendar"></div>
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
    <!-- GUEST PICKER -->
    <!-- ====================== -->

    <div class="guest-selector">
        <div class="guest-row">
            <div>
                <h4>Adults</h4>
                <p>Ages 13 or above</p>
            </div>
            <div class="counter">
                <button class="minus" data-target="adults">−</button>
                <span id="count-adults">0</span>
                <button class="plus" data-target="adults">+</button>
            </div>
        </div>

        <div class="guest-row">
            <div>
                <h4>Children</h4>
                <p>Ages 2 – 12</p>
            </div>
            <div class="counter">
                <button class="minus" data-target="children">−</button>
                <span id="count-children">0</span>
                <button class="plus" data-target="children">+</button>
            </div>
        </div>

        <div class="guest-row">
            <div>
                <h4>Infants</h4>
                <p>Under 2</p>
            </div>
            <div class="counter">
                <button class="minus" data-target="infants">−</button>
                <span id="count-infants">0</span>
                <button class="plus" data-target="infants">+</button>
            </div>
        </div>

        <div class="guest-row">
            <div>
                <h4>Pets</h4>
                <p>Bringing a service animal?</p>
            </div>
            <div class="counter">
                <button class="minus" data-target="pets">−</button>
                <span id="count-pets">0</span>
                <button class="plus" data-target="pets">+</button>
            </div>
        </div>
    </div>

    <!-- ====================== -->
    <!--  HIDDEN LARAVEL INPUTS -->
    <!-- ====================== -->
    <input type="hidden" name="check_in" id="check_in">
    <input type="hidden" name="check_out" id="check_out">

    <input type="hidden" name="guests_adults" id="input-adults">
    <input type="hidden" name="guests_children" id="input-children">
    <input type="hidden" name="guests_infants" id="input-infants">
    <input type="hidden" name="guests_pets" id="input-pets">

</div>


<!-- ====================== -->
<!--        CSS             -->
<!-- ====================== -->
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

/* CALENDAR layout */
.calendar-container {
    display: flex;
    gap: 20px;
}

.calendar {
    width: 300px;
    height: 320px;
    border: 1px solid #ddd;
    padding: 10px;
}

/* MONTH GRID */
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
}
.month-item:hover {
    background: #f7f7f7;
}

/* FLEXIBLE */
.flex-options {
    display: flex;
    gap: 20px;
}
.flex-item {
    padding: 12px 20px;
    border: 1px solid #ddd;
    cursor: pointer;
}
.flex-item:hover {
    background: #f7f7f7;
}

/* GUEST PICKER */
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
}
.counter span {
    width: 20px;
    display: inline-block;
    text-align: center;
}
</style>


<!-- ====================== -->
<!--        JS              -->
<!-- ====================== -->
<script>
/* ---------------- Tabs ---------------- */
document.querySelectorAll(".tab").forEach(tab => {
    tab.addEventListener("click", () => {
        document.querySelector(".tab.active").classList.remove("active");
        tab.classList.add("active");

        document.querySelector(".tab-content.active").classList.remove("active");
        document.getElementById(tab.dataset.tab).classList.add("active");
    });
});

/* ---------------- Guest Counters ---------------- */
const counters = ["adults","children","infants","pets"];

counters.forEach(type => {
    const minus = document.querySelector(`.minus[data-target="${type}"]`);
    const plus = document.querySelector(`.plus[data-target="${type}"]`);
    const display = document.getElementById(`count-${type}`);
    const input = document.getElementById(`input-${type}`);

    let count = 0;

    plus.addEventListener("click", () => {
        count++;
        display.textContent = count;
        input.value = count;
    });

    minus.addEventListener("click", () => {
        if(count > 0) {
            count--;
            display.textContent = count;
            input.value = count;
        }
    });
});

/* ---------------- SIMPLE CALENDARS ---------------- */
/* You can replace these with your own custom logic */
document.getElementById("calendar-left").innerHTML = "<h3>Calendar 1</h3>";
document.getElementById("calendar-right").innerHTML = "<h3>Calendar 2</h3>";

</script>
