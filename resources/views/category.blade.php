@extends('adminlte::page')

@section('title', 'จัดการหมวดหมู่ของรางวัล')

@section('content')
<div class="card">
    <div class="card-header border-success row" style="margin: 0px;">
        <h3 class="col-12">
            จัดการของรางวัล        
            <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#addCategory" style="float: right;"> <i class="fas fa-plus-circle"></i> เพิ่มของรางวัล </button>
        </h3>
    </div>
    
    <div class="card-body text-center">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>ชื่อหมวดหมู่</th>
                    <th>แก้ไข</th>
                    <th>ลบ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categorys as $category)
                    <tr>
                        <td>{{ $category->cat_id }}</td>
                        <td>{{ $category->cat_name }}</td>
                        <td> <a class="btn btn-warning" data-toggle="modal" data-target="#editCategory{{ $category->cat_id }}">แก้ไข</a> </td>
                        <td> <a href="/admin/deleteCategory?cat_id={{$category->cat_id}}" onclick= "return confirm('ยืนยันการลบ?');" class="btn btn-danger">ลบ</a> </td>
                    </tr>

                      <!-- Modal Edit -->
                      <div class="modal fade" id="editCategory{{ $category->cat_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <!-- Form -->
                                <form action="/admin/editCategory" method="post" enctype="multipart/form-data" >
                                {{ csrf_field() }}

                                    <input type="hidden" name="cat_id" value="{{$category->cat_id}}">

                                    <div class="modal-header bg-warning">
                                        <h5 class="modal-title text-white" id="exampleModalLabel">แก้ไขหมวดหมู่</h5>
                                        <br>
                                        <button type="button" class="close text-white " data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" style="width:170px;" id="name-category">ชื่อหมวดหมู่</span>
                                                    </div>
                                                    <input type="text" name="cat_name" class="form-control" value="{{$category->cat_name}}">
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

                @endforeach
            </tbody>
        </table>
    </div>
</div>


<!-- Modal Edit -->
<div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- Form -->
            <form action="/admin/addCategory" method="post" enctype="multipart/form-data" >
            {{ csrf_field() }}
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white" id="exampleModalLabel">เพิ่มหมวดหมู่</h5>
                    <br>
                    <button type="button" class="close text-white " data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="width:170px;" id="name-category">ชื่อหมวดหมู่</span>
                                </div>
                                <input type="text" name="cat_name" class="form-control" required>
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
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>

    </script>
@stop