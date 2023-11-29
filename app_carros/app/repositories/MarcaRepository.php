<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class MarcaRepository{
    public function __construct(Model $model){
        $this->model = $model;
    }
    public function filtrar($arg){

        $filtros = explode(';', $arg);
        foreach($filtros as $filtro){
            $col_op_cam = explode(':',$filtro);
        
            if(count($col_op_cam)>2){
                $this->model = $this->model->where($col_op_cam[0],$col_op_cam[1],$col_op_cam[2]);
            }else{
                // dd($col_op_cam);
                $this->model = $this->model->where($col_op_cam[0],$col_op_cam[1]);
            }

        }

        return $this->model;
    }
}
?>