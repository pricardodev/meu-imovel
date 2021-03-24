<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\RealState;

class RealStateSearchController extends Controller
{
    private $realState;

    public function __construct(RealState $realState)
    {
        $this->realState = $realState;
    }

    public function index()
    {
        $dados = $this->realState->paginate(10);
        return response()->json([
            'dados' => $dados
        ], 200);
    }

    public function show($id)
    {
        //
    }

}
