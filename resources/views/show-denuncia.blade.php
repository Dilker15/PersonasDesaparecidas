@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')


<div class="container">
    <h1>Detalles de la denuncia</h1>

    <form>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form form-control" id="nombre" value="{{ $denuncia->nombre }}" readonly>
                    </div>
                    <div class="col-md-2">
                        <label for="genero">Genero</label>
                        <input type="text" class="form form-control" id="genero" value="{{ $denuncia->genero == 1 ? "Masculino":"Femenino" }}" readonly>
                    </div>
                    <div class="col-md-5">
                        <label for="nombre">Fecha Nacimiento</label>
                        <input type="text" class="form form-control" id="nombre" value="{{ $denuncia->fecha_nacimiento }}" readonly>
                    </div>
                </div>
                <div class="row">

                </div>
            </div>
        </div>
        
        
        <div class="form-group">
            <label for="Genero">Genero</label>
            <textarea class="form form-control" id="genero" rows="5" readonly>{{ $denuncia->genero }}</textarea>
        </div>

        <div class="form-group">
            <label for="fecha_nacimiento">Fecha Nacimiento</label>
            <textarea class="form form-control" id="fecha_nacimiento" rows="5" readonly>{{ $denuncia->fecha_nacimiento }}</textarea>
        </div>

        <div class="form-group">
            <label for="altura">Altura</label>
            <textarea class="form form-control" id="altura" rows="5" readonly>{{ $denuncia->altura}}</textarea>
        </div>

        <div class="form-group">
            <label for="peso">Peso</label>
            <textarea class="form form-control" id="peso" rows="5" readonly>{{ $denuncia->peso}}</textarea>
        </div>

        <div class="form-group">
            <label for="cicatriz">Cicatriz</label>
            <textarea class="form form-control" id="cicatriz" rows="5" readonly>{{ $denuncia->cicatriz}}</textarea>
        </div>

        <div class="form-group">
            <label for="tatuaje">Tatuaje</label>
            <textarea class="form form-control" id="tatuaje" rows="5" readonly>{{ $denuncia->tatuaje}}</textarea>
        </div>

        
        <div class="form-group">
            <label for="direccion">Direccion Desaparicion</label>
            <textarea class="form form-control" id="direccion" rows="5" readonly>{{ $denuncia->tatuaje}}</textarea>
        </div>
        <!-- Agrega más campos según los datos que desees mostrar -->


        <a href="#" class="btn btn-primary">Volver</a>
    </form>
</div>
    



@stop

@section('css')
    
@stop

@section('js')


@stop
