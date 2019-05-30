@extends('layouts.user-dashboard')

@section('pageTitle', 'BLOGS')
@section('content')

    <div class="dashboard-content">
        <div class="page-title shadow">
            <p>
                <span onclick="openNav()" class="fa fa-navicon mobile_show"></span>
                Blogs
            </p>
        </div>
        <div class="page-content">
            <div class="rows">
                <table class="table table-bordered" style="color: white">
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
                                <td><a href="{{ route('user.blog_detail', ['id' => $row->id]) }}" class="btn btn-primary">View Details</a> </td>
                            </tr>
                            <?php $i++;?>
                        @endforeach
                    @endif
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@stop
