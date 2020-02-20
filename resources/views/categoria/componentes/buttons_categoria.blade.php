<div class="row">
	<div class="col-lg-6">
		<a href="{{ route('categorias.edit',$model->id) }}" class="btn btn-primary">Editar</a>
	</div>
	<div class="col-lg-6">
		<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#apaga{{$model->id}}">
  			Apagar
		</button
	</div>
</div>