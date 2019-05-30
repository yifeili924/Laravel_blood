@extends('layouts.user-dashboard')

@section('pageTitle', 'VIEW COMMENTS')
@section('content')

    <div class="dashboard-content">
        <div class="page-title shadow">
            <p>
                <span onclick="openNav()" class="fa fa-navicon mobile_show"></span>
                VIEW COMMENTS
            </p>
        </div>
        <div class="page-content">
            <div class="rows">
                <table class="table table-bordered" style="color: white">
                    <thead>
                    <tr>
                        <th style="width:5%">No.</th>
                        <th style="width:55%">Comment</th>
                        <th style="width:20%">Created</th>
                        <th style="width:10%">Status</th>
                        <th style="width:20%">Type</th>

                        <th style="width:10%">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($comments))
                        <?php
                        $i = 1;
                        ?>
                        @foreach($comments as $row)

                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$row['content']}} </td>
                                <td>{{date('d/m/Y h:i:sa', strtotime($row['time']['date']))}}</td>

                                <td>
                                    <?php
                                    if ($row['seen'] == "0") {
                                        $seen = "Unread";
                                    } else {
                                        $seen = "Read";
                                    }
                                    echo $seen;
                                    ?>
                                </td>

                                <?php
                                if ($row['sample_type'] == 'blog') {
                                ?>
                                <td>Blog</td>
                                <td>
                                    <a href="{{ route('user.blog_detail', ['id' => $row['blogid']]) }}"
                                       class="btn btn-primary" style="padding: 5px 5px; font-size: 15px;">Go to
                                        comment</a>
                                </td>
                                <?php
                                } else if ($row['sample_type'] == 'figure') {
                                ?>
                                <td>Summary Tables & Figures</td>
                                <td>
                                    <a href="{{ route('user.figurepage', ['fid' => $row['blogid']]) }}"
                                       class="btn btn-primary" style="padding: 5px 5px; font-size: 15px;">Go to
                                        comment</a>
                                </td>
                                <?php
                                } else if ($row['sample_type'] == 'guidline') {
                                ?>
                                <td>Guideline summaries</td>
                                <td>
                                    <a href="{{ route('user.guidelinesummaries', ['fid' => $row['blogid']])}}"
                                       class="btn btn-primary" style="padding: 5px 5px; font-size: 15px;">Go to
                                        comment</a>
                                </td>
                                <?php
                                } else {
                                ?>
                                <td>Morphology Cases</td>
                                <td>
                                    <a href="{{ route('user.getCase', ['case_id' => $row['blogid'], 'sample_type' => $row['sample_type']]) }}"
                                       class="btn btn-primary" style="padding: 5px 5px; font-size: 15px;">Go to
                                        comment</a>
                                </td>
                                <?php
                                }
                                ?>
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
