@extends('admin.base')

@section('main')

    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Add Form</h2>

                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">

                        <table class="table table-bordered">
                            <thead>
                            <tr>

                                <th>Name</th>
                                <th>Parent</th>
                                <th>Action</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(\App\Category::all() as $item)
                            <tr>

                                <td>{{ $item->name }}</td>
                                <td>{{ $item->parent_id != null ? \App\Category::findOrFail($item->parent_id)->name : '' }}</td>
                                <td><a href="{{ url('admin/category/delete/' . $item->id) }}">Delete</a></td>
                                <td><a href="{{ url('admin/category/edit/' . $item->id) }}">Edit</a></td>
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