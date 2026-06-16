@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Editar Foto</div>
                <div class="card-body">
                    <form method="POST" action="/foto/actualizar?foto_id={{ $foto->foto_id }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-group row">
                            <label for="nombre" class="col-md-4 col-form-label text-md-right">Nombre</label>

                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre', $foto->foto_nombre) }}" required>
                                
                                @error('nombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="descripcion" class="col-md-4 col-form-label text-md-right">Descripción</label>

                            <div class="col-md-6">
                                <input id="descripcion" type="text" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" value="{{ old('descripcion', $foto->foto_descripcion) }}" required>
                                
                                @error('descripcion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Muestra la imagen actual de la foto -->
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Imagen Actual</label>
                            <div class="col-md-6">
                                <img src="{{ $foto->foto_ruta }}" alt="{{ $foto->foto_nombre }}" class="img-thumbnail mb-2" style="max-height: 150px;">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="imagen" class="col-md-4 col-form-label text-md-right">Cambiar Imagen (Opcional)</label>

                            <div class="col-md-6">
                                <input id="imagen" type="file" class="form-control-file @error('imagen') is-invalid @enderror" name="imagen">
                                <small class="form-text text-muted">Deja este campo vacío si no quieres cambiar la imagen actual.</small>
                                
                                @error('imagen')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Guardar Cambios
                                </button>
                                <a href="/album/fotos?album_id={{ $foto->album_id }}" class="btn btn-secondary ml-2">
                                    Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection