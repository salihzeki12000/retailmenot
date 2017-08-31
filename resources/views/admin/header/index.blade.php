@extends('admin.base')

@section('main')

    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Header Coupon List</h2>

                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">

                        <table class="table table-bordered">
                            <thead>
                            <tr>

                                <th>Coupon Id</th>
                                <th>Action</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(\App\Header::all() as $item)
                                <tr>

                                    <td>{{ $item->coupon_id }}</td>
                                    <td><a href="{{ url('admin/header/delete/' . $item->id) }}">Delete</a></td>
                                    <td><a href="{{ url('admin/header/edit/' . $item->id) }}">Edit</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection