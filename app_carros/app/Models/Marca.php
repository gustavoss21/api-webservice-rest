<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'imagem'];

    public function rules(){
        return [
            'nome' => 'required|min:3|unique:marcas,nome,'."$this->id",
            'imagem' => 'required|file|mimes:png,jpeg,giff'
        ];
    }

    public function feedback(){
        return [
            'required'=>':attribute requisitado',
            'imagem.mimes'=>'a imagem precisa ser do tipo png ou jpeg'
        ];
    }
}
