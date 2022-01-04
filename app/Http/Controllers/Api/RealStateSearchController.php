<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Model\RealState;
use Illuminate\Http\Request;
use App\Repository\RealStateRepository;

class RealStateSearchController extends Controller
{
    private $realState;
    //private $validationUser;

    public function __construct(RealState $realState)
    {
        $this->realState = $realState;
        //$this->validationUser = $validationUser;
    }

    public function index(Request $request)
    {
        $repository = new RealStateRepository($this->realState);

        $repository->setLocation($request->all(['state', 'city']));

        if ($request->has('conditions')) {
		    $repository->selectCoditions($request->get('conditions'));
	    }

	    if ($request->has('fields')) {
		    $repository->selectFilter($request->get('fields'));
	    }

        return response()->json(['data' => $repository->getResult()->paginate(10)], 200);
    }

    public function show($id)
    {
        try {

            $realState = $this->realState->with('address')->with('photos')->findOrFail($id);

            return response()->json(['data' => $realState], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

}
