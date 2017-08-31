@extends('admin.base')

@section('main')

    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>List Store</h2>

                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">

                        <table class="table table-bordered">
                            <thead>
                            <tr>

                                <th>Name</th>
                                <th>Image</th>
                                <th>Department</th>
                                <th>User Email</th>
                                <th>Action</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach(\App\Store::all() as $item)
                                <tr>

                                    <td>{{ $item->name }}</td>
                                    <td><img width="100px" src="{{ url('public/image/' . $item->img) }}"></td>
                                    <td>{{ \App\Category::findOrFail($item->category_id)->name }}</td>
                                    <td>{{ $item->user_id != 0 ? \App\User::findOrFail($item->user_id)->email : 'Admin' }}</td>
                                    <td><a href="{{ url('admin/user/delete/' . $item->id) }}">Delete</a></td>

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