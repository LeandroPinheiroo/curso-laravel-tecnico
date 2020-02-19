@extends('layouts.master')

@push('stylesheets')

	<link href=" {{ asset('css/datatables/dataTables.buttons.min.css') }} " rel="stylesheet" />
	<link href=" {{ asset('css/datatables/dataTables.responsive.min.css') }} " rel="stylesheet"/>


@endpush

@section('body')
<form action="{{ route('categorias.create') }}">
	@csrf
	<div class="row">
		<div class="col-lg-12">
			<center>
				<button type="submit" class="btn btn-primary">
					Nova Categoria
				</button>
			</center>
		</div>	
	</div>
</form>

<div class="row">
	<div class="col-lg-12">
		<table id = 'dataTableBuilder' style = "width:100%;"></table>
	</div>
</div>

@endSection

@push('scripts')
	<script src =  
		" {{ asset('js/datatables/dataTables.jquery.min.js')}} ">
	</script>
	<script src =  
		" {{ asset('js/datatables/dataTables.bootstrap.min.js')}} ">
	</script>
	<script src =  
		" {{ asset('js/datatables/dataTables.buttons.min.js')}} ">
	</script>
	<script src =  
		" {{ asset('js/datatables/dataTables.responsive.min.js')}} ">
	</script>
	<script src =  
		" {{ asset('vendor/datatables/buttons.server-side.js')}} ">
	</script>
	{{ $dataTable->scripts() }}
@endpush