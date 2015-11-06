@extends('layout')

@section('content')

    <div class="row">
        <div class="col-md-3">
            <h1>{!! $flyer->street !!}</h1>
            <h2>{!! $flyer->price !!}</h2>
            <hr>

            <div class="description">
                <p>{!! nl2br($flyer->description) !!}</p>
            </div>
        </div>

        <div class="col-md-9">
            @foreach($flyer->photos as $photo)
                <!-- I had to place a / here so the image is read -->
                <img src="/{{ $photo->path }}" alt="">
            @endforeach
        </div>

    </div>


    <hr>

    <h2>Add Your Photos</h2>

    <form id="addPhotosForm"
          action="{{ route('store_photo_path', [$flyer->zip, $flyer->street]) }}"
          method="POST"
          class="dropzone">
        {{ csrf_field() }}
    </form>

@stop

@section('scripts.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/dropzone.js"></script>
    <!-- Dropzone Js configurations for the plugin above !-->
    <script>
        Dropzone.options.addPhotosForm = {
            paramName: 'photo',
            maxFilesize: 3,   // in MB
            acceptedFiles: '.jpg, .jpeg, .png, .bmp'
        }
    </script>
@stop
