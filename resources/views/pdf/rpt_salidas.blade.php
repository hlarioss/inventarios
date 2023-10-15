<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Market y Restaurante Puerta a la Verapaces</title>
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
    .row-doble{
      width: 92%;
    }


</style>

</head>
<body>

  <div class="row">
    <table style="width:100%" border="0">
        <tr>
          <th><center><h4> <p>Market y Restaurante Puerta a la Verapaces </p> 
            <p>Kilometo 95, Marajuma, Morazan, El Progreso</p>
            <p>Telefono 3283-5382.</p></h4></center></th> 
        </tr>
      </table>
  
    </div>
<div class="row">
  <div class="col-6">
    <table style="width:100%" border="0"> 
      <tr>
        <td>
          NIT: {{$cliente[0]->nit  }}
        </td>
      </tr>
      <tr>
        <td>
        Nombre: {{$cliente[0]->nombres  }}
      </td>
      </tr>
    <tr>
          <td>
            Dirección: {{$cliente[0]->direccion }}
          </td>
      </tr>
        </table>
    </div>
  <div class="col-6">
    <table style="width:100%" border="0"> 
        <tr>   
          <td><h5>Orden # {{$detalle[0]->No_Venta  }} </h5>
            
          </td> 
            
        </tr>
      </table>
  </div>

</div>
  <br>
<div class="row">
  <table style="width:100%" border="0">   
    <tr>
        <td>
          Cantidad
        </td>
        <td>
          Descripcion
        </td>
        <td>
          Total
        </td>
    </tr>
    @foreach ($detalle as $item)    
    <tr>
        
      <td>{{$item->cantidad  }} </td>
      <td> {{$item->nombre  }} </td>
      <td> {{$item->total  }} </td>
    </tr>
    @endforeach
  </table>
</div>
<br>
<div class="row">
  <table style="width:40% " border="0" align="right" >
<tr>
  <td >
    Total:
  </td>
  <td>
      {{$venta->total_venta }}
  </td>
</tr>
  </table>
</div>
{{--
<!--div class="row" >
  <table align="center">
    <tr>
      <td>
        <p>Firma Entrega: </p><br>
      <p>__________________________   </p>
      <p> Despacho Bodega </p>
    
      </td>
      <td>
          <p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
      </td>
      <td align="right">
        <p>Firma Recibido: </p><br>
        <p>__________________________   </p>
        <p> {{$cliente[0]->nombres  }}</p>
   
      </td>
    </tr>

  </table>

   
      

</div-->
 
--}}

    <!-- Latest compiled and minified JavaScript -->
{{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>--}}
</body>
</html>