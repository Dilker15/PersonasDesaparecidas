@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')


<div class="container">
    <h1>Detalles de la denuncia</h1>

    <form action="{{route('actualizar.estado',$denuncia->id)}}" method="post" id="formulario">
        @csrf
        @method('POST')
        <div class="cambiar-estado padre">
            <select name="estado" class="form from-control cambiar-estado" id="estado" onchange="enviar()">
                <option value="1" {{$denuncia->estado == 1?'selected':''}}>Pendiente</option>
                <option value="2" {{$denuncia->estado == 2?'selected':''}}>Aceptado</option>
                <option value="3" {{$denuncia->estado == 3?'selected':''}}>Rechazado</option>
            </select>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form form-control text-center" id="nombre" value="{{ $denuncia->nombre }}" disabled>
                    </div>
                    <div class="col-md-6">
                        <label for="ultima_ropa">Ultima Ropa Puesta</label>
                        <input type="text" class="form form-control text-center" id="nombre" value="{{ $denuncia->ultima_ropa_puesta }}" disabled>
                    </div>
                   
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label for="genero">Genero</label>
                        <input type="text" class="form form-control text-center" id="genero" value="{{ $denuncia->genero == 1 ? "Masculino":"Femenino" }}" disabled>
                    </div>
                    <div class="col-md-3">
                        <label for="nombre">Fecha Nacimiento</label>
                        <input type="text" class="form form-control " id="nombre" value="{{ $denuncia->fecha_nacimiento }}" disabled>
                    </div>
                    <div class="col-md-3">
                        <label for="nombre">Altura</label>
                        <input type="text" class="form form-control" id="nombre" value="{{ $denuncia->altura }}" disabled>
                    </div>
                    <div class="col-md-3">
                        <label for="nombre">Peso</label>
                        <input type="text" class="form form-control" id="nombre" value="{{ $denuncia->peso }}" disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="nombre">Donde se Dirigia</label>
                        <input type="text" class="form form-control text-center" id="nombre" value="{{ $denuncia->direccion }}" disabled>
                    </div>
                    <div class="col-md-3">
                        <label for="nombre">Fecha Desaparicion</label>
                        <input type="text" class="form form-control " id="nombre" value="{{ $denuncia->fecha_desaparicion }}" disabled>
                    </div>
                    <div class="col-md-3">
                        <label for="nombre">Hora Desaparicion</label>
                        <input type="text" class="form form-control" id="nombre" value="{{ $denuncia->hora_desaparicion }}" disabled>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label for="cicatriz">Cicatrices</label>
                        <input type="text" class="form form-control text-center" id="nombre" value="{{ $denuncia->cicatriz }}" disabled>
                        
                    </div>
                    <div class="col-md-6">
                        <label for="tatuajes">Tatuajes</label>
                        <input type="text" class="form form-control text-center" id="nombre" value="{{ $denuncia->tatuaje }}" disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="cicatriz">Color Cabello</label>
                        @foreach($colores as $color)
                        @if($color->id == $denuncia->color_ojos)
                             <input type="text" class="form form-control text-center" id="nombre" value="{{ $color->nombre }}" disabled>
                        @endif
                    @endforeach
                    </div>
                    <div class="col-md-6">
                        <label for="tatuajes">Color Ojos</label>
                        @foreach($colores as $color)
                        @if($color->id == $denuncia->color_cabello)
                             <input type="text" class="form form-control text-center" id="nombre" value="{{ $color->nombre }}" disabled>
                        @endif
                    @endforeach
                    </div>
                </div>
            </div>
            
        </div>

        <div class="card">
            <div class="card-body">
                <button type="button" class="form form-control-sm bg-primary" id="galeria" onclick="change();">Imágenes</button>
                <div class="container-fotos mostrar" id="container-fotos"> <!-- Agrega una clase inicial para ocultar el elemento -->
                    @foreach($fotos as $foto)
                        <a href="#"><img src="{{$foto->foto}}" class="fotoDenuncia" alt="fotografia"></a>
                    @endforeach
                    <a href="#"><img src="{{$documento->foto}}" class="fotoDenuncia" alt="fotografia"></a>
                </div>
            </div>
        </div>

       
    </form>
</div>
    



@stop

@section('css')

<style>
    .container-fotos{
        width:90%;
        display: flex;
        justify-content: space-around;
        
    }

    .fotoDenuncia{
        border-radius: 10px;
        width:100%;
        height:320px;

    }
   
    .mostrar{
        display: none;
    }

    .cambiar-estado{
        width: 10rem;
        height: 50px;
        margin-left:76%;
        border-radius: 15px;
        background-color:lightblue;
        /* left: 89%; */
        z-index: 10;
    }
    .padre{
        background-color: transparent;
    }
</style>
    
@stop

@section('js')


<script>
    function change(){
        let elemento = document.getElementById('container-fotos');
        //console.log(elemento.remove);

        elemento.classList.toggle('mostrar'); // Elimina la clase
       // elemento.classList.add('miClase'); // Agrega la clase
    }


    function enviar(){
        let formu = document.getElementById('formulario');
        formu.submit();
    }
</script>

@stop
