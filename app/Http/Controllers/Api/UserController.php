<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Validator;

use App\User;

class UserController extends Controller
{
    private $user;
    
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $user = $this->user->paginate(10);
        return response()->json($user, 200);
    }

    public function store(Request $request)
    {
        // Fica mais fácil a manipulação dos dados no array
        $data = $request->all();

        if(!$request->has('password') || !$request->get('password'))
        {
            return response()->json([
                'data' => [
                    'msg' => 'Campo senha é obrigatório!'
                ]
                ], 401);
        } 

        $request->validate([
            'profile.phone' => 'required',
            'profile.mobile_phone' => 'required'
        ]);

        try {

            $data['password'] = bcrypt($data['password']);

            // Salva e traz id como referencia para inserir na tabela user_profiles
            $user = $this->user->create($data);

            // Trazendo a relação como método para acessar os recursos do eloquent
            // Eloquent se encarrega de salvar a referencia user_id
            $user->profile()->create([
                'phone' => $request->phone,
                'mobile_phone' => $request->mobile_phone
            ]);

            return response()->json([
                'data' => [
                    'msg' => 'Usuário Cadastrado com sucesso!'
                ]
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 401);
        }
       
    }

    public function show($id)
    {
        try {
            // Quando chamo o método with e seto a relação profile e traz todos os dados inclusive relação
            $user = $this->user->with('profile')->findOrFail($id);
            $user->profile->social_networks = \unserialize($user->profile->social_networks);
            return response()->json($user, 200);

        } catch(Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 401);

        }
    }

    public function update(UserRequest $request, $id)
    {
        if($request->has('password') && $request->get('password'))
        {
            $request->password = bcrypt($request->password);
        } else {
            unset($request->password);
        }

        $request->validate([
            'profile.phone' => 'required',
            'profile.mobile_phone' => 'required'
        ]);

        // Se não atribuir o serialize não reconhece no formato esperado do array de objetos
        $data = $request->all();

        try {
            //Recupera a instancia de profile criado no user
            $profile = $data['profile'];
            
            $profile['social_networks'] = serialize($profile['social_networks']);
            
            $user = $this->user->findOrFail($id);

            $user->update($data);
            // Método profile vem do Model, relacionamento entre user e profile, Eloquent faz a inserção
            // Já setado o ID user na tabela profile
            $user->profile()->update($profile);

            return response()->json([
                    'data' => [
                        'msg' => 'Usuário atualizado com sucesso!'
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
            $user = $this->user->findOrFail($id);
            $user->delete();

            return response()->json([
                'msg' => 'Usuário deletado com sucesso!'
            ], 200);

        } catch(Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 401);
        }
    }
    
}
