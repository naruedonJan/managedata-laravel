@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')

<div class="card">
    <div class="card-header border-success row" style="margin: 0px;">
        <h3 class="col-12">
            จัดการagent
            <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#addagent" style="float: right;"> <i class="fas fa-plus-circle"></i> เพิ่มagent </button>
        </h3>
    </div>
    
    <div class="card-body text-center">
        <table class="table">
            <thead class="border-success">
                <tr>
                    <th>#</th>
                    <th>ชื่อ</th>
                    <th>domain</th>
                    <th>ip</th>
                    <th>line</th>
                    <th>รูป</th>
                    <th>สถานะ</th>
                    <th>แก้ไข</th>
                    <th>ลบ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($agents as $agent)
                    <tr>
                        <td>{{ $agent->agent_id }}</td>
                        <td>{{ $agent->name }}</td>
                        <td><a href="{{ $agent->domain }}">{{ $agent->domain }}</a></td>
                        <td>{{ $agent->ip }}</td>
                        <td><a href="https://line.me/ti/p/{{ $agent->line }}">{{ $agent->line }}</a></td>
                        <td><img src="/{{ $agent->image }}" alt=""style="width: 10%;"></td>
                        <td class="text-center"><span class="st-active" style=" background-color:@if($agent->status == 1) #3bb309 @else #e02929 @endif;"></span></td>
                        <td> <a class="btn btn-outline-warning" data-toggle="modal" data-target="#editagent{{ $agent->agent_id }}"><i class="far fa-edit"></i></a> </td>
                        <td> <a href="/admin/deleteAgent?agent_id={{ $agent->agent_id }}" onclick= "return confirm('ยืนยันการลบ?');" class="btn btn-outline-danger"> <i class="far fa-trash-alt"></i> </a> </td>
                    </tr>

                    <!-- Modal edit -->
                    <div class="modal fade" id="editagent{{ $agent->agent_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <form action="/admin/editAgent" method="post" enctype="multipart/form-data" >
                                {{ csrf_field() }}
                                    <div class="modal-header bg-warning">
                                        <h5 class="modal-title text-white" id="exampleModalLabel">แก้ไขagent</h5>
                                        <br>
                                        <button type="button" class="close text-white " data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <input type="hidden" name="agent_id" value="{{ $agent->agent_id }}">
                                    <input type="hidden" name="old_image" value="{{ $agent->image }}">

                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend" style="width: 40%;">
                                                        <span class="input-group-text" style="width: 100%;">ชื่อ</span>
                                                    </div>
                                                    <input type="text" name="name" class="form-control" value="{{ $agent->name }}">
                                                </div>
                    
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend" style="width: 40%;">
                                                        <span class="input-group-text" style="width: 100%;">domain</span>
                                                    </div>
                                                    <input type="text" name="domain" class="form-control" value="{{ $agent->domain }}">
                                                </div>
                                                
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend" style="width: 40%;">
                                                        <span class="input-group-text" style="width: 100%;">ip</span>
                                                    </div>
                                                    <input type="text" name="ip" class="form-control" value="{{ $agent->ip }}">
                                                </div>
                    
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend" style="width: 40%;">
                                                        <span class="input-group-text" style="width: 100%;">line</span>
                                                    </div>
                                                    <input type="text" name="line" class="form-control" value="{{ $agent->line }}">
                                                </div>
                    
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend" style="width: 40%;">
                                                        <span class="input-group-text" style="width: 100%;">image</span>
                                                    </div>
                                                    <input type="file" name="image" class="form-control">
                                                </div>
                    
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend" style="width: 40%;">
                                                        <span class="input-group-text" style="width: 100%;">status</span>
                                                    </div>
                                                    <select name="status" class="form-control">
                                                        <option value="{{ $agent->status }}">
                                                            @if ($agent->status == 1)
                                                                เปิด
                                                            @else
                                                                ปิด
                                                            @endif
                                                        </option>
                                                        @if ($agent->status == 1)
                                                            <option value="0">ปิด</option>
                                                        @else
                                                            <option value="1">เปิด</option>
                                                        @endif
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
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal add -->
<div class="modal fade" id="addagent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- Form -->
            <form action="/admin/addAgent" method="post" enctype="multipart/form-data" >
            {{ csrf_field() }}
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white" id="exampleModalLabel">เพิ่มagent</h5>
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
                                    <span class="input-group-text" style="width: 100%;">domain</span>
                                </div>
                                <input type="text" name="domain" class="form-control" required>
                            </div>
                            
                            <div class="input-group mb-2">
                                <div class="input-group-prepend" style="width: 40%;">
                                    <span class="input-group-text" style="width: 100%;">ip</span>
                                </div>
                                <input type="text" name="ip" class="form-control">
                            </div>

                            <div class="input-group mb-2">
                                <div class="input-group-prepend" style="width: 40%;">
                                    <span class="input-group-text" style="width: 100%;">line</span>
                                </div>
                                <input type="text" name="line" class="form-control">
                            </div>

                            <div class="input-group mb-2">
                                <div class="input-group-prepend" style="width: 40%;">
                                    <span class="input-group-text" style="width: 100%;">image</span>
                                </div>
                                <input type="file" name="image" class="form-control">
                            </div>
                            
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-success" id="submit-btn">ยืนยัน</button>
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
        .st-active {
            width: .8rem;
            height: .8rem;
            display: inline-block;
            border-radius: 9999px;
        }
    </style>
@stop

@section('js')
<script>
    
</script>
@stop