<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Validations\ValidationUser;

class UserController extends Controller
{
    private $user;
    private $validationUser;

    public function __construct(User $user, ValidationUser $validationUser)
    {
        $this->user = $user;
        $this->validationUser = $validationUser;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = $this->user->paginate('10');
		return response()->json($user, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $erros = $this->validationUser->validateUser($data, $this->user);

        if ($erros) {
            return response()->json(['errors' => $erros], 401);
        }

        try {

            $profile = $data['profile'];
            $data['password'] = bcrypt($data['password']);
            $user = $this->user->create($data);
            $user->profile()->create(['phone' => $profile['phone'], 'mobile_phone' => $profile['mobile_phone'],
                'about' => $profile['about'] ?? null, 'social_networks' => serialize($profile['social_networks']) ?? null]);
            return response()->json(['data' => ['msg' => 'Usuário Cadastrado com Sucesso!']], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $user = $this->user->with('profile')->findOrFail($id);
            $user->profile->social_networks = unserialize($user->profile->social_networks);
            return response()->json(['data' => $user], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        $erros = $this->validationUser->validateUser($data, $this->user, 'PUT');

        if ($erros) {
            return response()->json(['errors' => $erros], 401);
        }

        try {

            if ($request->has('password') && $request->get('password')) {
                $data['password'] = bcrypt($data['password']);
            } else {
                unset($data['password']);
            }

            $profile = $data['profile'];
            $profile['social_networks'] = serialize($profile['social_networks']);
            $user = $this->user->findOrFail($id);
            $user->update($data);
            $user->profile->update($profile);
            return response()->json(['data' => ['msg' => 'Usuário Atualizado com Sucesso!']], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $user = $this->user->findOrFail($id);
            $user->delete($id);
            return response()->json(['data' => ['msg' => 'Usuário Removido com Sucesso!']], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}
