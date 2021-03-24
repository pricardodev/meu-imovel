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
        // Pegando so os imoveis do usuário autenticado (Obs. realstate é método do Model que pode ser chamado como atributo)
        // uso como método se quiser utilizar outros métodos concatenados como o paginate()
        $realStates = auth('api')->user()->real_state();
        return response()->json($realStates->paginate(10), 200);
    }

    public function show($id) 
    {
        try {
            // só os imoveis do usuário logado junto com as fotos
            $realState = auth('api')->user()->real_state()->with('photos')->findOrFail($id);
            
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
        // recupera o array de imagens
        $images = $request->file('images');
        $data = $request->all();
        try{
            // recuperando o id do usuário logado
            $data['user_id'] = auth('api')->user()->id;
            
            //Método crate salva como array e retorna id do dado inserido
            $realState = $this->realState->create($data);

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
            $realState = auth('api')->user()->real_state()->findOrFail($id);
            $realState->update($request->all());

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
            $realState = auth('api')->user()->real_state()->findOrFail($id);
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
