@extends('layouts.main')
@section('pageTitle', 'Bolgs')
@section('content')
    @include('partials.status-panel')

    <div class="about-section">
        <div class="container">
            <p class="caption text-center">BOLGS</p>
            <div class="rows">
                <table class="table table-bordered" style="color: black;margin-bottom: 80px;">
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
                                <td><a href="{{ route('public.blog', ['id' => $row->id]) }}" class="btn btn-primary">View Details</a> </td>
                            </tr>
                            <?php $i++;?>
                        @endforeach
                    @endif
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    {{--<div class="red-rectangle"></div>--}}
@stop
