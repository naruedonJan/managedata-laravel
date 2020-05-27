@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')

<div class="card">
    <div class="card-header border-success row" style="margin: 0px;">
        <h3 class="col-12">
            จัดการของรางวัล        
            <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#exampleModal" style="float: right;"> <i class="fas fa-plus-circle"></i> เพิ่มของรางวัล </button>
        </h3>
    </div>
    
    <div class="card-body text-center">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th class="mobile-hide">#</th>
                    <th>รูป</th>
                    <th>ชื่อ</th>
                    <th class="mobile-hide">คำอธิบาย</th>
                    <th class="mobile-hide">แต้มที่ใช้แลก</th>
                    <th class="mobile-hide">หมวดหมู่</th>
                    <th>แก้ไข</th>
                    <th>ลบ</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 0;
                @endphp               
                @foreach ($reward as $item)
                @php
                $i ++;
                @endphp 
                <tr>
                    <td class="mobile-hide"> {{$i}} </td>
                    <td> <img src="/{{$item->url_image}}" width="75px" height="75px" alt=""> </td>
                    <td> {{$item->name_item}} </td>
                    <td class="mobile-hide"> {{$item->description}} </td>
                    <td class="mobile-hide"> {{$item->point}} </td>
                    <td class="mobile-hide"> {{$item->cat_name}} </td>
                    <td> <a class="btn btn-warning" data-toggle="modal" data-target="#editReward{{ $item->reward_id }}">แก้ไข</a> </td>
                    <td> <a href="/admin/deleteReward?reward_id={{$item->reward_id}}" onclick= "return confirm('ยืนยันการลบ?');" class="btn btn-danger">ลบ</a> </td>
                </tr>     
                
                    <!-- Modal Edit -->
                    <div class="modal fade" id="editReward{{ $item->reward_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <!-- Form -->
                                <form action="/admin/editReward" method="post" enctype="multipart/form-data" >
                                {{ csrf_field() }}

                                    <div class="modal-header bg-warning">
                                        <h5 class="modal-title text-white" id="exampleModalLabel">แก้ไขสินค้า</h5>
                                        <br>
                                        <button type="button" class="close text-white " data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-4">
                                                <img id="showimage{{ $item->reward_id }}" style="min-height:245px;" src="/{{$item->url_image}}" width="100%" alt="">
                                                <div class="custom-file">
                                                    <input type="hidden" name="reward_id" value="{{$item->reward_id}}">
                                                    <input type="hidden" name="old_url_image" value="{{$item->url_image}}">
                                                    <input type="file" onchange="Changeimage2(this, {{ $item->reward_id }})" id="file_upload" name="url_image" class="form-control" accept="image/*"/>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" style="width:170px;" id="name-item">ชื่อของรางวัล</span>
                                                    </div>
                                                    <input type="text" name="name_item" class="form-control" value="{{$item->name_item}}">
                                                </div>
                                                <br>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" style="width:170px;" id="name-item">จำนวนพอยท์ที่ใช้แลก</span>
                                                    </div>
                                                    <input type="text" name="point" class="form-control" value="{{$item->point}}">
                                                </div>
                                                <br>
                                                <label for="description"> รายละเอียดสินค้า </label><br>
                                                <textarea name="description" id="description" style="width:100%;height: 125px;">{{$item->description}}</textarea>
                                                <br>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" style="width:170px;" id="name-item">หมวดหมู่</span>
                                                    </div>
                                                    <select name="category" class="form-control">
                                                        <option value="{{ $item->cat_id }}">{{ $item->cat_name }}</option>
                                                        @foreach ($categorys as $category)
                                                            @if ($category->cat_id != $item->cat_id)
                                                                <option value="{{ $category->cat_id }}">{{ $category->cat_name }}</option>
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
                    
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<!-- Modal Add -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- Form -->
            <form action="/admin/addReward" method="post" enctype="multipart/form-data" >
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
                                    <span class="input-group-text" style="width:170px;" id="name-item">จำนวนพอยท์ที่ใช้แลก</span>
                                </div>
                                <input type="text" name="point" class="form-control" required>
                            </div>
                            <br>
                            <label for="description"> รายละเอียดสินค้า </label><br>
                            <textarea name="description" id="description" style="width:100%;height: 125px;" required></textarea>
                            <br>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="width:170px;" id="name-item">หมวดหมู่</span>
                                </div>
                                <select name="category" class="form-control" required>
                                    <option value="">เลือกหมวดหมู่</option>
                                    @foreach ($categorys as $category)
                                        <option value="{{ $category->cat_id }}">{{ $category->cat_name }}</option>
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


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        .col.item-prize.text-center {
            flex: 0 0 20%;
        }
        @media only screen and (max-width: 600px) {
            .mobile-hide {
                display: none;
            }
        }
    </style>
    
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

function Changeimage2(input, id){
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#showimage'+id).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

    
</script>
@stop