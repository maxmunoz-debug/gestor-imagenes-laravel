<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Foto;
use App\Http\Requests\CrearFotoRequest;
use App\Http\Requests\ActualizarFotoRequest;
use Carbon\Carbon;

class FotoController extends Controller
{
    // Muestra la lista de fotos de un álbum específico
    public function index(Request $request)
    {
        $album_id = $request->get('album_id');
        $album = Album::find($album_id);

        if (!$album) {
            return redirect('/album')->with('error', 'El álbum no existe');
        }

        $fotos = $album->fotos; // Obtenemos las fotos del álbum usando la relación
        return view('album.fotos', ['fotos' => $fotos, 'album' => $album]);
    }

    // Muestra el formulario para subir una foto, recibiendo el id del álbum al que pertenecerá
    public function getCrear(Request $request)
    {
        $album_id = $request->get('album_id');
        return view('foto.crear', ['album_id' => $album_id]);
    }

    // Procesa el formulario, encripta el nombre del archivo, lo guarda y registra en base de datos
    public function postCrear(CrearFotoRequest $request)
    {
        $album_id = $request->get('album_id');
        $imagen = $request->file('imagen');
        $ruta = '/img/';
        
        // Ciframos el nombre usando sha1 y la fecha/hora actual (Carbon)
        $nombre = sha1(Carbon::now()) . "." . $imagen->guessExtension();
        
        // Copiamos el archivo al servidor en la carpeta public/img
        $imagen->move(getcwd() . $ruta, $nombre);

        // Guardamos el registro en la base de datos
        $foto = new Foto;
        $foto->foto_nombre = $request->get('nombre');
        $foto->foto_descripcion = $request->get('descripcion');
        $foto->foto_ruta = $ruta . $nombre;
        $foto->album_id = $album_id;
        $foto->save();

        // Redirige al listado de fotos con un mensaje de éxito
        return redirect("/album/fotos?album_id=$album_id")->with('correcto', 'La foto ha sido creada');
    }

    // Elimina una foto en particular de la base de datos y del servidor
    public function getEliminar(Request $request)
    {
        $foto_id = $request->get('foto_id');
        $foto = Foto::find($foto_id);

        if ($foto) {
            $album_id = $foto->album_id;
            
            // Borramos el archivo físico del servidor
            $rutaFisica = getcwd() . $foto->foto_ruta;
            if (file_exists($rutaFisica)) {
                unlink($rutaFisica);
            }

            // Borramos el registro de la base de datos
            $foto->delete();

            return redirect("/album/fotos?album_id=$album_id")->with('correcto', 'La foto ha sido eliminada correctamente.');
        }

        return redirect('/album')->with('error', 'La foto no existe.');
    }

    // Muestra el formulario para editar una foto
    public function getActualizar(Request $request)
    {
        $foto_id = $request->get('foto_id');
        $foto = Foto::find($foto_id);

        if (!$foto) {
            return redirect('/album')->with('error', 'La foto no existe.');
        }

        return view('foto.actualizar', compact('foto'));
    }

    // Procesa la actualización de la foto (y opcionalmente la nueva imagen)
    public function postActualizar(ActualizarFotoRequest $request)
    {
        $foto_id = $request->get('foto_id');
        $foto = Foto::find($foto_id);

        if ($foto) {
            // El ActualizarFotoRequest ya validó: nombre requerido, descripción requerida, imagen opcional
            $foto->foto_nombre = $request->get('nombre');
            $foto->foto_descripcion = $request->get('descripcion');

            // Si subió una nueva imagen, eliminamos la anterior y guardamos la nueva
            if ($request->hasFile('imagen')) {
                $rutaFisicaVieja = getcwd() . $foto->foto_ruta;
                if (file_exists($rutaFisicaVieja)) {
                    unlink($rutaFisicaVieja);
                }

                $imagen = $request->file('imagen');
                $ruta = '/img/';
                $nombre = sha1(Carbon::now()) . "." . $imagen->guessExtension();
                $imagen->move(getcwd() . $ruta, $nombre);
                
                $foto->foto_ruta = $ruta . $nombre;
            }

            $foto->save();

            return redirect("/album/fotos?album_id={$foto->album_id}")->with('correcto', 'La foto ha sido actualizada correctamente.');
        }

        return redirect('/album')->with('error', 'La foto no existe.');
    }    
}