<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Market y Restaurante Puerta a la Verapaces </title>
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
    <table style="width:100%" border="1">
        <tr>
          <th><center><h4> <p>Market y Restaurante Puerta a la Verapaces </p> 
            <p>Kilometo 95, Marajuma, Morazan, El Progreso</p>
            <p>Telefono 3283-5382.</p></h4></center></th> 
        </tr>
      </table>
  
    </div>
<div class="row">
  <div class="col-6">
    <table style="width:100%" border="1">  
    <tr>
          <td>
            Nombre: {{$cliente[0]->nombres  }}
          </td>
          <td>
            Dirección: {{$cliente[0]->direccion }}
          </td>
          <td>
            Nit: {{$cliente[0]->nit  }}
          </td>
          </tr>
        </table>
    </div>
  <div class="col-6">
    <table style="width:100%" border="1"> 
    <tr>   
          <td><h5>Factura</h5>
            
          </td> 
          <td>Serie: {{$facturas[0]->serie  }}</td>
          <td>Número: {{$facturas[0]->numero  }}</td>
            
        </tr>
      </table>
  </div>

</div>
  <br>
<div class="row">
  <table style="width:100%" border="1">   
    <tr>
        <td>
          cantidad
        </td>
        <td>
          Descripcion
        </td>
        <td>
          SubTotal
        </td>
    </tr>
    @foreach ($detalle as $item)    
    <tr>
      <td>{{$item->cantidad  }} </td>
      <td> {{$item->nombre  }} </td>
      <td> {{$item->subtotal  }} </td>
    </tr>
    @endforeach
  </table>
</div>
<div class="row">
  <table style="width:40% " border="1" align="right" >
<tr>
  <td >
    Total:
  </td>
  <td>
      {{$facturas[0]->total  }}
  </td>
</tr>
  </table>
</div>
 


    <!-- Latest compiled and minified JavaScript -->
{{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>--}}
</body>
</html>