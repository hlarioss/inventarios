<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

</head>
<body>
    @yield('content')
</body>
<script src="{{ URL::to("js/jquery.min.js")  }}"></script>
	<script src="{{ URL::to("js/bootstrap.min.js")  }}"></script>
	<script src="{{ URL::to("js/jquery.validate.js")  }}"></script>
	<script src="{{ URL::to("js/moment.min.js")  }}"></script>
	<script src="{{ URL::to("js/bootstrap-select.min.js")  }}"></script>
	<script src="{{ URL::to("js/bootstrap-datetimepicker.min.js")  }}"></script>

	<!--    <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script> -->
	<script src="{{ URL::to("js/users/update.js")  }}"></script>
	<script src="{{ URL::to("js/users/update-information.js")  }}"></script>
	<script src="{{ URL::to("js/datatable/initialize.js")  }}"></script>
	<script src="{{ URL::to("js/datatable/custom_render.js")  }}"></script>
	<script src="{{ URL::to("js/datatable/jquery.dataTables.min.js")  }}"></script>
	<script src="{{ URL::to("js/datatable/dataTables.bootstrap.min.js")  }}"></script>
	<script src="{{ URL::to("js/datatable/dataTables.responsive.min.js")  }}"></script>
    <script src="{{ URL::to("js/datatable/responsive.bootstrap.min.js")  }}"></script>
    {!! HTML::script('/js/jsgrid.js') !!}
	{!! HTML::style('/css/jsgrid.css') !!}
    {!! HTML::style('/css/theme.css') !!}
    
    <script src="{{ URL::to("js/dataTables.buttons.min.js")  }}"></script>
	<script src="{{ URL::to("js/buttons.html5.min.js")  }}"></script>
	<script src="{{ URL::to("js/pdfmake.min.js")  }}"></script>
	<script src="{{ URL::to("js/vfs_fonts.js")  }}"></script>
	<script src="{{ URL::to("js/jszip.min.js")  }}"></script>
    <script src="{{ URL::to("js/bootstrap-toggle.min.js")  }}"></script>
    
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/ladda-bootstrap/0.9.4/spin.min.js"> </script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/ladda-bootstrap/0.9.4/ladda.jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/ladda-bootstrap/0.9.4/ladda.min.js"> </script>

	<script src="https://cdn.jsdelivr.net/jquery.loadingoverlay/latest/loadingoverlay.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.loadingoverlay/latest/loadingoverlay_progress.min.js"></script> -->

@yield('scripts')
</html>