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
			<div class="row no-padding">
				<div class="tab shadow">
					<button class="tablinks firstTab active">Myeloid</button>
					<button class="tablinks secondTab">Lymphoid</button>
					<button class="tablinks thirdTab">Red cell</button>
					<button class="tablinks fourthTab">Miscelaneous</button>
				</div>
				<div class="tablist">
					<div id="myeloid" class="tabcontent tabshow">
						@foreach ($myeloids as $index => $myeloid)
                            <div class="content-row flexDiv icase">
                                <div class="desc-image">
                                    <a href="{{ route('user.getCase', ['case_id' => $myeloid->id, 'sample_type' => $myeloid->slides[0]->sample->nam]) }}"><img src="{{ asset('/assets/images/table.png')}}" alt="Figure Thumbnail"></a>
                                </div>
                                <div class="col-separator hublist"></div>
                                <div class="sample-desc">
                                    <p><strong>{{ $myeloid->description }}</strong></p>

                                    <?php
                                        if(count($myeloid->slides)){
                                        foreach ($myeloid->slides as $slide) {
                                        $slidename = $slide->name;
                                        $sampletype = $slide->sample->name;
                                    ?>
                                    <a href="{{ route('user.getCase', ['case_id' => $myeloid->id, 'sample_type' => $sampletype]) }}" style="margin-right: 13px">{{$sampletype}}</a>
                                    <?php
                                        }
                                    }
                                    ?>

                                </div>
                            </div>
						@endforeach
					</div>
					<div id="lymphoids" class="tabcontent">
						@foreach ($lymphoids as $index => $myeloid)
							<div class="content-row flexDiv icase">
								<div class="desc-image">
									{{--<a href="/user/case/get/{{$myeloid->id}}/{{$myeloid->slides[0]->sample->name}}"><img src="/assets/images/table.png" alt="Figure Thumbnail"></a>--}}
									<a href="{{ route('user.getCase', ['case_id' => $myeloid->id, 'sample_type' => $myeloid->slides[0]->sample->name]) }}"><img src="{{ asset('/assets/images/table.png')}}" alt="Figure Thumbnail"></a>

								</div>
								<div class="col-separator hublist""></div>
								<div class="sample-desc">
									<p><strong>{{ $myeloid->description }}</strong></p>

                                    <?php
                                    if(count($myeloid->slides)){
                                    foreach ($myeloid->slides as $slide) {
                                    $slidename = $slide->name;
                                    $sampletype = $slide->sample->name;
                                    ?>
									<a href="{{ route('user.getCase', ['case_id' => $myeloid->id, 'sample_type' => $sampletype]) }}" style="margin-right: 13px">{{$sampletype}}</a>
                                    <?php
                                    }
                                    }
                                    ?>

								</div>
							</div>
						@endforeach
					</div>
					<div id="redcell" class="tabcontent">
						@foreach ($redcells as $index => $myeloid)
							<div class="content-row flexDiv icase">
								<div class="desc-image">
									{{--<a href="/user/case/get/{{$myeloid->id}}/{{$myeloid->slides[0]->sample->name}}"><img src="/assets/images/table.png" alt="Figure Thumbnail"></a>--}}
									<a href="{{ route('user.getCase', ['case_id' => $myeloid->id, 'sample_type' => $myeloid->slides[0]->sample->name]) }}"><img src="{{ asset('/assets/images/table.png')}}" alt="Figure Thumbnail"></a>

								</div>
								<div class="col-separator hublist"></div>
								<div class="sample-desc">
									<p><strong>{{ $myeloid->description }}</strong></p>

                                    <?php
                                    if(count($myeloid->slides)){
                                    foreach ($myeloid->slides as $slide) {
                                    $slidename = $slide->name;
                                    $sampletype = $slide->sample->name;
                                    ?>
									<a href="{{ route('user.getCase', ['case_id' => $myeloid->id, 'sample_type' => $sampletype]) }}" style="margin-right: 13px">{{$sampletype}}</a>
                                    <?php
                                    }
                                    }
                                    ?>

								</div>
							</div>
						@endforeach
					</div>
					<div id="miscelaneous" class="tabcontent">
						@foreach ($others as $index => $myeloid)
							<div class="content-row flexDiv icase">
								<div class="desc-image">
									<a href="{{ route('user.getCase', ['case_id' => $myeloid->id, 'sample_type' => $myeloid->slides[0]->sample->name]) }}"><img src="{{ asset('/assets/images/table.png')}}" alt="Figure Thumbnail"></a>
								</div>
								<div class="col-separator hublist"></div>
								<div class="sample-desc">
									<p><strong>{{ $myeloid->description }}</strong></p>

                                    <?php
                                    if(count($myeloid->slides)){
                                    foreach ($myeloid->slides as $slide) {
                                    $slidename = $slide->name;
                                    $sampletype = $slide->sample->name;
                                    ?>
									<a href="{{ route('user.getCase', ['case_id' => $myeloid->id, 'sample_type' => $sampletype])}}" style="margin-right: 13px">{{$sampletype}}</a>
                                    <?php
                                    }
                                    }
                                    ?>

								</div>
							</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
@stop
