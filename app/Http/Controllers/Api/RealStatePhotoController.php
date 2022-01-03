<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\RealStatePhoto;
use App\Api\ApiMessages;
use Illuminate\Support\Facades\Storage;
use App\Validations\ValidationRealStatePhoto;


class RealStatePhotoController extends Controller
{
    private $realStatePhoto;
    private $validationRealStatePhoto;

    public function __construct(RealStatePhoto $realStatePhoto, ValidationRealStatePhoto $validationRealStatePhoto)
    {
        $this->realStatePhoto = $realStatePhoto;
        $this->validationRealStatePhoto = $validationRealStatePhoto;
    }

    public function setThumb($photoId, $realStateId)
    {
        try {

            $erros = $this->validationRealStatePhoto->validateIdRealStatePhoto($photoId, $realStateId, $this->realStatePhoto);

            if ($erros) {
                return response()->json(['errors' => $erros], 401);
            }

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

            $erros = $this->validationRealStatePhoto->validateIdRealPhotoState($photoId, $this->realStatePhoto);

            if ($erros) {
                return response()->json(['errors' => $erros], 401);
            }

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
