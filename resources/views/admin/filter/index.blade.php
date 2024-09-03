             <div class="filter">
                 <a class="icon" href="#" data-bs-toggle="dropdown"><i
                         class="bi bi-three-dots"></i></a>
                 <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                     <li class="dropdown-header text-start">
                         <h6>Filter</h6>
                     </li>
                     <li><a class="dropdown-item" href="#" onclick="dayWise(`{{ $lastDay }}`)">LastDay</a></li>
                     <li><a class="dropdown-item" href="#" onclick="dayWise(`{{ $last7Day }}`)">Last7Days</a></li>
                     <li><a class="dropdown-item" href="#" onclick="dayWise(`{{ $last30Day }}`)">Last30Days</a></li>
                     <li><a class="dropdown-item" href="#" onclick="dayWise(`{{ $last90Day }}`)">Last90Days</a></li>
                 </ul>
             </div>
             <script>
                 function dayWise($value) {
                     const localStorageItem = localStorage.getItem("statistic")
                     const data = JSON.parse(localStorageItem);
                     console.log(data[$value]);
                     console.log($value);
                     if ($value == 'salesThisDay' || $value == 'salesThisMonth' || $value == 'salesThisWeek' || $value == 'salesThisYear')
                         $('#total-revenue').text('£' + data[$value].toFixed(2));

                     else if ($value == 'doctorOrdersThisYear' || $value == 'doctorOrdersThisDay' || $value == 'doctorOrdersThisWeek' || $value == 'doctorOrdersThisMonth')
                         $('#orders-doctors').text(data[$value]);

                     else if ($value == 'despensoryOrdersThisYear' || $value == 'despensoryOrdersThisDay' || $value == 'despensoryOrdersThisWeek' || $value == 'despensoryOrdersThisYear')
                         $('#orders-dispensaries').text(data[$value]);

                     else if ($value == 'paidOrdersThisYear' || $value == 'paidOrdersThisDay' || $value == 'paidOrdersThisWeek' || $value == 'paidOrdersThisYear')
                         $('#paid-orders').text(data[$value]);

                     else if ($value == 'pendingOrdersThisYear' || $value == 'pendingOrdersThisDay' || $value == 'pendingOrdersThisWeek' || $value == 'pendingOrdersThisYear')
                         $('#pending-orders').text(data[$value]);

                     else if ($value == 'totalOrdersThisMonth' || $value == 'totalOrdersThisWeek' || $value == 'totalOrdersThisDay' || $value == 'totalOrdersThisYear')
                         $('#total-orders').text(data[$value]);
                 }
             </script>