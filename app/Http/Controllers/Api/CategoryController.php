<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Model\Category;
use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\Controller;
use App\Validations\ValidationCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
	 * @var Category
	 */
	private $category;
    private $validationCategory;

	public function __construct(Category $category, ValidationCategory $validationCategory)
	{
		$this->category = $category;
        $this->validationCategory = $validationCategory;
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$category = $this->category->paginate('10');
		return response()->json($category, 200);
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

        $erros = $this->validationCategory->validateCategory($data, $this->category);

        if ($erros) {
            return response()->json(['errors' => $erros], 401);
        }

		try{

			$category = $this->category->create($data);
			return response()->json([
				'data' => [
					'msg' => 'Categoria Cadastrada com Sucesso!'
				]
			], 200);

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
		try{

			$category = $this->category->findOrFail($id);
			return response()->json([
				'data' => $category
			], 200);

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

        $erros = $this->validationCategory->validateCategory($data, $this->category, 'PUT');

        if ($erros) {
            return response()->json(['errors' => $erros], 401);
        }

		try{

			$category = $this->category->findOrFail($id);
			$category->update($data);
			return response()->json([
				'data' => [
					'msg' => 'Categoria atualizada com sucesso!'
				]
			], 200);

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
        $erros = $this->validationCategory->validateIdCategory($id, $this->category);

        if ($erros) {
            return response()->json(['errors' => $erros], 401);
        }

		try{

			$category = $this->category->findOrFail($id);
			$category->delete();
			return response()->json([
				'data' => [
					'msg' => 'Categoria Removida com Sucesso!'
				]
			], 200);

		} catch (\Exception $e) {
			$message = new ApiMessages($e->getMessage());
			return response()->json($message->getMessage(), 401);
		}
    }

    public function realStates($id)
    {
        try{
			$category = $this->category->findOrFail($id);
			return response()->json(['data' => $category->realStates], 200);
		} catch (\Exception $e) {
			$message = new ApiMessages($e->getMessage());
			return response()->json($message->getMessage(), 401);
		}
    }
}
