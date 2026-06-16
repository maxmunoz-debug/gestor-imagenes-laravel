@extends('layouts.app')

@section('content')
@if (Session::has('correcto'))
    <div class="container mb-3">
        <div class="alert alert-success">
            <strong>Realizado!</strong> Proceso Correcto.<br><br>
            {{ Session::get('correcto') }}
        </div>
    </div>
@endif

<div class="container">
    <p><a href="/album/crear" class="btn btn-primary">Crear Álbum</a></p>
    
    @if(sizeof($albumes) > 0)
        <div class="row">
            @foreach($albumes as $album)
                <div class="col-sm-6 col-md-4 col-12 pt-1 mb-4">
                    <div class="card shadow-sm">
                        <h5 class="card-header">{{ $album->album_nombre }}</h5>
                        <div class="card-body">
                            <p class="card-text">{{ $album->album_descripcion }}</p>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="/album/fotos?album_id={{ $album->album_id }}" class="btn btn-info btn-sm mr-1">Ver Fotos</a>
                                <a href="/album/actualizar?album_id={{ $album->album_id }}" class="btn btn-success btn-sm mr-1">Editar</a>
                                <a href="/album/eliminar?album_id={{ $album->album_id }}" class="btn btn-danger btn-sm">Eliminar</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-muted">Aún no tienes ningún álbum creado.</p>
    @endif
</div>
@endsection