<div class="filter">
    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
        <li class="dropdown-header text-start">
            <h6>Filter</h6>
        </li>
        <li><a class="dropdown-item" href="#" onclick="dayWise(`{{ $lastDay }}`,'This Day',`{{$card}}`)">Today</a></li>
        <li><a class="dropdown-item" href="#" onclick="dayWise(`{{ $last7Day }}`,'This Week',`{{$card}}`)">Last 7 Days</a></li>
        <li><a class="dropdown-item" href="#" onclick="dayWise(`{{ $last30Day }}`,'This Month',`{{$card}}`)">Last 30 Days</a></li>
        <li><a class="dropdown-item" href="#" onclick="dayWise(`{{ $last90Day }}`,'This Year',`{{$card}}`)">Last Three Month</a></li>
    </ul>
</div>

<script>
    // Function to format number with commas
    function formatNumberWithCommas(number) {
        let numParts = number.toString().split('.');
        numParts[0] = numParts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return numParts.join('.');
    }

    function dayWise(value, time, card) {
        const localStorageItem = localStorage.getItem("statistic");
        const data = JSON.parse(localStorageItem);
        const spanElement = document.querySelector(`.${card} span`);
        spanElement.textContent = `| ${time}`;
        
        if (value == 'salesThisDay' || value == 'salesThisMonth' || value == 'salesThisWeek' || value == 'salesThisYear') {
            $('#total-revenue').text('£' + formatNumberWithCommas(parseFloat(data[value]).toFixed(2)));
        } else if (value == 'doctorOrdersThisYear' || value == 'doctorOrdersThisDay' || value == 'doctorOrdersThisWeek' || value == 'doctorOrdersThisMonth') {
            $('#orders-doctors').text(formatNumberWithCommas(data[value]));
        } else if (value == 'despensoryOrdersThisYear' || value == 'despensoryOrdersThisDay' || value == 'despensoryOrdersThisWeek' || value == 'despensoryOrdersThisMonth') {
            $('#orders-dispensaries').text(formatNumberWithCommas(data[value]));
        } else if (value == 'paidOrdersThisYear' || value == 'paidOrdersThisDay' || value == 'paidOrdersThisWeek' || value == 'paidOrdersThisMonth') {
            $('#paid-orders').text(formatNumberWithCommas(data[value]));
        } else if (value == 'pendingOrdersThisYear' || value == 'pendingOrdersThisDay' || value == 'pendingOrdersThisWeek' || value == 'pendingOrdersThisMonth') {
            $('#pending-orders').text(formatNumberWithCommas(data[value]));
        } else if (value == 'totalOrdersThisMonth' || value == 'totalOrdersThisWeek' || value == 'totalOrdersThisDay' || value == 'totalOrdersThisYear') {
            $('#total-orders').text(formatNumberWithCommas(data[value]));
        }
    }
</script>
