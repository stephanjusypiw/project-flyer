@extends('layout')

@section('content')
    <h1>{!! $flyer->street !!}</h1>
    <h2>{!! $flyer->price !!}</h2>
    <hr>

    <div class="description">
        <p>{!! nl2br($flyer->description) !!}</p>
    </div>

    <form method="foobar" action="POST" class="dropzone">
        {{ csrf_field() }}
    </form>

@stop

@section('scripts.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/dropzone.js"></script>
    <!-- Dropzone Js configurations for the plugin above !-->
    {{--<script>--}}
        {{--Dropzone.options.addPhotosForm = {--}}
            {{--paramName: 'photo',--}}
            {{--maxFilesize: 3,--}}
            {{--acceptedFiles: '.jpg, .jpeg, .png, bmp'--}}
        {{--}--}}
    {{--</script>--}}
@stop
