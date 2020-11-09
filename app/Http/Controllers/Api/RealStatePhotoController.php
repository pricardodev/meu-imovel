<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\RealStatePhoto;
use Illuminate\Support\Facades\Storage;

class RealStatePhotoController extends Controller
{
    private $realStatePhoto;

    public function __construct(RealStatePhoto $realStatePhoto)
    {
        $this->realStatePhoto = $realStatePhoto;
    }

    public function setThumb($photoId, $realStateId)
    {
        try {

            $photo = $this->realStatePhoto
                    ->where('real_state_id', $realStateId)
                    ->where('is_thumb', true);
            if($photo->count()) $photo->first()->update(['is_thumb'=> false]);

            $photo = $this->realStatePhoto->find($photoId);
            $photo->update(['is_thumb' => true]);

            return response()->json([
                'data' => [
                    'msg' => 'Thumb atualizada com sucesso!'
                ]
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'data' => [
                    'msg' => 'Erro ao atualizar a Thumb!'
                ]
            ], 401);
        }

    }

    public function remove($photoId)
    {
        try {

            $photo = $this->realStatePhoto->find($photoId);

            if($photo) {
                Storage::disk('public')->delete($photo->photo);
                $photo->delete();
            }
         
            return response()->json([
                'data' => [
                    'msg' => 'Thumb deletada com sucesso!'
                ]
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'data' => [
                    'msg' => 'Erro ao deletar a Thumb!'
                ]
            ], 401);
        }
    }
    
}
