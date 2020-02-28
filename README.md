## Avisos

Devido ao tempo limitado para a apresentação desse curso e o nível dos alunos alvo não será utilizado o padrão repository.

## Requisitos Computacionais

- [php >= 7]
- [mysql ou mariadb]
- [composer]

## Pré-requisitos dos alunos

- PHP Básico
- PHP com OO
- HTML 5
- CSS 3
- Bootstrap

## Criando um novo projeto

Composer é o gerenciador de dependências do php, assim como o maven para o Java por exemplo, ele gerencia as dependências de projetos. Uma dependência pode ser um pacote de geração de tabelas, boletos, integração com meios de pagamento, entre outras. 
Para criar um projeto Laravel via composer é extremamente simples, basta abrir um terminal linux/mac ou um bash no windows na pasta onde se deseja criar o projeto e rodar o seguinte comando:

```
composer create-project laravel/laravel curso-laravel-tecnico
```

## Arquivo .env

O arquivo .env é uma maneira mais fácil de carregar variáveis de configuração personalizadas que o seu aplicativo precisará ter, além de conter informações específicas do sistema como credências de acesso ao banco de dados. Assim por questões de configurações mais internas não é recomendado que este arquivo seja enviado para o controlador de versões utilizado (GitHub, GitLab, BitBucket...), existe um arquivo copia que é utilizado para a criação do arquivo .env, para criar nosso arquivo .env vamos utilizar o arquivo .env.example como base assim em um terminal linux basta rodar o seguinte comando para copiar o arquivo.

```
cp .env.example .env 
```

- Posteriormente abra o arquivo .env e edite as informações como abaixo, vale ressaltar que o nome de usuário e senha pode variar de acordo com a instalação na máquina utilizada.

```
DB_DATABASE=minicurso
DB_USERNAME=root
DB_PASSWORD=root
```

## Gerando Chave do aplicativo

A próxima coisa que você deve fazer após configurar o arquivo .env é definir a chave do aplicativo como uma sequência aleatória. Como instalamos o projeto via Composer, essa chave pode ser gerada pelo seguinte comando:
```
php artisan key:generate
```
## Servidor local

Para rodar o servidor local e ver nossa aplicação Laravel basta rodar o seguinte comando:

```
php artisan serve
```
O servidor será iniciado no endereço http://127.0.0.1:8000, acesse-o e veja a tela de apresentação do Laravel.

## Criação do banco de dados

Essa parte é muito simples, apenas criaremos o banco (Schema), e depos o Laravel cuidará da estrutura do banco com as  migrations, que será apresentada mais adiante. Para criamos o nosso banco em um terminal linux por exemplo basta rodar os seguintes comandos:

```
mysql -u root -p 
root
create database minicurso;
quit; 
```

## Criando um sistema de login
Para criar um sistema de login o Laravel nos proporciona isso tudo pronto, desde o Front-end ao nosso Back-end, para usarmos esse serviço basta rodar os seguintes comandos:

```
composer require laravel/ui
php artisan ui:auth
```
Pronto somente com esses dois comando temos nossa aplicação com um sistema completo de login e cadastro de usuários.

## Criando model e migration
Para criar nosso model e nossa migration basta rodar o seguinte comando

```
php artisan make:model Categoria --migration
```
Feito isso será criado um arquivo em /app e um arquivo em /database/migrations. Inicialmente abra o arquivo dentro de /database/migrations e acresente ao arquivo um campo de nome e um campo para descrição, seu arquivo deverá ficar conforme o seguinte:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categorias');
    }
}
```
Pronto já temos nosso arquivo de criação da tabela do nosso banco de dados e nosso arquivo de Model para acessar o Banco. Para que possamos criar nossa tabela no Banco de Dados bastar rodar o seguinte comando no terminal na pasta raiz do projeto:

```
php artisan migrate
```

## Criando nossa View de Acesso

Pelo tempo limitado do curso e como o foco não é apresentação de como construir um Front-end foi disponibilizado um template do bootstrap (Admin LTE) para a criação do nosso front, ele pode ser encontrado no diretório /resources/views/layouts/master.blade.php.

Como vamos criar vários arquivos para as categorias cadastradas vamos criar uma pasta dentro de /resources/views/ com o nome de categoria, onde nela vamos definir nosso Front-end, dentro dessa pasta vamos criar um arquivo chamado index.blade.php e vamos adicionar o seguinte código a ele:

```blade
@extends('layouts.master')
@section('body')
    <form>
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
```
Feito isso já temos nossa view e podemos criar nosso Controller para acesso a ela, segue na próxima seção.

## Criando Controller e rotas de acesso

Para criarmos nosso controller vamos rodar o seguinte comando no terminal:
```
php artisan make:controller CategoriaController --resource
```
Ao executar o comando será criado no diretório /app/Http/Controllers o nosso controler com o nome de CategoriaController.

Feito isso vamo abrir o arquivo de rotas do laravel no diretório /routes/web.php
e adicionar a seguinte linha no mesmo:
```php

Route::resource('categorias','CategoriaController');

```
Após criar nossas rotas vamos abrir nosso arquivo no diretório /resources/views/layouts/master.blade.php e no menu lateral vamo alterar para a seguinte forma:
```blade
 <section class="sidebar">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Menu</li>
        <li class="treeview">
            <a href="#">
            <i class="fa fa-cubes"></i> <span>Cadastros</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
            <li><a href="{{ route('categorias.index') }}"><i class="fa fa-circle-o"></i>Categoria</a></li>
            </ul>
        </li>
    </ul>
</section>
```


## Criando Tabela para exibir categorias cadastradas

Para criamos uma tabela onde mostraremos nossas Categorias Cadastradas existe diversas opções, criar uma tabela do zero, utilizar uma do bootstrap e paginar a mesma entre outros. Felizmente já existe um pacote gratuito que utiliza o datatables.net para exibir os dados, o pacote criado pelo usuário Yajra pode ser adicionado rodando os seguintes comandos na raiz do projeto:

```
composer require yajra/laravel-datatables-buttons
composer require yajra/laravel-datatables-oracle
php artisan vendor:publish
```

No último comando, utiliza a opção 0 para publicar todos os providers.

Vamos criar uma datatable para a tabela categorias.

```
php artisan datatables:make Categoria --model
```

Feito isso vamos configurar nosso arquivo, ao final ele deverá estar da seguinte forma
```php

<?php

namespace App\DataTables;

use App\Categoria;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CategoriaDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Categoria $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Categoria $model)
    {
        return $model->newQuery()->select($this->getColumns());
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->parameters(
               ['dom' => 'Bfrtip',
               'order' => [ [0, 'asc'] ],
               'buttons' => [
                   'csv', 
                   'excel'
                ],
               'language' => [
                        'url' => 'http://cdn.datatables.net/plug-ins/1.10.15/i18n/Portuguese-Brasil.json'
                   ]
               ]
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id',
            'nome',
            'descricao',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Categoria_' . date('YmdHis');
    }
}

```
Agora na nossa view index no diretorio /resouces/views/categoria/index.blade.php vamos adicionar as seguintes importações no inicio e no final do código:
```blade
@push('stylesheets')

	<link href=" {{ asset('css/datatables/dataTables.buttons.min.css') }} " rel="stylesheet" />
	<link href=" {{ asset('css/datatables/dataTables.responsive.min.css') }} " rel="stylesheet"/>

@endpush

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
```

Por fim vamos abrir nosso arquivo de CategoriaController.php e definir o método index para a seguinte forma:
```php
    public function index(CategoriaDataTable $dataTable)
    {
        $categorias = Categoria::get();
        return $dataTable->render('categoria.index',['categorias' => $categorias]);
    }
```
Vale ressaltar que não devemos esquecer a importações que devem ser as seguintes:

```php
    use Illuminate\Http\Request;
    use App\DataTables\CategoriaDataTable;
    use App\Categoria;
```

Feito isso ao clicar-mos no menu lateral em Categorias ou entao acessar a URL  http://127.0.0.1:8000/categorias veremos nossa tela de listagem de categorias.

## Store Categorias

Para criarmos o as funções para salvar uma nova categoria inicialmente vamos criar um view dentro da pasta de categoria chamada create.blade.php e vamos adicionar o seguinte código: 
```blade
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
```

Posteriormente na view de categoria chamada index.blade.php vamos alterar o nosso form para acessar nosso controller com o botao de submit, o form deverá ficar da seguinte forma:

```blade
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
```
Vale ressaltar que o token @csrf é utilizado pelo Laravel para identificar se o form que foi submetido é realmente válido.
Por fim vamos fazer nosso método responsável por retornar a view de criação de dados, no método create() dentro da classe CategoriaController vamos adicionar o seguinte código:
```php
public function create()
{
    return view('categoria.create');
}
```
Agora para finalmente salvar uma nova categoria no Banco de Dados vamos adicionar o seguinte código ao metodo store() também na classe CategoriaController:
```php
public function store(Request $request)
{    
    $categoria = new Categoria();
    $categoria->nome = $request->input('nome');
    $categoria->descricao = $request->descricao;
    $categoria->save();

    return redirect()->route('categorias.index')
                    ->withSuccess('Categoria cadastrada');
}
```
## Criando Form Validator

Com o código que temos até agora podemos salvar uma categoria no nosso Banco porém caso o usuário não informe os dados corretos não podemos salvar e temos que validar o formulário, para isso vamos criar um form validator com o seguinte comando no terminal na pasta raiz do projeto:

```
php artisan make:request StoreCategoria
```
Com esse comando será criado uma classe no seguinte diretorio /app/Http/Requests/StoreCategoria.php, nele vamos alterar o código para que fique da seguinte maneira:
```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoria extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O nome é obrigatório'
        ];
    }
}
```
Por fim na classe CategoriaController vamos alterar nosso método store() para a seguinte forma:

```php
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
```
Com isso nossa validação está finalizada de forma elegante.


## Botões de acesso para editar e excluir uma categoria

Na nossa tabela temos uma coluna para opções onde vamos criar nossos botões para editar e apagar uma categoria existente, para isso no diretorio /resource/views/categoria, vamos criar uma pasta chamadas componentes e dentro um arquivo chamado buttons_categoria.blade.php nele vamos adicionar o seguinte código:

```blade
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
```

Agora na nossa classe de DataTables no diretório app/DataTables/CategoriaDataTable.php vamos alterar os metodos dataTable() e html() para a seguinte forma:

```php
public function dataTable($query)
{
    return datatables()
        ->eloquent($query)
        ->addColumn('action',function(Categoria $model){
            return view(

                'categoria.componentes.buttons_categoria',
                    [ 'model' => $model ]

            )->render();
        });
}

public function html()
{
    return $this->builder()
        ->columns($this->getColumns())
        ->addAction(
            [
                'width' => '80px',
                'title' => 'Opções',
            ]
        )
        ->parameters(
            ['dom' => 'Bfrtip',
            'order' => [ [0, 'asc'] ],
            'buttons' => [
                'csv', 
                'excel'
            ],
            'language' => [
                    'url' => 'http://cdn.datatables.net/plug-ins/1.10.15/i18n/Portuguese-Brasil.json'
                ]
            ]
        );
}
``` 
Com isso na nossa tabela irá aparecer os botões responsáveis por editar e excluir uma categoria

## Update Categoria
Como já criamos nosso botão de acesso a view de edição de categorias vamos criar no diretório /resource/views/categoria um arquivo chamado update.blade.php e vamos adicionar o seguinte código nele:

```blade
@extends('layouts.master')
@section('body')
    <h1>Categoria - Editar</h1>
    <form action="{{ route('categorias.update',$categoria->id) }}" method="POST">
        {{ method_field('PUT') }}
        @csrf
        <div class="form-group">
            <label>Nome</label>
            <input type="text" class="form-control" id="nome" name = "nome" placeholder="Entre com o nome da Categoria" value="{{ $categoria->nome }}">
            @if($errors->get('nome'))
                @foreach($errors->get('nome') as $error)
                    <span class="text-danger">{{ $error }}</span>
                @endForeach
            @endIF
        </div>
        <div class="form-group">
            <label>Descrição</label>
            <textarea class="form-control" name="descricao" id = "descricao" placeholder="Entre com a Descrição">{{$categoria->descricao}}
            </textarea>
        </div>
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
@endSection
```

Agora no nosso CategoriaController vamos alterar nossos métodos edit() e update(), para que assim nossa categoria consiga ser edita.

```php
public function edit($id)
{
    $categoria = Categoria::findOrFail($id);
    return view('categoria.update',['categoria'=>$categoria]);
}

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
```

## Delete Categoria

Para que possamos deletar uma categoria cadastrada vamos criar em nossa tela de index um modal para validar ao clicar no botão delete, o ideal seria criar apenas um modal e preencher os dados com javascript e ajax por exemplo, porém como nosso tempo é limitado vamos criar um modal para cada categoria cadastrada da seguinte forma:

```blade
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
```
Vale ressaltar que essa não é uma boa abordagem pois com uma grande quantidade de itens cadastrados no nosso Banco de Dados irá demorar muito tempo para que a tela seja renderizada, porém como o tempo desse curso não favorece somos obrigados a fazer nosso delete dessa forma. :(

Por fim no método destroy() dentro da classe  CategoriaController vamos alterar para a seguinte forma:
```php
public function destroy($id)
{
    $categoria = Categoria::findOrFail($id);
    $categoria->delete();
    return redirect()->route('categorias.index')
                        ->withSuccess('Categoria apagada com sucesso!');
}
```
Feito isso temos um CRUD completo de categorias.

## Mostrando mensagem de sucesso de ações
Como vocês rjá devem ter reparado no nosso controller já criamos nossos retornos com mensagens de sucesso personalizadas, porém ainda não mostramos essas mensagens na view para o usuário, para fazermos isso vamos adicionar o seguinte código na nossa view index.blade.php dentro da pasta views em resources:

```blade
@if(Session::has('success'))
	<div class="alert alert-success alert-dimissible fade show">
		{{ Session::get('success') }}
		<button type="button" class="close" data-dismiss='alert' arial-label="Close">
			<span aria-hidden = "true"> &times; </span>
		</button>
	</div>
@endIF
```

Ao final nossa view index deverá ficar da seguinte forma: 

```blade
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
```

## Protegendo rotas autenticadadas

Para que um usuário não consiga acessar a tela principal do sistema sem estar logado e cadastrado no sistema vamos alterar nosso Controller CategoriaController inserindo o construtor da seguinte forma:
```php
public function __construct()
{
    $this->middleware('auth');
}
```
Dessa forma nossa middleware auth irá tratar qualquer requisição que chegar nessa classe deixando ser executada somente caso o usuário esteja autenticado no sistema.

Por fim nosso arquivo de routes dentro de /routes/web.php deverá ficar da seguinte maneira:

```php
<?php
Auth::routes();

Route::get('/','HomeController@index')->name('index');
Route::get('/home', 'HomeController@index')->name('home');

Route::resource('categorias','CategoriaController');
```
## Dicas de estudo

Como o tempo estipulado para o mini curso foi extremamente curto não é possível mostrar muita coisa, além de não ser possível mostrar a melhor maneira de utilizar o framework. Com base nisso aconselho verificarem os links abaixo para aprenderem a utilizar o framework Laravel da melhor maneira:

- Laravel (Grátis): https://laravel.com/docs/master/
- Laracasts (en_US): https://laracasts.com
- SchoolOfNet (pt_BR): https://schoolofnet.com
- CodeEducation (pt_BR): https://code.education
- CodeCasts (Grátis, pt_BR): https://www.youtube.com/channel/UCTluPqMkm90zyw6mCde561A/playlists 
- Laravel Brasil no facebook: https://www.facebook.com/groups/laravelbrasil/


<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, yet powerful, providing tools needed for large, robust applications. A superb combination of simplicity, elegance, and innovation give you tools you need to build any application with which you are tasked.

## Learning Laravel

Laravel has the most extensive and thorough documentation and video tutorial library of any modern web application framework. The [Laravel documentation](https://laravel.com/docs) is thorough, complete, and makes it a breeze to get started learning the framework.

If you're not in the mood to read, [Laracasts](https://laracasts.com) contains over 900 video tutorials on a range of topics including Laravel, modern PHP, unit testing, JavaScript, and more. Boost the skill level of yourself and your entire team by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for helping fund on-going Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](http://patreon.com/taylorotwell):

- **[Vehikl](http://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[British Software Development](https://www.britishsoftware.co)**
- **[Styde](https://styde.net)**
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)
- [User10](https://user10.com)
- [Soumettre.fr](https://soumettre.fr/)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
