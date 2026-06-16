@extends('layouts.app')

@section('content')
<!-- Alerta de éxito si se creó la foto -->
@if (Session::has('correcto'))
    <div class="container mb-3">
        <div class="alert alert-success">
            <strong>Realizado!</strong> Proceso Correcto.<br><br>
            {{ Session::get('correcto') }}
        </div>
    </div>
@endif

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Fotos del Álbum: {{ $album->album_nombre }}</h2>
        <div>
            <a href="/album" class="btn btn-secondary mr-2">Volver a Álbumes</a>
            <a href="/foto/crear?album_id={{ $album->album_id }}" class="btn btn-primary">Crear Foto</a>
        </div>
    </div>

    @if(sizeof($fotos) > 0)
        <div class="row">
            @foreach($fotos as $foto)
                <div class="col-sm-6 col-md-4 col-12 pt-1 mb-4">
                    <div class="card shadow-sm h-100">
                        <h5 class="card-header">{{ $foto->foto_nombre }}</h5>
                        <!-- Cargamos la imagen desde la ruta almacenada -->
                        <img src="{{ $foto->foto_ruta }}" class="card-img-top" alt="{{ $foto->foto_nombre }}" style="height: 250px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <p class="card-text text-muted flex-grow-1">{{ $foto->foto_descripcion }}</p>
                            <div class="d-flex gap-2 mt-3">
                                <a href="/foto/actualizar?foto_id={{ $foto->foto_id }}" class="btn btn-success btn-sm mr-1">Editar</a>
                                <a href="/foto/eliminar?foto_id={{ $foto->foto_id }}" class="btn btn-danger btn-sm">Eliminar</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info text-center">
            Este álbum aún no tiene fotos cargadas. ¡Haz clic en <strong>Crear Foto</strong> para subir la primera!
        </div>
    @endif
</div>
@endsection