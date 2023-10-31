<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class MarcaRepository{
    public function __construct(Model $model){
        $this->model = $model;
    }

    public function filtrar($filtro){
        $filtros = explode('$', $filtro);

        foreach($filtros as $filtro){
            $col_op_cam = explode(';',$filtro);
            $this->model = $this->model->where($col_op_cam[0], $col_op_cam[1],$col_op_cam[2]);
        }

        return $this->model;
    }
}
?>