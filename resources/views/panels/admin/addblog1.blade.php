@extends('layouts.admin_text')

@section('head')

@stop

@section('content')
    <h3 style="float: left">Blog lists</h3>
    <a href="{{ route('admin.add_bolg') }}" style="text-decoration: none;float: right;margin-top: 15px;margin-right: 30px" class="btn btn-primary">Add Blog</a>
    <div class="container" style="clear: both;">
           @if(count($blogs))
                @foreach($blogs as $row)
                    <div> <?php echo($row->contents)?></div>
                @endforeach
            @endif

    </div>

@stop