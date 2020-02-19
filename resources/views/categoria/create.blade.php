@extends('layouts.master')
@section('body')
<h1>Categoria - Criar</h1>
<form action="{{ route('categorias.store') }}" method="POST">
  @csrf
  <div class="form-group">
    <label>Nome</label>
    <input type="text" class="form-control" id="nome" name = "nome" placeholder="Entre com o nome da Categoria">
    @if($errors->get('nome'))
      @foreach($errors->get('nome') as $error)
        <span class="text-danger">{{ $error }}</span>
      @endForeach
    @endIF
  </div>
  <div class="form-group">
    <label>Descrição</label>
    <textarea class="form-control" name="descricao" id = "descricao" placeholder="Entre com a Descrição">
    </textarea>
  </div>
  <button type="submit" class="btn btn-primary">Cadastrar</button>
</form>

@endSection