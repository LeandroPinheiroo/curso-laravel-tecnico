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

A próxima coisa que você deve fazer após configurar o arquivo .enb é definir a chave do aplicativo como uma sequência aleatória. Como instalamos o projeto via Composer, essa chave pode ser gerada pelo seguinte comando:
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