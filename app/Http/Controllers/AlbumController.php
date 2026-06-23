<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Http\Requests\CrearAlbumRequest;
use App\Http\Requests\ActualizarAlbumRequest;
use Illuminate\Support\Facades\Auth;

class AlbumController extends Controller
{
    // Muestra la lista de todos los álbumes del usuario
    public function getIndex()
    {
        $usuario_id = auth()->id() ?? 1; // Respaldo a ID 1 para pruebas
        $albumes = Album::where('usuario_id', $usuario_id)->get();

        return view('album.mostrar', compact('albumes'));
    }

    // Muestra la vista con el formulario para crear el álbum
    public function getCrear()
    {
        return view('album.crear');
    }

    // Procesa la creación de un nuevo álbum
    public function postCrear(CrearAlbumRequest $request)
    {
        $usuario = Auth::user(); // Obtenemos el usuario autenticado

        $album = new Album;
        $album->album_nombre = $request->get('nombre');
        $album->album_descripcion = $request->get('descripcion');
        $album->usuario_id = $usuario ? $usuario->id : 1; // Usamos 1 de respaldo si no estás logueado en la prueba
        $album->save();

        return redirect('/album')->with('correcto', 'El álbum ha sido creado');
    }

    // Elimina un álbum y todas sus fotos asociadas físicamente y en la base de datos
    public function getEliminar(Request $request)
    {
        $album_id = $request->get('album_id');
        $album = Album::find($album_id);

        if ($album) {
            // Buscamos todas las fotos asociadas para borrarlas del disco del servidor
            foreach ($album->fotos as $foto) {
                $rutaFisica = getcwd() . $foto->foto_ruta;
                if (file_exists($rutaFisica)) {
                    unlink($rutaFisica); // Borra el archivo físico
                }
                $foto->delete(); // Borra el registro en DB
            }
            
            // Finalmente borramos el álbum
            $album->delete();

            return redirect('/album')->with('correcto', 'El álbum y sus fotos asociadas han sido eliminados.');
        }

        return redirect('/album')->with('error', 'El álbum no existe.');
    }

    // Muestra el formulario de edición con los datos cargados del álbum
    public function getActualizar(Request $request)
    {
        $album_id = $request->get('album_id');
        $album = Album::find($album_id);

        if (!$album) {
            return redirect('/album')->with('error', 'El álbum no existe.');
        }

        return view('album.actualizar', compact('album'));
    }

    // Guarda los cambios del álbum
    public function postActualizar(ActualizarAlbumRequest $request)
    {
        $album_id = $request->get('album_id');
        $album = Album::find($album_id);

        if ($album) {
            // El ActualizarAlbumRequest ya se encargó de validar nombre y descripcion
            $album->album_nombre = $request->get('nombre');
            $album->album_descripcion = $request->get('descripcion');
            $album->save();

            return redirect('/album')->with('correcto', 'El álbum ha sido actualizado correctamente.');
        }

        return redirect('/album')->with('error', 'El álbum no existe.');
    }    
}