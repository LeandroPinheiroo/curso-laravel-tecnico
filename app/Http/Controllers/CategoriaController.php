<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\CategoriaDataTable;
use App\Categoria;
use App\Http\Requests\StoreCategoria;

class CategoriaController extends Controller
{
    //Construtor Classe Valida Login
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CategoriaDataTable $dataTable)
    {
        $categorias = Categoria::get();
        return $dataTable->render('categoria.index',['categorias' => $categorias]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categoria.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoria $request)
    {
        $request->validated();
        
        $categoria = new Categoria();
        $categoria->nome = $request->input('nome');
        $categoria->descricao = $request->descricao;
        $categoria->save();

        return redirect()->route('categorias.index')
                        ->withSuccess('Categoria cadastrada');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);

        return view('categoria.update',['categoria'=>$categoria]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCategoria $request, $id)
    {
        $categoria = Categoria::findOrFail($id);

        $request->validated();

        $categoria->nome = $request->nome;
        $categoria->descricao = $request->descricao;
        $categoria->update();

        return redirect()->route('categorias.index')
                         ->withSuccess('Categoria atualizada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();
        return redirect()->route('categorias.index')
                         ->withSuccess('Categoria apagada com sucesso!');
    }
}
