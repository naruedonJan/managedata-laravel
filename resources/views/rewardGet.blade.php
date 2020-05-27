@extends('adminlte::page')

@section('title', 'ประวัติการแลกของรางวัล')

@section('content')
<div class="card text-center">
    <div class="card-header">
        <h2>ประวัติการแลกของรางวัล</h2>
    </div>
    
    <div class="card-body">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th class="mobile-hide">#</th>
                    <th>MM User</th>
                    <th>ของรางวัล</th>
                    <th>แต้มที่ใช้</th>
                    <th class="mobile-hide">สถานะ</th>
                    {{-- <th>วันที่แลก</th> --}}
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                @foreach ($rewards as $reward)
                    <tr>
                        <td class="mobile-hide">{{ $no }}</td>
                        <td>{{ $reward->mm_user }}</td>
                        <td>{{ $reward->name_item }}</td>
                        <td>{{ $reward->point }}</td>
                        <td class="mobile-hide"><span class="st-active" style=" background-color:@if($reward->status == 1) #3bb309 @else #e02929 @endif;"></span></td>
                    </tr>
                    @php
                        $no++;
                    @endphp
                @endforeach
            </tbody>
        </table>
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