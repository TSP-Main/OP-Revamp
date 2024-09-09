@extends('admin.layouts.default')
@section('title', 'Dashboard')
@section('content')

<head>
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com'" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i'"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/admin/dashboard/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/dashboard/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/dashboard/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/dashboard/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/dashboard/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/dashboard/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/dashboard/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ 'assets/admin/dashboard/css/style.css' }}" rel="stylesheet">
</head>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- Total Revenue Card -->
                    <div class="col-xl-4">
                        <div class="card info-card revenue-card">
                            @include('admin.filter.index',['card'=>'card1','lastDay' => 'salesThisDay','last7Day' => 'salesThisWeek','last30Day' => 'salesThisMonth','last90Day' => 'salesThisYear'])
                            <div class="card-body">
                                <h5 class="card-title card1">Revenue <span></span></h5>

                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-pound"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 id="total-revenue">Loading...</h6>
                                        <!-- <span class="text-success small pt-1 fw-bold">8%</span> <span
                                                class="text-muted small pt-2 ps-1">increase</span> -->
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Total Revenue Card -->

                    <!-- Orders for Doctors Card -->
                    <div class="col-xl-4">
                        <div class="card info-card customers-card">
                            @include('admin.filter.index',['card'=>'card2','lastDay' => 'doctorOrdersThisDay','last7Day' => 'doctorOrdersThisWeek','last30Day' => 'doctorOrdersThisMonth','last90Day' => 'doctorOrdersThisYear'])
                            <div class="card-body">
                                <h5 class="card-title card2">Order For Doctor <span>| This Month</span></h5>

                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 id="orders-doctors">Loading...</h6>
                                        <!-- <span class="text-danger small pt-1 fw-bold">12%</span> <span
                                                class="text-muted small pt-2 ps-1">decrease</span> -->
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Orders for Doctors Card -->

                    <!-- Orders for Dispensaries Card -->
                    <div class="col-xl-4">
                        <div class="card info-card customers-card">
                            @include('admin.filter.index',['card'=>'card3','lastDay' => 'despensoryOrdersThisDay','last7Day' => 'despensoryOrdersThisWeek','last30Day' => 'despensoryOrdersThisMonth','last90Day' => 'despensoryOrdersThisYear']) <div class="card-body">
                                <h5 class="card-title card3">Order For Dispensary <span>| This Month</span></h5>

                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 id="orders-dispensaries">Loading...</h6>
                                        <!-- <span class="text-danger small pt-1 fw-bold">12%</span> <span
                                                class="text-muted small pt-2 ps-1">decrease</span> -->
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Orders for Dispensaries Card -->

                </div><!-- End Row -->

            </div>
            <!-- End Left side columns -->

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">


                    <!-- Total Orders Card -->
                    <div class="col-xl-4 col-md-6">
                        <div class="card info-card total-orders-card">
                            @include('admin.filter.index',['card'=>'card4','lastDay' => 'totalOrdersThisDay','last7Day' => 'totalOrdersThisWeek','last30Day' => 'totalOrdersThisMonth','last90Day' => 'totalOrdersThisYear'])
                            <div class="card-body">
                                <h5 class="card-title card4">Total Orders <span>| This Month</span></h5>

                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-bag-check"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 id="total-orders">Loading...</h6>
                                        <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span
                                                class="text-muted small pt-2 ps-1">increase</span> -->
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Total Orders Card -->

                    <!-- Pending Orders Card -->
                    <div class="col-xl-4 col-md-6">
                        <div class="card info-card pending-orders-card">
                            @include('admin.filter.index',['card'=>'card5','lastDay' => 'pendingOrdersThisDay','last7Day' => 'pendingOrdersThisWeek','last30Day' => 'pendingOrdersThisMonth','last90Day' => 'pendingOrdersThisYear'])
                            <div class="card-body">
                                <h5 class="card-title card5">Pending Orders <span>| This Month</span></h5>

                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-hourglass-split"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 id="pending-orders">Loading...</h6>
                                        <!-- <span class="text-danger small pt-1 fw-bold">5%</span> <span
                                                class="text-muted small pt-2 ps-1">decrease</span> -->
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Pending Orders Card -->

                    <!-- Paid Orders Card -->
                    <div class="col-xl-4 col-md-6">
                        <div class="card info-card paid-orders-card">
                            @include('admin.filter.index',['card'=>'card6','lastDay' => 'paidOrdersThisDay','last7Day' => 'paidOrdersThisWeek','last30Day' => 'paidOrdersThisMonth','last90Day' => 'paidOrdersThisYear'])
                            <div class="card-body">
                                <h5 class="card-title card6">Paid Orders <span>| This Month</span></h5>

                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-pound"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 id="paid-orders">Loading...</h6>
                                        <!-- <span class="text-success small pt-1 fw-bold">8%</span> <span
                                                class="text-muted small pt-2 ps-1">increase</span> -->
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Paid Orders Card -->

                    <!-- Reports -->
                    <div class="col-12">
                        <div class="card">
                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#" onclick="updateChart('weekly')">This Week</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="updateChart('monthly')">This Month</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="updateChart('yearly')">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Reports</h5>

                                <!-- Line Chart -->
                                <div id="reportsChart"></div>
                            </div>
                        </div>
                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                const localStorageItem = localStorage.getItem("statistic");
                                const salesData = JSON.parse(localStorageItem);

                                const generateDateArray = (days) => {
                                    const dateArray = [];
                                    for (let i = days - 1; i >= 0; i--) {
                                        const date = new Date();
                                        date.setDate(date.getDate() - i);
                                        dateArray.push(date.toISOString().split('T')[0]); // Format as YYYY-MM-DD
                                    }
                                    return dateArray;
                                };

                                // Generate date arrays for 7, 30, and 90 days
                                const last7Days = generateDateArray(7);
                                const last30Days = generateDateArray(30);
                                const last90Days = generateDateArray(90);

                                const createSalesDataArray = (dateArray, salesData) => {
                                    const salesDataLookup = {};
                                    salesData.forEach(data => {
                                        salesDataLookup[data.date] = data.total_sales;
                                    });

                                    return dateArray.map(date => ({
                                        date: date,
                                        total_sales: salesDataLookup[date] || 0 // Use 0 if no sales data for the date
                                    }));
                                };

                                const weeklySalesData = createSalesDataArray(last7Days, salesData["weeklyGraphData"]);
                                const monthlySalesData = createSalesDataArray(last30Days, salesData["monthlyGraphData"]);
                                const yearlySalesData = createSalesDataArray(last90Days, salesData["yearlyGraphData"]);

                                const chart = new ApexCharts(document.querySelector("#reportsChart"), {
                                    series: [{
                                        name: 'Sales',
                                        data: weeklySalesData.map(data => data.total_sales),
                                    }],
                                    chart: {
                                        height: 350,
                                        type: 'area',
                                        toolbar: {
                                            show: false
                                        },
                                    },
                                    markers: {
                                        size: 4
                                    },
                                    colors: ['#4154f1'],
                                    fill: {
                                        type: "gradient",
                                        gradient: {
                                            shadeIntensity: 1,
                                            opacityFrom: 0.3,
                                            opacityTo: 0.4,
                                            stops: [0, 90, 100]
                                        }
                                    },
                                    dataLabels: {
                                        enabled: false
                                    },
                                    stroke: {
                                        curve: 'smooth',
                                        width: 2
                                    },
                                    xaxis: {
                                        type: 'datetime',
                                        categories: last7Days,
                                    },
                                    tooltip: {
                                        x: {
                                            format: 'dd/MM/yy'
                                        },
                                    }
                                });

                                chart.render();

                                // Function to update chart based on the selected period
                                window.updateChart = (period) => {
                                    let updatedData;
                                    let updatedCategories;

                                    if (period === 'weekly') {
                                        // updatedData = createSalesDataArray(generateDateArray(1), salesData["weeklyGraphData"]);
                                        // updatedCategories = generateDateArray(1);
                                        updatedData = weeklySalesData;
                                        updatedCategories = last7Days;
                                    } else if (period === 'monthly') {
                                        updatedData = monthlySalesData;
                                        updatedCategories = last30Days;
                                    } else if (period === 'yearly') {
                                        updatedData = yearlySalesData;
                                        updatedCategories = last90Days;
                                    }
                                    //  else {
                                    //     updatedData = weeklySalesData;
                                    //     updatedCategories = last7Days;
                                    // }

                                    chart.updateSeries([{
                                        data: updatedData.map(data => data.total_sales)
                                    }]);

                                    chart.updateOptions({
                                        xaxis: {
                                            categories: updatedCategories
                                        }
                                    });
                                };
                            });
                        </script>
                    </div>

                    <!-- Recent Sales -->
                    <div class="col-12 d-none">
                        <div class="card recent-sales overflow-auto">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Recent Sales <span>| Today</span></h5>

                                <table class="table table-borderless datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Customer</th>
                                            <th scope="col">Product</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row"><a href="#">#2457</a></th>
                                            <td>Brandon Jacob</td>
                                            <td><a href="#" class="text-primary">At praesentium minu</a></td>
                                            <td><i class="bi bi-currency-pound"></i>64</td>
                                            <td><span class="badge bg-success">Approved</span></td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><a href="#">#2147</a></th>
                                            <td>Bridie Kessler</td>
                                            <td><a href="#" class="text-primary">Blanditiis dolor omnis
                                                    similique</a></td>
                                            <td><i class="bi bi-currency-pound"></i>47</td>
                                            <td><span class="badge bg-warning">Pending</span></td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><a href="#">#2049</a></th>
                                            <td>Ashleigh Langosh</td>
                                            <td><a href="#" class="text-primary">At recusandae consectetur</a>
                                            </td>
                                            <td><i class="bi bi-currency-pound"></i>147</td>
                                            <td><span class="badge bg-success">Approved</span></td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><a href="#">#2644</a></th>
                                            <td>Angus Grady</td>
                                            <td><a href="#" class="text-primar">Ut voluptatem id earum et</a>
                                            </td>
                                            <td><i class="bi bi-currency-pound"></i>67</td>
                                            <td><span class="badge bg-danger">Rejected</span></td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><a href="#">#2644</a></th>
                                            <td>Raheem Lehner</td>
                                            <td><a href="#" class="text-primary">Sunt similique distinctio</a>
                                            </td>
                                            <td><i class="bi bi-currency-pound"></i>165</td>
                                            <td><span class="badge bg-success">Approved</span></td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div>
                    <!-- End Recent Sales -->

                    <!-- Top Selling -->
                    <div class="col-12 d-none">
                        <div class="card top-selling overflow-auto">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body pb-0">
                                <h5 class="card-title">Top Selling <span>| Today</span></h5>

                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th scope="col">Preview</th>
                                            <th scope="col">Product</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Sold</th>
                                            <th scope="col">Revenue</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row"><a href="#"><img
                                                        src="{{ asset('assets/admin/dashboard/img/product-1.jpg') }}"
                                                        alt=""></a></th>
                                            <td><a href="#" class="text-primary fw-bold">Ut inventore ipsa
                                                    voluptas nulla</a></td>
                                            <td><i class="bi bi-currency-pound"></i>64</td>
                                            <td class="fw-bold">124</td>
                                            <td><i class="bi bi-currency-pound"></i>5,828</td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><a href="#"><img
                                                        src="{{ asset('assets/admin/dashboard/img/product-2.jpg') }}"
                                                        alt=""></a></th>
                                            <td><a href="#" class="text-primary fw-bold">Exercitationem
                                                    similique doloremque</a></td>
                                            <td><i class="bi bi-currency-pound"></i>46</td>
                                            <td class="fw-bold">98</td>
                                            <td><i class="bi bi-currency-pound"></i>4,508</td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><a href="#"><img
                                                        src="{{ asset('assets/admin/dashboard/img/product-3.jpg') }}"
                                                        alt=""></a></th>
                                            <td><a href="#" class="text-primary fw-bold">Doloribus nisi
                                                    exercitationem</a></td>
                                            <td><i class="bi bi-currency-pound"></i>59</td>
                                            <td class="fw-bold">74</td>
                                            <td><i class="bi bi-currency-pound"></i>4,366</td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><a href="#"><img
                                                        src="{{ asset('assets/admin/dashboard/img/product-4.jpg') }}"
                                                        alt=""></a></th>
                                            <td><a href="#" class="text-primary fw-bold">Officiis quaerat sint
                                                    rerum error</a></td>
                                            <td><i class="bi bi-currency-pound"></i>32</td>
                                            <td class="fw-bold">63</td>
                                            <td><i class="bi bi-currency-pound"></i>2,016</td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><a href="#"><img
                                                        src="{{ asset('assets/admin/dashboard/img/product-5.jpg') }}"
                                                        alt=""></a></th>
                                            <td><a href="#" class="text-primary fw-bold">Sit unde debitis
                                                    delectus repellendus</a></td>
                                            <td><i class="bi bi-currency-pound"></i>79</td>
                                            <td class="fw-bold">41</td>
                                            <td><i class="bi bi-currency-pound"></i>3,239</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div>
                    <!-- End Top Selling -->

                </div>
            </div>
            <!-- End Left side columns -->

            <!-- Right side columns -->
            <div class="col-lg-4">

                <!-- Recent Activity -->

                <!-- Budget Report -->
                <!-- <div class="card">
                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                    class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>

                                <li><a class="dropdown-item" href="#">Today</a></li>
                                <li><a class="dropdown-item" href="#">This Month</a></li>
                                <li><a class="dropdown-item" href="#">This Year</a></li>
                            </ul>
                        </div>

                        <div class="card-body pb-0">
                            <h5 class="card-title">Budget Report <span>| This Month</span></h5>

                            <div id="budgetChart" style="min-height: 400px;" class="echart"></div>

                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                    var budgetChart = echarts.init(document.querySelector("#budgetChart")).setOption({
                                        legend: {
                                            data: ['Allocated Budget', 'Actual Spending']
                                        },
                                        radar: {
                                            // shape: 'circle',
                                            indicator: [{
                                                    name: 'Sales',
                                                    max: 6500
                                                },
                                                {
                                                    name: 'Administration',
                                                    max: 16000
                                                },
                                                {
                                                    name: 'Information Technology',
                                                    max: 30000
                                                },
                                                {
                                                    name: 'Customer Support',
                                                    max: 38000
                                                },
                                                {
                                                    name: 'Development',
                                                    max: 52000
                                                },
                                                {
                                                    name: 'Marketing',
                                                    max: 25000
                                                }
                                            ]
                                        },
                                        series: [{
                                            name: 'Budget vs spending',
                                            type: 'radar',
                                            data: [{
                                                    value: [4200, 3000, 20000, 35000, 50000, 18000],
                                                    name: 'Allocated Budget'
                                                },
                                                {
                                                    value: [5000, 14000, 28000, 26000, 42000, 21000],
                                                    name: 'Actual Spending'
                                                }
                                            ]
                                        }]
                                    });
                                });
                            </script>

                        </div>
                    </div> -->
                <!-- End Budget Report -->

                <!-- Website Traffic -->
                <div class="card d-none">
                    <div class="filter">
                        <!-- <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                    class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>

                                <li><a class="dropdown-item" href="#">Today</a></li>
                                <li><a class="dropdown-item" href="#">This Month</a></li>
                                <li><a class="dropdown-item" href="#">This Year</a></li>
                            </ul> -->
                    </div>

                    <div class="card-body pb-0">
                        <h5 class="card-title">Website Traffic <span>| Today</span></h5>

                        <div id="trafficChart" style="min-height: 400px;" class="echart"></div>

                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                echarts.init(document.querySelector("#trafficChart")).setOption({
                                    tooltip: {
                                        trigger: 'item'
                                    },
                                    legend: {
                                        top: '5%',
                                        left: 'center'
                                    },
                                    series: [{
                                        name: 'Access From',
                                        type: 'pie',
                                        radius: ['40%', '70%'],
                                        avoidLabelOverlap: false,
                                        label: {
                                            show: false,
                                            position: 'center'
                                        },
                                        emphasis: {
                                            label: {
                                                show: true,
                                                fontSize: '18',
                                                fontWeight: 'bold'
                                            }
                                        },
                                        labelLine: {
                                            show: false
                                        },
                                        data: [{
                                                value: 1048,
                                                name: 'Search Engine'
                                            },
                                            {
                                                value: 735,
                                                name: 'Direct'
                                            },
                                            {
                                                value: 580,
                                                name: 'Email'
                                            },
                                            {
                                                value: 484,
                                                name: 'Union Ads'
                                            },
                                            {
                                                value: 300,
                                                name: 'Video Ads'
                                            }
                                        ]
                                    }]
                                });
                            });
                        </script>

                    </div>
                </div>
                <!-- End Website Traffic -->



            </div>
            <!-- End Right side columns -->

        </div>
    </section>

</main><!-- End #main -->


@pushOnce('scripts')
<!-- Vendor JS Files -->
<script src="{{ asset('assets/admin/vendor/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/chart.js/chart.umd.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/echarts/echarts.min.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/quill/quill.min.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/simple-datatables/simple-datatables.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/php-email-form/validate.js') }}"></script>

<!-- Template Main JS File -->
<script src="{{ asset('assets/admin/assets/js/main.js') }}"></script>


<script>
    $(document).ready(function() {
        dashboard();
    });

    function dashboard() {
        $.ajax({
            url: "{{ route('admin.dashboard.detail') }}",
            type: "GET",
            success: function(data) {
                console.log(data.doctorOrdersThisMonth);
                window.localStorage.setItem("statistic", JSON.stringify(data));
                $('#total-revenue').text('£' + data.salesThisMonth.toFixed(2));
                $('#orders-doctors').text(data.doctorOrdersThisMonth);
                $('#orders-dispensaries').text(data.despensoryOrdersThisMonth);
                $('#total-orders').text(data.totalOrdersThisMonth);
                $('#pending-orders').text(data.pendingOrdersThisMonth);
                $('#paid-orders').text(data.paidOrdersThisMonth);
            },
            error: function(error) {
                console.error("There was an error fetching the dashboard details:", error);
            }
        });
    }
</script>

@endPushOnce