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

    public function index()
    {
        return response()->json($this->modelo->with('marca')->get(),201);
        
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

        if($modelo === null){
            return response()->json(['error'=>'modelo nâo encontrada'], 404);
        }

        if ($request->method() === 'PATCH'){
            foreach($this->modelo->rules() as $input => $rule){
                if($input === array_keys($request->all())[0]){
                    $rules[$input] = $rule;
                }
            }

           $request->validate($rules);

        }else{

            $request->validate($this->modelo->rules());

        }

        if($request->image && $modelo->imagem){
            Storage::disk('public')->delete($modelo->imagem);
        }

        $imagem = $request->file('imagem');
        $url_image = $imagem->store('imagens','public');

        $modelo->update([
            'nome'=>$request->nome,
            'imagem'=>$url_image,
            'marca_id' => $request->marca_id,
            'numero_portas' => $request->numero_portas,
            'lugares' => $request->lugares,
            'air_bag'=> $request->air_bag,
            'abs'=> $request->abs,
        ]);

        // $marca->update($request->all());
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
