@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')

<div class="card">
    <div class="card-header border-success row" style="margin: 0px;">
        <h3 class="col-12">
            จัดการผู้ใช้
            <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#addUser" style="float: right;"> <i class="fas fa-plus-circle"></i> เพิ่มผู้ใช้ </button>
        </h3>
    </div>
    
    <div class="card-body text-center">
        <table class="table">
            <thead class="border-success">
                <tr>
                    <th>#</th>
                    <th>ชื่อ</th>
                    <th>อีเมล</th>
                    <th>แก้ไข</th>
                    <th>ลบ</th>
                    <th>เปลี่ยนรหัสผ่าน</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->uname }}</td>
                        <td>{{ $user->email }}</td>
                        <td> <a class="btn btn-outline-warning" data-toggle="modal" data-target="#editUser{{ $user->id }}"><i class="far fa-edit"></i></a> </td>
                        <td> <a href="/admin/deleteUser?user_id={{ $user->id }}" onclick= "return confirm('ยืนยันการลบ?');" class="btn btn-outline-danger"> <i class="far fa-trash-alt"></i> </a> </td>
                        <td> <a class="btn btn-outline-success" data-toggle="modal" data-target="#editPassword{{ $user->id }}"><i class="fas fa-key"></i></a> </td>
                    </tr>

                    <!-- Modal edit -->
                    <div class="modal fade" id="editUser{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <!-- Form -->
                                <form action="/admin/editUser" method="post" enctype="multipart/form-data" >
                                {{ csrf_field() }}
                                    <div class="modal-header bg-warning">
                                        <h5 class="modal-title text-white" id="exampleModalLabel">แก้ไขผู้ใช้</h5>
                                        <br>
                                        <button type="button" class="close text-white " data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <input type="hidden" name="id" value="{{ $user->id }}">

                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend" style="width: 40%;">
                                                        <span class="input-group-text" style="width: 100%;">ชื่อ</span>
                                                    </div>
                                                    <input type="text" name="name" class="form-control" value="{{ $user->uname }}">
                                                </div>

                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend" style="width: 40%;">
                                                        <span class="input-group-text" style="width: 100%;">อีเมล</span>
                                                    </div>
                                                    <input type="text" name="email" class="form-control" value="{{ $user->email }}">
                                                </div>

                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend" style="width: 40%;">
                                                        <span class="input-group-text" style="width: 100%;">agent</span>
                                                    </div>
                                                    <select name="web_agent" class="form-control">
                                                        <option value="{{ $user->web_agent }}">{{ $user->aname }}</option>
                                                        @foreach ($agents as $agent)
                                                            @if ($user->web_agent != $agent->agent_id)
                                                                <option value="{{$agent->agent_id}}">{{$agent->name}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
                                        <button type="submit" class="btn btn-success">ยืนยัน</button>
                                    </div>
                                </form>
                                <!-- Form -->
                            </div>
                        </div>
                    </div>

                    <!-- Modal edit password -->
                    <div class="modal fade" id="editPassword{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <!-- Form -->
                                <form action="/admin/changePassword" method="post" enctype="multipart/form-data" >
                                {{ csrf_field() }}
                                    <div class="modal-header bg-warning">
                                        <h5 class="modal-title text-white" id="exampleModalLabel">เปลี่ยนรหัสผ่าน</h5>
                                        <br>
                                        <button type="button" class="close text-white " data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <input type="hidden" name="id" value="{{ $user->id }}">

                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend" style="width: 40%;">
                                                        <span class="input-group-text" style="width: 100%;">รหัสผ่านใหม่</span>
                                                    </div>
                                                    <input type="password" name="password"  id="edit_password" class="form-control">
                                                </div>

                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend" style="width: 40%;">
                                                        <span class="input-group-text" style="width: 100%;">ยืนยันรหัสผ่าน</span>
                                                    </div>
                                                    <input type="password" name="password_confirmation" id="edit_password_confirmation" class="form-control" required>
                                                </div>                            
                                                <span id='message_edit'></span>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
                                        <button type="submit" class="btn btn-success" id="edit-btn" disabled>ยืนยัน</button>
                                    </div>
                                </form>
                                <!-- Form -->
                            </div>
                        </div>
                    </div>

                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal add -->
<div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- Form -->
            <form action="/admin/addUser" method="post" enctype="multipart/form-data" >
            {{ csrf_field() }}
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white" id="exampleModalLabel">เพิ่มผู้ใช้</h5>
                    <br>
                    <button type="button" class="close text-white " data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend" style="width: 40%;">
                                    <span class="input-group-text" style="width: 100%;">ชื่อ</span>
                                </div>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <div class="input-group mb-2">
                                <div class="input-group-prepend" style="width: 40%;">
                                    <span class="input-group-text" style="width: 100%;">อีเมล</span>
                                </div>
                                <input type="text" name="email" class="form-control" required>
                            </div>

                            <div class="input-group mb-2">
                                <div class="input-group-prepend" style="width: 40%;">
                                    <span class="input-group-text" style="width: 100%;">agent</span>
                                </div>
                                <select name="web_agent" class="form-control">
                                    <option value="">เลือก agent</option>
                                    @foreach ($agents as $agent)
                                        <option value="{{$agent->agent_id}}">{{$agent->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-group mb-2">
                                <div class="input-group-prepend" style="width: 40%;">
                                    <span class="input-group-text" style="width: 100%;">รหัสผ่าน</span>
                                </div>
                                <div class="input-group" id="show_hide_password" style="width: 60%;">
                                    <input type="password" name="password" id="password" class="form-control" style="border-radius: 5px;" required>
                                    <div class="input-group-addon" style="display: flex;">
                                        <a style="margin: auto;"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="input-group mb-2">
                                <div class="input-group-prepend" style="width: 40%;">
                                    <span class="input-group-text" style="width: 100%;">ยืนยันรหัสผ่าน</span>
                                </div>                                
                                <div class="input-group" id="show_hide_password2" style="width: 60%;">
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" style="border-radius: 5px;" required>
                                    <div class="input-group-addon" style="display: flex;">
                                        <a style="margin: auto;"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>                            
                            <span id='message'></span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-success" id="submit-btn" disabled>ยืนยัน</button>
                </div>
            </form>
            <!-- Form -->
        </div>
    </div>
</div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        @media only screen and (max-width: 600px) {
            .mobile-hide {
                display: none;
            }
        }
    </style>
@stop

@section('js')
<script>
$('#password, #password_confirmation').on('keyup', function () {
    if ($('#password').val() != '') {
        if ($('#password').val() === $('#password_confirmation').val()) {     
            $("#submit-btn").prop('disabled', false);
            $('#message').html('Password Matched').css('color', 'green');
        } else {
            $('#message').html('Password Not Matched').css('color', 'red');
            $("#submit-btn").prop('disabled', true);
        }
    }
});

$('#edit_password, #edit_password_confirmation').on('keyup', function () {
    if ($('#edit_password').val() != '') {
        if ($('#edit_password').val() === $('#edit_password_confirmation').val()) {
            $('#message_edit').html('Password Matched').css('color', 'green');        
            $("#edit-btn").prop('disabled', false);
        } else {
            $('#message_edit').html('Password Not Matched').css('color', 'red');
            $("#edit-btn").prop('disabled', true);
        }
    }
});

$(document).ready(function() {
    $("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass( "fa-eye-slash" );
            $('#show_hide_password i').removeClass( "fa-eye" );
        }else if($('#show_hide_password input').attr("type") == "password"){
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass( "fa-eye-slash" );
            $('#show_hide_password i').addClass( "fa-eye" );
        }
    });
});

$(document).ready(function() {
    $("#show_hide_password2 a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password2 input').attr("type") == "text"){
            $('#show_hide_password2 input').attr('type', 'password');
            $('#show_hide_password2 i').addClass( "fa-eye-slash" );
            $('#show_hide_password2 i').removeClass( "fa-eye" );
        }else if($('#show_hide_password2 input').attr("type") == "password"){
            $('#show_hide_password2 input').attr('type', 'text');
            $('#show_hide_password2 i').removeClass( "fa-eye-slash" );
            $('#show_hide_password2 i').addClass( "fa-eye" );
        }
    });
});
</script>
@stop