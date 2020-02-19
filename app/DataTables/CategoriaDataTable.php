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
