@extends('admin.layouts.default')
@section('title', 'Contact')
@section('content')
<style>
  .dataTables_wrapper .dataTables_filter {
    float: right;
    text-align: right;
    visibility: hidden;
  }
</style>
<!-- main stated -->
<main id="main" class="main">

  <div class="pagetitle">
    <h1><a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-primary-outline fw-bold "><i class="bi bi-arrow-left"></i> Back</a> | Contact</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item">Pages</li>
        <li class="breadcrumb-item active">Contact</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section contact">

    <div class="row gy-4">

      <div class="col-xl-12">
        <div class="row">
          <div class="col-lg-6">
            <div class="info-box card">
              <i class="bi bi-geo-alt"></i>
              <h3>Address</h3>
              @if($user->role == user_roles(1))
              <form class="row needs-validation" action="{{ route('admin.storeCompanyDetails')}}" method="post" novalidate>
                @csrf
                <input type="hidden" name="detail_type" value="address">
                <input type="text" class="form-control my-2" name="address1" value="{{$contact_details['address1']['content'] ?? ''}}" placeholder="company address 1">
                <div class="invalid-feedback">Please enter your address!</div>
                <input type="text" class="form-control my-2" name="address2" value="{{$contact_details['address2']['content'] ?? ''}}" placeholder="company address 2">
                <div class="row">
                  <div class="col-6"></div>
                  <div class="col-6 d-flex justify-content-end my-2 ">
                    <input type="submit" class="btn btn-success px-4 bg-success fw-bold" value="Update">
                  </div>
                </div>
              </form>
              @else
              <p>{{$contact_details['address1']['content'] ?? ''}},<br>{{$contact_details['address2']['content'] ?? ''}}</p>
              @endif
            </div>
          </div>
          <div class="col-lg-6">
            <div class="info-box card">
              <i class="bi bi-telephone"></i>
              <h3>Call Us</h3>
              @if($user->role == user_roles(1))
              <form class="row needs-validation" action="{{ route('admin.storeCompanyDetails')}}" method="post" novalidate>
                @csrf
                <input type="hidden" name="detail_type" value="phone">
                <input type="text" class="form-control my-2" name="phone1" value="{{$contact_details['phone1']['content'] ?? ''}}" placeholder="company phone 1">
                <div class="invalid-feedback">Please enter your phone!</div>
                <input type="text" class="form-control my-2" name="phone2" value="{{$contact_details['phone2']['content'] ?? ''}}" placeholder="company phone 2">
                <div class="row">
                  <div class="col-6"></div>
                  <div class="col-6 d-flex justify-content-end my-2 ">
                    <input type="submit" class="btn btn-success px-4 bg-success fw-bold" value="Update">
                  </div>
                </div>
              </form>
              @else
              <p>{{$contact_details['phone1']['content'] ?? ''}},<br>{{$contact_details['phone2']['content'] ?? ''}}</p>
              @endif

            </div>
          </div>
          <div class="col-lg-6">
            <div class="info-box card">
              <i class="bi bi-envelope"></i>
              <h3>Email Us</h3>
              @if($user->role == user_roles(1))
              <form class="row needs-validation" action="{{ route('admin.storeCompanyDetails')}}" method="post" novalidate>
                @csrf
                <input type="hidden" name="detail_type" value="email">
                <input type="text" class="form-control my-2" name="email1" value="{{$contact_details['email1']['content'] ?? ''}}" placeholder="company email 1">
                <div class="invalid-feedback">Please enter your email!</div>
                <input type="text" class="form-control my-2" name="email2" value="{{$contact_details['email2']['content'] ?? ''}}" placeholder="company email 2">
                <div class="row">
                  <div class="col-6"></div>
                  <div class="col-6 d-flex justify-content-end my-2 ">
                    <input type="submit" class="btn btn-success px-4 bg-success fw-bold" value="Update">
                  </div>
                </div>
              </form>
              @else
              <p>{{$contact_details['email1']['content'] ?? ''}},<br>{{$contact_details['email2']['content'] ?? ''}}</p>
              @endif
            </div>
          </div>
          <div class="col-lg-6">
            <div class="info-box card">
              <i class="bi bi-clock"></i>
              <h3>Open Hours</h3>
              @if($user->role == user_roles(1))
              <form class="row needs-validation" action="{{ route('admin.storeCompanyDetails')}}" method="post" novalidate>
                @csrf
                <input type="hidden" name="detail_type" value="timing">
                <input type="text" class="form-control my-2" name="timing1" value="{{$contact_details['timing1']['content'] ?? ''}}" placeholder="company timing 1">
                <div class="invalid-feedback">Please enter your timing!</div>
                <input type="text" class="form-control my-2" name="timing2" value="{{$contact_details['timing2']['content'] ?? ''}}" placeholder="company timing 2">
                <div class="row">
                  <div class="col-6"></div>
                  <div class="col-6 d-flex justify-content-end my-2 ">
                    <input type="submit" class="btn btn-success px-4 bg-success fw-bold" value="Update">
                  </div>
                </div>
              </form>
              @else
              <p>{{$contact_details['timing1']['content'] ?? ''}}, {{$contact_details['timing2']['content'] ?? ''}}</p>
              @endif
            </div>
          </div>
        </div>
        @if($user->role == user_roles(4))
        <div class="col-xl-12 ">
          <div class="card p-4">
            <h3 class="fw-bold display-6 text-center mt-2 mb-3"> Send Your Quries</h3>

            <form class="row needs-validation" action="{{ route('admin.storeQuery')}}" method="post" novalidate>
              @csrf
              <input type="hidden" name="id" id="query_id" value="{{ $query['id'] ?? ''}}">
              <input type="hidden" name="type" id="type" value="contact" required>
              @error('type')
              <div class="alert-danger text-danger ">{{ $message }}</div>
              @enderror
              <div class="row gy-4">
                <div class="col-md-6">
                  <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                  <div class="invalid-feedback">Please enter your Name!</div>
                  @error('name')
                  <div class="alert-danger text-danger ">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-6 ">
                  <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                  <div class="invalid-feedback">Please enter your email!</div>
                  @error('email')
                  <div class="alert-danger text-danger ">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-12">
                  <input type="text" class="form-control" name="subject" placeholder="Subject" required>
                  <div class="invalid-feedback">Please enter subject of Query!</div>
                  @error('subject')
                  <div class="alert-danger text-danger ">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-12">
                  <textarea class="form-control" name="message" rows="6" placeholder="Message" required></textarea>
                  <div class="invalid-feedback">Please write message for support!</div>
                  @error('message')
                  <div class="alert-danger text-danger ">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-12 text-center">
                  <button type="submit" class="btn btn-primary bg-primary">Send Message</button>
                </div>

              </div>
            </form>
          </div>
        </div>
        @endif
        <div class="col-xl-12 ">
          <div class="card p-4">
            <h3 class="fw-bold display-6 text-center mt-2 mb-3"> Users Received Quries</h3>
            <div class="row">
              <div class="col-lg-12">

                <div class="card">
                  <div class="row mb-3 px-4">
                    <div class="col-md-12 mt-3 text-center d-block">
                      <label for="search" class="form-label fw-bold">Search From Table </label>
                      <input type="text" id="search" placeholder="Search here..." class="form-control py-2">
                    </div>
                  </div>
                  <div class="card-body">
                    <table id="tbl_data" class="table table-striped">
                      <thead class="thead-dark">
                        <tr>
                          <th>#</th>
                          <th>User Name</th>
                          <th>User Email</th>
                          <th>Subject</th>
                          <th>message</th>
                          <th>Date-Time</th>
                          <th>Order Type</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($queries ?? [] as $key => $val)
                        <tr>
                          <td>
                            <span class="  fw-bold">{{ ++$key }} </span>

                          </td>
                          <td>
                            <span class="  fw-bold">{{ $val['name'] ?? ''}} </span>
                          </td>
                          <td>
                            <span class="  fw-bold">{{ $val['email'] ?? ''}} </span>
                          </td>
                          <td>
                            <span class="  fw-bold">{{ $val['subject'] ?? ''}} </span>
                          </td>
                          <td>
                            <span class="  fw-bold">{{ $val['message'] ?? ''}} </span>
                          </td>
                          @php
                          $isNewOrder = null;
                          if($val['status'] == 'Active'):
                          $createdAt = isset($val['created_at']) ? strtotime($val['created_at']) : null;
                          $isNewQuery = $createdAt && ($createdAt > strtotime('-3 days'));
                          endif;
                          @endphp
                          <td>
                            @if($isNewQuery)
                            <span class="badge bg-primary">New Query</span> <br>
                            @endif
                            {{date_time_uk($val['created_at'])}}
                          </td>
                          <td>
                            <span class="  fw-bold">{{ $val['type'] ?? ''}} </span>
                          </td>
                          <td><span class="btn  fw-bold {{ $val['status'] == 'Regected' ?  'btn-danger' :'' }} {{ $val['status'] == 'Active' ?  'btn-success' :'' }} {{ $val['status'] == 'Resolved' ?  'btn-primary' :'' }} {{ $val['status'] == 'Not_Approved' ?  'btn-danger' :'' }} rounded-pill">{{ $val['status'] ?? '' }}</span></td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                  <!-- /.card-body -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </section>
</main>
<!-- End #main -->

@stop

@pushOnce('scripts')
<script>
  $(function() {
    $("#tbl_data").DataTable({
      "paging": true,
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "searching": true,
      "ordering": true,
      "info": true,
    });
  });
</script>
@endPushOnce