@extends('layouts.app') 
@section('titulo', 'Perfil 🤠')
<style>
    .contenedor{

        background: rgb(171, 139, 253);
        padding: 15px;
        display: flex;
        justify-content:space-around;
        gap:20px;
        align-items: center;
    }

    .img{
        width: 250px;
        height: 250px;
        border-radius: 250px;

    }

    @media screen and (max-width: 600px){
        .contenedor{
            flex-direction: row;
            justify-content: center;
            flex-wrap: wrap;
        }
    }
</style>


@section('content')
    @if (session('mensaje'))
        <script>
            $(function notification(){
                new PNotify({
                    title: "CORRECTO",
                    type: "success",
                    text:"{{session('mensaje')}}",
                    styling: "bootstrap3"
                });

            });
        
        </script>
        
    @endif
    @if (session('error'))
        <script>
            $(function notification(){
                new PNotify({
                    title: "INCORRECTO",
                    type: "error",
                    text:"{{session('error')}}",
                    styling: "bootstrap3"
                });

            });
        
        </script>
        
    @endif



    <h4 class= text-center text-secondary>Mi Perfil</h4>

    @foreach ($datos as $item)

        <div class="contenedor" >
        <div>
            @if ($item->foto !=null)

                <img class="img" src="{{asset("storage/fotos-perfil-usuario/$item->foto")}}"  alt="" >
                
            @else
                <img class="img" src="{{asset("images/sin.png")}}" alt="sin foto" >
            @endif
            
        </div>
        <div class="">
            <h6><b>Modificar Imagen </b></h6>
                                                                            {{-- //poder enviar archivos al controlador --}}
            <form action = "{{route('perfil.actualizarIMG')}}" method="POST" enctype="multipart/form-data"> 
                @csrf
                <div class = "alert alert-secondary"> 
                    Seleccione una imagen no muy pesada y en un formato válido ! :)
                </div>
                <div> 
                    <input type="file" class ="input form-control-file mb-3" name='foto' accept=".jpg, .png, .jpeg">
                    @error("foto")
                        <span class="text-danger">{{$message}} </span>
                    @enderror
                    
                </div>
                <div class="text-right"> 
                    <button type="submit" class="btn block=succes btn-rounded"> Modificar perfil</button>
                    <button type="submit" form="eliminarFoto" class="btn block=danger btn-rounded"> Eliminar foto</button>
                    
                </div>
            </form>

            <form action="{{route('perfil.eliminarFotoPerfil')}}" id="eliminarFoto" class="formulario-eliminar" method="GET">


            </form> 








        </div>
        </div>
         <form action="" class="bg-white p-3 mb-4"> 
            
            {{-- <div class= "fl-flex-label col-12 col-lg-6 mb-4 ">
                <input type="number" class="input input__text" placeholder="DNI" value="{{$item->dni}}">
            </div> //No se utiliza en el vídeo --}}

            <div class= "fl-flex-label col-12 col-lg-6 mb-4">
                <input type="text" class="input input__text" placeholder="Nombres"   value="{{$item->nombre}}">
            </div>

            <div class= "fl-flex-label col-12 col-lg-6 mb-4">
                <input type="text" class="input input__text" placeholder="Apellidos"  value="{{$item->apellido}}">
            </div>

             <div class= "fl-flex-label col-12 col-lg-6 mb-4">
                <input type="text" class="input input__text" placeholder="Usuario"  value="{{$item->usuario}}">
            </div>

             <div class= "fl-flex-label col-12 col-lg-6 mb-4">
                <input type="number" class="input input__text" placeholder="Telefono"  value="{{$item->telefono}}">
            </div>

             <div class= "fl-flex-label col-12 col-lg-6 mb-4">
                <input type="text" class="input input__text" placeholder="Dirección"  value="{{$item->direccion}}">
            </div>

            <div class= "fl-flex-label col-12 col-lg-6 mb-4">
            </div>

            <div class="text-right">
                <buttom type"submit" class="btn btn-primary btn-rounded"> Guardar</buttom>
            </div>

        </div>
    </form>
        

        
    @endforeach 
@endsection