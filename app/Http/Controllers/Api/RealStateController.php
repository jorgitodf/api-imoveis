<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Model\RealState;
use App\Validations\ValidationRealState;
use Illuminate\Http\Request;

class RealStateController extends Controller
{
    private $realState;
    private $validateRealState;

    public function __construct(RealState $realState, ValidationRealState $validateRealState)
    {
        $this->realState = $realState;
        $this->validateRealState = $validateRealState;
    }

    public function index()
    {
        $realStates = auth('api')->user()->real_state();
        return response()->json($realStates->paginate('10'), 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $images = $request->file('images');

        $erros = $this->validateRealState->validateRealState($data, $this->realState, null, $images);

        if ($erros) {
            return response()->json(['errors' => $erros], 401);
        }

        try {

            $data['user_id'] = auth('api')->user()->id;

            $realState = $this->realState->create($data);

            if (isset($data['categories']) && count($data['categories'])) {
                $realState->categories()->sync($data['categories']);
            }

            $imagesUploaded = [];
            foreach ($images as $image) {
                $path = $image->store('images', 'public');
                $imagesUploaded[] = ['photo' => $path, 'is_thumb' => false];
            }
            $realState->photos()->createMany($imagesUploaded);

            return response()->json(['data' => ['msg' => 'Imóvel Cadastrado com Sucesso!']], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function update($id, Request $request)
    {
        $data = $request->all();
        $images = $request->file('images');

        $erros = $this->validateRealState->validateRealState($data, $this->realState, null, $images);

        if ($erros) {
            return response()->json(['errors' => $erros], 401);
        }

        try {

            $realState = auth('api')->user()->real_state()->findOrFail($id);
            $realState->update($data);

            if (isset($data['categories']) && count($data['categories'])) {
                $realState->categories()->sync($data['categories']);
            }

            $imagesUploaded = [];
            foreach ($images as $image) {
                $path = $image->store('images', 'public');
                $imagesUploaded[] = ['photo' => $path, 'is_thumb' => false];
            }
            $realState->photos()->createMany($imagesUploaded);

            return response()->json(['data' => ['msg' => 'Imóvel Atualizado com Sucesso!']], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function destroy($id)
    {
        $erros = $this->validateRealState->validateIdRealState($id, $this->realState);

        if ($erros) {
            return response()->json(['errors' => $erros], 401);
        }

        try {

            $realState = auth('api')->user()->real_state()->findOrFail($id);
            $realState->delete($id);

            return response()->json(['data' => ['msg' => 'Imóvel Removido com Sucesso!']], 200);
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function show($id)
    {
        $erros = $this->validateRealState->validateIdRealState($id, $this->realState);

        if ($erros) {
            return response()->json(['errors' => $erros], 401);
        }

        try {

            $realState = auth('api')->user()->real_state()->with('photos')->findOrFail($id);
            return response()->json(['data' => ['data' => $realState]], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}
