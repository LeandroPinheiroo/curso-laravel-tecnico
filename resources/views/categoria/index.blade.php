@extends('layouts.master')
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
@endSection