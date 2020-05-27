@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="col-12">จัดการเกมกล่องสุ่ม
            <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#addItem" style="float: right;"> <i class="fas fa-plus-circle"></i> เพิ่มกล่องสุ่ม </button>
            </h3>
        </div>
        <div class="card-body">
            <div class="container">
                <div class="row">

                    @php 
                        $i = 1; 
                    @endphp
                    @foreach ($box_item as $item)
                    <div class="col">
                        <div class="card">
                            <div class="card-header bg-primary">
                            <h5 class="text-center">{{$item->item_name}}</h5>
                            </div>
                            <div class="car-content">
                                <div class="row">
                                    <div class="col">
                                        <img src="/{{$item->item_image}}" width="75px" height="75px" alt="">
                                    </div>
                                    <div class="col text-center">
                                        เรท {{$item->item_rate}} % <br>
                                    </div>
                                    <div class="col text-center">
                                        action {{$item->action}}<br>
                                    </div>
                                    <div class="col text-center">
                                        ค่าของ action {{$item->attribute}} <br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col text-center">
                                        <button class="btn btn-danger" >ลบ</button> 
                                        <button data-toggle="modal" data-target="#editItem{{$item->item_id}}" class="btn btn-warning">แก้ไข</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <!-- Modal Edit -->
                    <div class="modal fade" id="editItem{{$item->item_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <!-- Form -->
                                    <form action="/admin/editItem_inLuckybox" method="post" enctype="multipart/form-data" >
                                    {{ csrf_field() }}
                                        <div class="modal-header bg-warning">
                                            <h5 class="modal-title " id="exampleModalLabel">แก้ไขสินค้า</h5>
                                            <br>
                                            <button type="button" class="close text-white " data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-4">
                                                    <img id="showimage" style="min-height:245px;" src="/{{$item->item_image}}" width="100%" alt="">
                                                    <div class="custom-file">
                                                        <input type="hidden" name="itemid" value="{{$item->item_id}}">
                                                        <input type="file" onchange="Changeimage(this)" id="file_upload" name="file_upload" class="form-control" accept="image/*" >
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" style="width:170px;" id="name-item">ชื่อของรางวัล</span>
                                                        </div>
                                                        <input type="text" name="name" class="form-control" value="{{$item->item_name}}" required>
                                                    </div>
                                                    <br>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" style="width:170px;" id="name-item">เรทในการได้รับรางวัล</span>
                                                        </div>
                                                        <input type="text" name="rate" class="form-control" value="{{$item->item_rate}}" required>
                                                    </div>
                                                    <br>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" style="width:170px;" id="name-item">action</span>
                                                        </div>
                                                        {{-- <input type="text" name="action" class="form-control" value="{{$item->action}}" required> --}}
                                                        <select class="form-control" name="action" id="action" value="{{$item->action}}">
                                                            <option value="" selected>เลือกแอ็คชั่น</option>
                                                            <option value="point_up">เพิ่มพอยท์</option>
                                                            <option value="point_down">ลดพอยท์</option>
                                                            <option value="box_up">เพิ่มจำนวนกล่อง</option>
                                                        </select>
                                                    </div>
                                                    <br>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" style="width:170px;" id="name-item">ค่าของ action</span>
                                                        </div>
                                                        <input type="text" name="attribute" class="form-control" value="{{$item->attribute}}" required>
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

                </div>
            </div>
        </div>
    </div>


    <!-- Modal Add -->
<div class="modal fade" id="addItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- Form -->
            <form action="/admin/addItem_inLuckybox" method="post" enctype="multipart/form-data" >
            {{ csrf_field() }}

                <div class="modal-header bg-success">
                    <h5 class="modal-title " id="exampleModalLabel">เพิ่มสินค้า</h5>
                    <br>
                    <button type="button" class="close text-white " data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <img id="showimage" style="min-height:245px;" src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQAQoxIldaxi3OexskQxqy-MnLIjs22rNA1xPdZwANRqZWJD8if&usqp=CAU" width="100%" alt="">
                            <div class="custom-file">
                                <input type="file" onchange="Changeimage(this)" id="file_upload" name="file_upload" class="form-control" accept="image/*" required/>
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="width:170px;" id="name-item">ชื่อของรางวัล</span>
                                </div>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <br>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="width:170px;" id="name-item">เรทในการได้รับรางวัล</span>
                                </div>
                                <input type="text" name="rate" class="form-control" required>
                            </div>
                            <br>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="width:170px;" id="name-item">action</span>
                                </div>
                                {{-- <input type="text" name="action" class="form-control" required> --}}
                                <select class="form-control" name="action" id="action">
                                    <option value="" selected>เลือกแอ็คชั่น</option>
                                    <option value="point_up">เพิ่มพอยท์</option>
                                    <option value="point_down">ลดพอยท์</option>
                                    <option value="box_up">เพิ่มจำนวนกล่อง</option>
                                </select>
                            </div>
                            <br>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="width:170px;" id="name-item">ค่าของ action</span>
                                </div>
                                <input type="text" name="attribute" class="form-control" required>
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
    
    function Changeimage(input){
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#showimage').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
    }

    </script>
@stop