@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="text-center">Denuncias</h1>
@stop

@section('content')
   

<div class="container">
    <div class="container-fechas">
        <select name="fechas" id="fechas" class="form form-control">
            <option value="">Fechas</option>
            <option value="1">Hoy</option>
            <option value="2">Ultima Semana</option>
            <option value="3">Este mes</option>
    
        </select>
    </div>
    <div class="container-estados">
        <select name="estado" id="estado" class="form form-control">
            <option value="0">Estado</option>
            <option value="1">Pendientes</option>
            <option value="2">Aceptadas</option>
            <option value="3">Rechazadas</option>
    
        </select>
    </div>
   
</div>
<table id="example" class="table table-striped table-bordered" style="width:100%">
    <thead class="myHeader">
        <tr>
            <th class="text-center">Fecha</th>
            <th class="text-center">Descripcion</th>
            <th class="text-center">Estado</th>
            <th class="text-center">Acccion</th>
            
        </tr>
    </thead>
    <tbody>

        @foreach($denuncias as $denuncia)
                <tr>
                    <td class="text-center">{{$denuncia->fecha_formateada}}</td>

                    <td class="text-center">{{'Fue visto por ultima vez en ,'.$denuncia->direccion .' ' . 'el '. $denuncia->fecha_desaparicion .'a horas '. $denuncia->hora_desaparicion .' con '. $denuncia->ultima_ropa_puesta}}</td>

                    <td class="text-center"><span class="badge badge-{{$denuncia->color_badget}}">{{ $denuncia->estado_descripcion }}</span></td>

                    <td class="align-content-around"> <a href="{{route('show.denuncia',$denuncia->id)}}" class="btn btn-sm-light ml-3">
                        <i class="fa fa-eye"></i>
                        <br>Ver Denuncia
                    </a></td>
                
                </tr>

        @endforeach
    </tbody>
</table>


@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    tr td .btn{
       width:auto; 
       height:auto;
       border-radius: 10px;

    }

    .myHeader{
        background-color: #D98E8E;
    }

    .container{
        display: flex;
        justify-content:space-around;
        margin-bottom:2.5rem;
    }
    
</style>
@stop

@section('js')

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
    <script> 
        new DataTable('#example');
    </script>


@stop
