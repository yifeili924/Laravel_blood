@extends('layouts.admin')

@section('head')

@stop

@section('content')
    <h3 style="float: left">Blog lists</h3>
    <a href="{{ route('admin.add_bolg') }}" style="text-decoration: none;float: right;margin-top: 15px;margin-right: 30px" class="btn btn-primary">Add Blog</a>
    <div class="rows">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>No.</th>
                <th>Title</th>
                <th>Created</th>
                <th>Details</th>
            </tr>
            </thead>
            <tbody>
            @if(count($blogs))
                <?php $i = 1; ?>
                @foreach($blogs as $row)

                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$row->title}} </td>
                        <td>{{date('d/m/Y', strtotime($row->created_at))}}</td>
                        <td><a href="{{ route('admin.blog_detail', ['id' => $row->id]) }}" class="btn btn-primary">View Details</a>   <a href="{{ route('admin.edit_blog', ['id' => $row->id]) }}" class="btn btn-success">Edit</a>   <a href="{{ route('admin.blog_delete', ['id' => $row->id]) }}" class="btn btn-danger">Delete</a>  </td>
                    </tr>
                    <?php $i++;?>
                @endforeach
            @endif
            </tbody>
        </table>

    </div>

@stop