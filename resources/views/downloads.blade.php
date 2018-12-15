@extends('layouts.app')

@section("title")
    Form Downloads | @parent
@endsection

@section('page-header')
    <section class="content-header">
        <h1>Downloads</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{route('home')}}"><i class="fa fa-fw fa-home"></i> Home</a>
            </li>
            <li>
                Downloads
            </li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="panel panel-primary">
        <div id="form-downloads" class="panel-body">
            @php $type = '' @endphp
            @if($downloads)
                @foreach($downloads as $download)
                    @if(is_array($download->attributes->field_file_download_availability) && in_array('agent_portal', $download->attributes->field_file_download_availability))
                        @if ($type != $download->attributes->field_file_download_type)
                            <div class="download-heading">
                                <h3>{{ ucfirst($download->attributes->field_file_download_type) }}</h3>
                            </div>
                            @php $type = $download->attributes->field_file_download_type @endphp
                        @endif
                        <div class="row">
                            <div class="col-md-8 col-sm-8">
                                <a href="{{ getImage($download) }}" target="_blank" class="btn btn-labeled btn-primary ft14 fw4 text-transform-none">
                                    <span class="btn-label ft14 fw4">
                                        @svg('ti-download', 'w12px h12px f-white')
                                     </span> 
                                    <span>{{ $download->attributes->title }}</span>
                                </a>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
@endsection