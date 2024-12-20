@php
    $totalNotifications = auth()->user()->unreadNotifications->count();
@endphp
    <!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="/dashboard" class="logo d-flex align-items-center">
            <img src="{{ asset('img/logo.webp') }}" alt="">
            <span class="d-none d-lg-block">
                {{ auth()->user()->getRoleNames()->first() ? Str::of(auth()->user()->getRoleNames()->first())->replace('_', ' ')->title() : '' }}
            </span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <!-- <div class="search-bar">
        <form class="search-form d-flex align-items-center" method="POST" action="#">
          <input type="text" name="query" placeholder="Search" title="Enter search keyword">
          <button type="submit" title="Search"><i class="bi bi-search"></i></button>
        </form>
      </div> -->
    <!-- End Search Bar -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle " href="#">
                    <i class="bi bi-search"></i>
                </a>
            </li><!-- End Search Icon-->

            <li class="nav-item dropdown">
                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-bell"></i>
                    <span class="badge bg-primary badge-number"
                          id="total-unread-notifications">{{ $totalUnreadNotifications ?? 0 }}</span>
                </a>

                <!-- Notifications Dropdown -->
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications"
                    style="height:70vh; overflow-y:auto;">
                    <li class="dropdown-header">
                        You have <span id="total-unread-notifications">{{ $totalUnreadNotifications ?? 0 }}</span> new
                        notifications
                        <a href="{{ route('admin.allReadNotifications') }}"><span
                                class="badge rounded-pill bg-primary p-2 ms-2">Mark all</span></a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <!-- Notification List -->
                    <ul id="notification-list">
                        @forelse(auth()->user()->unreadNotifications as $notification)
                            <li class="notification-item">
                                <i class="bi bi-exclamation-circle text-info"></i>
                                <div>
                                    <h4>Hi! {{ auth()->user()->name ?? '' }}</h4>
                                    <p>Here is new order placed. #{{ $notification->data['id'] ?? '' }}</p>
                                    <a href="{{ route('admin.orderDetail', ['id' => base64_encode($notification->data['id'])]) }}">View
                                        Details</a>
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                        @empty
                            <li class="notification-item">
                                <i class="bi bi-exclamation-circle text-warning"></i>
                                <div>
                                    <h4>No Notifications Available.</h4>
                                </div>
                            </li>
                        @endforelse
                    </ul>
                </ul>
            </li>

            <li class="nav-item dropdown">

                <!-- <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-chat-left-text"></i>
                    <span class="badge bg-success badge-number">3</span>
                  </a> -->
                <!-- End Messages Icon -->

                <!-- <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
            <li class="dropdown-header">
              You have 3 new messages
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="{{ asset('/assets/admin/img/messages-1.jpg') }}" alt="" class="rounded-circle">
                <div>
                  <h4>Maria Hudson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>4 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="{{ asset('/assets/admin/img/messages-2.jpg') }}" alt="" class="rounded-circle">
                <div>
                  <h4>Anna Nelson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>6 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="{{ asset('/assets/admin/img/messages-3.jpg') }}" alt="" class="rounded-circle">
                <div>
                  <h4>David Muldon</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>8 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="dropdown-footer">
              <a href="#">Show all messages</a>
            </li>

          </ul> -->
                <!-- End Messages Dropdown Items -->

            </li>
            <!-- End Messages Nav -->

            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="{{ asset('/assets/admin/img/profile-img.png') }}" alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2">{{ auth()->user()->name ?? ''}}</span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{ auth()->user()->name ?? ''}}</h6>
                        <span>{{ auth()->user()->role ?? ''}}</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <!--     <li>
                        <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                          <i class="bi bi-person"></i>
                          <span>My Profile</span>
                        </a>
                      </li>
                      <li>
                        <hr class="dropdown-divider">
                      </li>

                      <li>
                        <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                          <i class="bi bi-gear"></i>
                          <span>Account Settings</span>
                        </a>
                      </li>
                      <li>
                        <hr class="dropdown-divider">
                      </li>

                      <li>
                        <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                          <i class="bi bi-question-circle"></i>
                          <span>Need Help?</span>
                        </a>
                      </li>
                      <li>
                        <hr class="dropdown-divider">
                      </li>-->

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('web.logout') }}">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>

                </ul>
                <!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header>
<!-- End Header -->

<script>
    $(document).ready(function () {
        function fetchNotifications() {
            $.ajax({
                url: '{{ route("admin.notifications.unread") }}',
                method: 'GET',
                success: function (data) {
                    let notificationsList = '';
                    let totalUnreadNotifications = data.length;

                    if (totalUnreadNotifications > 0) {
                        data.forEach(function (notification) {
                            let encodedId = btoa(notification.data.id);
                            let detailUrl = '{{ route("admin.orderDetail", ["id" => "ENCODED_ID"]) }}'.replace('ENCODED_ID', encodedId);
                            notificationsList += `
                                <li class="notification-item">
                                    <i class="bi bi-exclamation-circle text-info"></i>
                                    <div>
                                        <h4>Hi! {{ auth()->user()->name ?? '' }}</h4>
                                        <p>Here is new order placed. #${notification.data.id ?? ''}</p>
                                        <a href="${detailUrl}">View Details</a>
                                    </div>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                            `;
                        });
                    } else {
                        notificationsList = `
                            <li class="notification-item">
                                <i class="bi bi-exclamation-circle text-warning"></i>
                                <div>
                                    <h4>No Notifications Available.</h4>
                                </div>
                            </li>
                        `;
                    }

                    $('#notification-list').html(notificationsList);
                    $('#total-unread-notifications').text(totalUnreadNotifications);
                },
                error: function (error) {
                    console.log('Error fetching notifications:', error);
                }
            });
        }

        // Fetch notifications on page load
        fetchNotifications();

        // Fetch notifications every 5 seconds
        setInterval(fetchNotifications, 5000);
    })
</script>


<x-notify::notify/>
