@extends('admin.layouts.default')
@section('title', 'Doctors')
@section('content')

<style>
    .profile-widget {
        background-color: #fff;
        border-radius: 4px;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
        padding: 20px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .doctor-img {
        cursor: pointer;
        height: 80px;
        margin: 0 auto 15px;
        position: relative;
        width: 80px;
    }

    .action-icon {
        color: #777;
        font-size: 18px;
        padding: 0 10px;
        display: inline-block;
    }

    .fa {
        display: inline-block;
        font: normal normal normal 14px/1 FontAwesome;
        font-size: inherit;
        text-rendering: auto;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    .dropdown-menu {
        font-size: 13px;
    }

    .dropdown-menu {
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 3px;
        transform-origin: left top 0;
        box-shadow: inherit;
        background-color: #fff;
    }

    .dropdown-menu-right {
        right: 0;
        left: auto;
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 1000;
        display: none;
        float: left;
        min-width: 10rem;
        padding: 0.5rem 0;
        margin: 0.125rem 0 0;
        font-size: 1rem;
        color: #212529;
        text-align: left;
        list-style: none;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid rgba(0, 0, 0, .15);
        border-radius: 0.25rem;
    }

    .dropdown-item:first-child {
        border-top-left-radius: calc(0.25rem - 1px);
        border-top-right-radius: calc(0.25rem - 1px);
    }

    .dropdown-item {
        display: block;
        width: 100%;
        padding: 0.25rem 1.5rem;
        clear: both;
        font-weight: 400;
        color: #212529;
        text-align: inherit;
        white-space: nowrap;
        background-color: transparent;
        border: 0;
    }

    .doctor-name {
        margin: 0;
    }

    .text-ellipsis {
        display: block;
        max-width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .doc-prof {
        color: #777;
        font-size: 12px;
        margin-bottom: 10px;
    }

    .doctor-img .avatar {
        font-size: 24px;
        height: 80px;
        line-height: 80px;
        margin: 0;
        width: 80px;
    }

    .avatar {
        background-color: #aaa;
        border-radius: 50%;
        color: #fff;
        display: inline-block;
        font-weight: 500;
        height: 38px;
        line-height: 38px;
        margin: 0 10px 0 0;
        overflow: hidden;
        text-align: center;
        text-decoration: none;
        text-transform: uppercase;
        vertical-align: middle;
        width: 38px;
        position: relative;
        white-space: nowrap;
    }

    .dropdown.profile-action {
        position: absolute;
        right: 5px;
        text-align: right;
        top: 10px;
    }
</style>


<!-- main stated -->
<main id="main" class="main">

    <div class="pagetitle">
        <h1><a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-primary-outline fw-bold "><i class="bi bi-arrow-left"></i> Back</a> | Health Care Professionals</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item">Pages</li>
                <li class="breadcrumb-item active">Health Care Professionals</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            @foreach($doctors as $key => $value)
                <div class="col-md-4 col-sm-4  col-lg-3">
                    <div class="profile-widget">
                        <div class="doctor-img">
                            <a class="avatar" href="profile.html"> <img class="img-fluid" src="http://127.0.0.1:8000/assets/admin/img/profile-img.jpg" alt=""></a>
                        </div>
                        <h4 class="doctor-name text-ellipsis"><a href="profile.html">{{ $value['name'] ?? ''}}</a></h4>
                        <div class="doc-prof">{{ $value['speciality'] ?? ''}}</div>
                        <div class="user-country">
                            <i class="bi bi-geo-alt-fill"></i> {{ $value['address'] ?? ''}}
                        </div>
                        <div class="row">
                            <div class="d-grid mt-2">
                                <a class="btn btn-primary bg-primary edit" data-id="{{$value['id']}}"  type="button"><i class=" me-3 bi bi-eye-fill"></i>View
                                    Profile</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

</main>
<!-- End #main -->

<form  id="edit_form" action="{{route('admin.addDoctor')}}" method="post">
    @csrf
    <input id="edit_form_id_input" type="hidden" value="" name="id">
</form>
@stop

@pushOnce('scripts')
<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });

    $(document).ready(function () {
        $('.edit').click(function () {
            var id = $(this).data('id'); 
            $('#edit_form_id_input').val(id); 
            $('#edit_form').submit(); 
        });

        $('.delete').click(function () {
            var id = $(this).data('id'); 
            $('#edit_form_id_input').val(id); 
            $('#edit_form').submit();
        });
    })
</script>
@endPushOnce