@extends('admin.base')

@section('main')

    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>List Coupon</h2>

                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">

                        <table class="table table-bordered">
                            <thead>
                            <tr>

                                <th>Id</th>
                                <th>Link</th>
                                <th>Store</th>
                                <th>Type</th>

                                <th>Code</th>
                                <th>Description</th>
                                <th>Expiration Date</th>
                                <th>Action</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach(\App\Coupon::all() as $item)
                                <tr>

                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->link }}</td>

                                    <td>{{ \App\Store::findOrFail($item->store_id )->name }}</td>
                                    <td>{{ $item->type }}</td>

                                    <td>{{ $item->code }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td>{{ $item->exp_date }}</td>
                                    <td><a href="{{ url('admin/coupon/delete/' . $item->id) }}">Delete</a></td>

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