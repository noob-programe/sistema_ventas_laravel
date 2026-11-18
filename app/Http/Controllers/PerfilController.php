<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class PerfilController extends Controller
{
    public function index(){
        $idUsuario =Auth::user()->id_usuario;
        $datos=DB::select("SELECT * FROM usuario where id_usuario = $idUsuario");
        return view("vistas.perfil", compact("datos"));
    }

    public function actualizarIMG(Request $request){

        $request->validate([
            "foto"=>"required | image |mimes:png,jpg,jpeg"
            ]);

        $file = $request->file("foto");
        //Nombre debe contener el id del usuario de registro
        $idUsuario = Auth::user()->id_usuario;
                                                        //getClienteExtension()
        $nombreArchivo = $idUsuario.".".strtolower($file->getClientOriginalName());
        //Almacenamiento de las imagenes en carpeta privada. storage.app.public
        $ruta=storage_path( "app/public/fotos-perfil-usuario/".$nombreArchivo);
        $verficiarFoto = DB::select("select foto from usuario where id_usuario = $idUsuario");
        $verficiarFoto = $verficiarFoto[0]->foto;

        if($verficiarFoto != null){
            $rutaFotoAnterior = storage_path("app/public/fotos-perfil-usuario/$verficiarFoto");
            
            try {
                unlink($rutaFotoAnterior);
            } catch (\Throwable $th) {
            }

        }


        $res=move_uploaded_file($file, $ruta);

        try {
            $actualizarFoto= DB::update("update usuario set foto='$nombreArchivo' where id_usuario=$idUsuario");
            if ($actualizarFoto ==0){
                $actualizarFoto=1;
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
            $actualizarFoto=0;
        }
            
        if ($res and $actualizarFoto) {
            return back()->with("mensaje", "imagen actualizada correctamente");
        } else {
            return back()->with("error", "error al actualizar la imagen");
        }

         
    }

    public function eliminarFotoPerfil(){
     $idUsuario= Auth::user()->id_usuario;
     $nombreFoto = Auth::user()->foto;
     $ruta = storage_path("app/public/fotos-perfil-usuario/$nombreFoto");

     try {
        $res= unlink($ruta);
        $actualizarFotoBD= DB::update("update usuario set foto = null where id_usuario = $idUsuario ");
     } catch (\Throwable $th) {
        $res = false;
        $actualizarFotoBD = false;
     }


     if ($res and $actualizarFotoBD) {
        return back()->with("mensaje", "Imagen eliminada correctamente");
     } else {
        return back()->with("error", "error al eliminar la imagen");
     }
     


    }
}
