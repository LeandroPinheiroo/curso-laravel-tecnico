@extends('layouts.master')

@push('stylesheets')

	<link href=" {{ asset('css/datatables/dataTables.buttons.min.css') }} " rel="stylesheet" />
	<link href=" {{ asset('css/datatables/dataTables.responsive.min.css') }} " rel="stylesheet"/>


@endpush

@section('body')

@foreach($categorias as $categoria)
	<form action="{{ route('categorias.destroy',$categoria->id) }}" method="POST">
		{{ method_field('DELETE')}}
		@csrf
		<div class="modal fade" tabindex="-1" id="apaga{{ $categoria->id }}" role="dialog">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title">Modal title</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <p>Deseja apagar a categoria {{ $categoria->nome }}?</p>
		      </div>
		      <div class="modal-footer">
		        <button type="submit" class="btn btn-danger">Apagar</button>
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
		      </div>
		    </div>
		  </div>
		</div>
	</form>
@endForeach

@if(Session::has('success'))
	<div class="alert alert-success alert-dimissible fade show">
		{{ Session::get('success') }}
		<button type="button" class="close" data-dismiss='alert' arial-label="Close">
			<span aria-hidden = "true"> &times; </span>
		</button>
	</div>
@endIF

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