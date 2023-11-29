<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\repositories\MarcaRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(Marca $marca){
        $this->marca = $marca;
    }

    public function index(Request $request)
    {   
        $marcaRepository = new MarcaRepository($this->marca);
        if($request->has('filtro')){
            // dd(get_class_methods($marcaRepository));
            $this->marca = $marcaRepository->filtrar($request->filtro); 
        }

        if($request->has('atributos')){
            $this->marca = $this->marca->selectRaw($request->atributos);
        }

        $marcas = $this->marca->paginate(4);

        if($marcas === null){
            return response()->json(['error'=>'sem marcas'], 404);
        }

        return $marcas;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return response()->json(['teste'=>123],201);
        $request->validate($this->marca->rules(),$this->marca->feedback());

        $imagem = $request->file('imagem');
        $url_image = $imagem->store('imagens','public');

        $marca = $this->marca->create([
            'nome'=>$request->nome,
            'imagem'=>$url_image,
        ]);
        

        return response()->json($marca,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $marca = $this->marca->with('modelos')->find($id);

        if($marca === null){
            return response()->json(['error'=>'marca nâo encontrada'], 404);
        }

        return $marca;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function edit(Marca $marca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $marca = $this->marca->find($id);
        $rules = [];

        if($marca === null){
            return response()->json(['error'=>'marca nâo encontrada'], 404);
        }

        if ($request->method() === 'PATCH'){
            foreach($this->marca->rules() as $input => $rule){
                if($input === array_keys($request->all())[0]){
                    $rules[$input] = $rule;
                }
            }

           $request->validate($rules, $this->marca->feedback());

        }else{

            $request->validate($this->marca->rules(), $this->marca->feedback());

        }

        if($request->image && $marca->imagem){
            Storage::disk('public')->delete($marca->imagem);
        }

        $imagem = $request->file('imagem');
        $url_image = $imagem->store('imagens','public');

        $marca->fill($request->all());

        $marca->imagem = $url_image;

        $marca->save();

        // $marca->update($request->all());
        return  $marca;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $marca = $this->marca->find($id);

        if($marca === null){
            return response()->json(['error'=>'marca nâo encontrada'], 404);
        }

        if($marca->imagem){
            Storage::disk('public')->delete($marca->imagem);

        }

        $marca->delete($id);

        return ['msg'=>'deletado'];
    }
}
