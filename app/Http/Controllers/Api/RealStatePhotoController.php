<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\RealStatePhoto;
use App\Api\ApiMessages;

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

            $photo = $this->realStatePhoto->where('real_state_id', $realStateId)->where('is_thumb', true);

            if ($photo->count()) {
                $photo->first()->update(['is_thumb' => false]);
            }

            $photo = $this->realStatePhoto->find($photoId);
            $photo->update(['is_thumb' => true]);

            return response()->json(['data' => ['msg' => 'Thumb Atualizada com Sucesso!']], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function remove($photoId)
    {
        try {

            $photo = $this->realStatePhoto->find($photoId);

            if ($photo->is_thumb) {
                $message = new ApiMessages('Não é possivel remover foto de Thumb, selecione outra Thumb e remova a imagem desejada!');
                return response()->json($message->getMessage(), 401);
            }

            if ($photo) {
                Storage::disk('public')->delete($photo->photo);
                $photo->delete();
            }

            return response()->json(['data' => ['msg' => 'Thumb Removida com Sucesso!']], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

}
