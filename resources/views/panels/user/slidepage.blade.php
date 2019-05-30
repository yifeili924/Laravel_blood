@extends('layouts.user-page')
@section('pageTitle', 'Morphology Cases')

@section('content')
@include('partials.status-panel')

    <div class="panel-content">
        <div class="page-title shadow">
            <p>
                <span onclick="openNav()" class="fa fa-navicon"></span>
                Morphology Cases
            </p>
        </div>
        <div class="page-content">
            <div class="subtitle text-center">
                {{$case->description}}
            </div>

            <div class="text-center row no-padding" style="margin-bottom: 30px">
                <div id="toolbardiv" style="position: relative; float: left; width:100%; height: 38px; background: #e7e7e7"></div>
                <div id="openseadragon1" style="width: 100%; height: 600px; float: left; position: relative; background: #e7e7e7"></div>
            </div>

            <a href="{{ route('subscription.hubfigures') }}" class="link-primary">Return</a>
        </div>
    </div>

    <script src="{{ asset('assets/js/openseadragon.min.js') }}"></script>
    <script type="text/javascript">
        $('#openseadragon1').prop('hidden', true);
        $('#toolbardiv').prop('hidden', true);
        <?php
        echo "$('#toolbardiv').prop('hidden', false);";
        echo "$('#openseadragon1').prop('hidden', false);";
        echo "var viewer = OpenSeadragon({id: 'openseadragon1', prefixUrl: 'https://s3.eu-central-1.amazonaws.com/simplezoom123/kidz_files/',";

        $prestring = "'https://s3.eu-west-2.amazonaws.com/bloodacademy/";
        $finalname = substr($sname, 0, strlen($sname) - 4);
        $finalstring  =  $prestring . $finalname .".dzi',";

        echo "tileSources: [". $finalstring ."],";
        echo "toolbar: 'toolbardiv', springStiffness:10, sequenceMode:true,showReferenceStrip:true,autoHideControls:false,referenceStripScroll:'vertical'});";
        ?>
    </script>
@stop
