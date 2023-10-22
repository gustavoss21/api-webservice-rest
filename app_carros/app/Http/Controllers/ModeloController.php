<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ModeloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(Modelo $modelo){
        $this->modelo = $modelo;
    }

    public function index(Request $request)
    {
        if($request->has('atributos')){

            $atributos = $request->atributos;
            // $marcas = $this->marca->fill($request->all());
            $modelos = $this->modelo->selectRaw($atributos)->with('marca')->get();

        }else{
            $modelos = $this->modelo->all();
        }
        return response()->json($modelos ,201);
        
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

        $request->validate($this->modelo->rules());

        $imagem = $request->file('imagem');
        $url_image = $imagem->store('imagens/modelo','public');
        $modelo = $this->modelo->create([
            'nome'=>$request->nome,
            'marca_id' => $request->marca_id,
            'imagem'=>$url_image,
            'numero_portas' => $request->numero_portas,
            'lugares' => $request->lugares,
            'air_bag'=> $request->air_bag,
            'abs'=> $request->abs,
        ]);
        

        return response()->json($modelo,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $modelo = $this->modelo->with('marca')->find($id);

        if($modelo === null){
            return response()->json(['error'=>'marca nâo encontrada'], 404);
        }

        return $modelo;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function edit(Modelo $modelo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $modelo = $this->modelo->find($id);
        $rules = [];
        $campos = ['nome', 'imagem', 'marca_id', 'numero_portas', 'lugares', 'air_bag', 'abs'];
        $modelo_campos = [];
        $imagem = '';

        if($modelo === null){
            return response()->json(['error'=>'modelo nâo encontrada'], 404);
        }

        // validação para cada metodo e definição de seus campos
        if ($request->method() === 'PATCH'){
            foreach($this->modelo->rules() as $input => $rule){
                if($input === array_keys($request->all())[0]){
                    $rules[$input] = $rule;
                }
            }

           $request->validate($rules);
 
            foreach($campos as $campo){
                if($request[$campo]){
                    $modelo_campos[$campo] = $request[$campo];

                }
            }

        }else{

            $request->validate($this->modelo->rules());
            $modelo_campos = $request->all();
        }

        // definição do campo imagem
        if($request->imagem){
            if($modelo->imagem){
                Storage::disk('public')->delete($modelo->imagem);
            }
            
            $imagem = $request->file('imagem');
            
            $modelo_campos['imagem'] = $imagem->store('imagens','public');
        }

        $modelo->update($modelo_campos);
            // dd($modelo_campos);

        return  $modelo;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $modelo = $this->modelo->find($id);

        if($modelo === null){
            return response()->json(['error'=>'modelo nâo encontrada'], 404);
        }
                
        if($modelo->imagem){
            Storage::disk('public')->delete($modelo->imagem);
            // dd($modelo->imagem);
        }

        $modelo->delete($id);

        return ['msg'=>'deletado'];
    }
}
