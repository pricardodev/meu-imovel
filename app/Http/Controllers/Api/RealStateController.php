<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RealStateRequest;
use App\RealState;
use App\Category;

class RealStateController extends Controller
{

    private $realState; 
    //Atribui a instância a variável
    public function __construct(RealState $realState)
    {
        $this->realState = $realState;
    }

    public function index()
    {
        $realState = $this->realState->paginate(10);

        return response()->json($realState, 200);
    }

    public function show($id) 
    {
        try {
            $realState = $this->realState->with('photos')->findOrFail($id);
            
            return response()->json([
                'data' => $realState
            ], 200);

        } catch(Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 401);
        }
       
    }

    public function store(RealStateRequest $request) 
    {
        try{
            // recupera o array de imagens
            $images = $request->file('images');

            //Método crate salva como array e retorna id do dado inserido
            $realState = $this->realState->create($request->all());

            if(isset($request->categories) && count($request->categories))
            {
               //SYNC aceita uma matriz de IDs para colocar na tabela intermediária
               //Ids fora da matrix fornecida serão removidos da tablea intermédiária
                $realState->categories()->sync($request->categories);
            }

            if($images)
            {
                $imagesUploaded = [];
                foreach($images as $image)
                {
                    // Sala na pasta images no app/public imagens com referencia para não da conflitos
                    $path = $image->store('iamges', 'public');
                    $imagesUploaded[] = ['photo' => $path, 'is_thumb' => false];
                }

                $realState->photos()->createMany($imagesUploaded);
            }

            return response()->json([
                'data' => [
                    'msg' => 'Imóvel cadastrado com sucesso!'
                ]
                ], 200);

        } catch(Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 401);
        }    
    }

    public function update(RealStateRequest $request, $id)
    {
        $images = $request->file('images');

        try {
            $realState = $this->realState->findOrFail($id);

            if(isset($request->categories) && count($request->categories))
            {
               //SYNC aceita uma matriz de IDs para colocar na tabela intermediária
               //Ids fora da matrix fornecida serão removidos da tablea intermédiária
                $realState->categories()->sync($request->categories);
            }

            if($images)
            {
                $imagesUploaded = [];
                foreach($images as $image)
                {
                    $path = $image->store('images', 'public');
                    $imagesUploaded[] = ['photo' => $path, 'is_thumb' => false];
                }

                $realState->photos()->createMany($imagesUploaded);
            }

            $realState->update($request->all());

            return response()->json([
                'data' => [
                    'msg' => 'Imóvel atualizado com sucesso!'
                ]
                ], 200);

        } catch(Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 401);
        }
    }

    public function destroy($id)
    {
        try {
            $realState = $this->realState->findOrFail($id);
            $realState->delete();

            return response()->json([
                'msg' => 'Imóvel deletado com sucesso!'
            ], 200);

        } catch(Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 401);
        }
    }
}
