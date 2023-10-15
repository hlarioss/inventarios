<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kardex de Producto Total</title>
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<style>

  html{
    margin 0;
  }
    .table {
        height: auto;
    }

    th{
        background-color:gray;
        color: white;
        text-align: center;
    }

</style>

</head>
<body>

    <center><img src="images/car_zone1.jpg" width="300"> </center>
    <center><h3>Kardex de {{$producto[0]->nombre}}</h3></center>
    <center><h4>Del {{$fecha_inicial}} al {{$fecha_final}}</h4></center><p align="right"> Generado por: {{Auth::user()->name}} El {{Carbon\Carbon::now()}} </p>

    <table border="1" width="100%">
        <tr>
            <th style="border: 0px">Fecha</th>
            <th style="border: 0px">Codigo Barra</th>
            <th style="border: 0px">Nombre Producto</th>
            <th style="border: 0px">Ubicación</th>
            <th style="border: 0px">Transaccion</th>
            <th style="border: 0px">Ingreso</th>
            <th style="border: 0px">Salida</th>
            <th style="border: 0px">Existencia Anterior</th>
            <th style="border: 0px">Existencia Actual</th>
        </tr>

        @foreach ($detalles as $detalle)
        <tr>
            <td style="text-align: center">{{$detalle->fecha}}</td>
            <td style="text-align: center">{{$detalle->codigo_barra}}</td>
            <td style="text-align: center">{{$detalle->nombre}}</td>
            <td style="text-align: center">{{$detalle->ubicacion}}</td>
            <td style="text-align: center">{{$detalle->transaccion}}</td>
            <td style="text-align: center">{{$detalle->ingreso}}</td>
            <td style="text-align: center">{{$detalle->salida}}</td>
            <td style="text-align: center">{{$detalle->existencia_anterior}}</td>
            <td style="text-align: center">{{$detalle->saldo}}</td>
        </tr>            
        @endforeach
    </table>

</body>
</html>