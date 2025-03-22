<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller {

	public function index(): JsonResponse {
		$users = User::all();
		return response()->json(['users' => $users]);
	}

	public function store(Request $request): JsonResponse {
		try {
			DB::beginTransaction();
			$user = new User();
			$user->fill(array_merge($request->all(),['password' => bcrypt($request->password)]))->save();
			DB::commit();
			return response()->json(['message' => "Registro registrado exitosamente", 'user' => $user]);
		}catch (Exception $e) {
			DB::rollBack();
			return response()->json(['debug' => $e->getMessage(), 'message' => "Ocurrio un error en el servidor"], 422);
		}
	}

	public function show($id): JsonResponse {
		$user = User::where(['id' => $id])->first();
		if($user):
			return response()->json(['user' => $user]);
		endif;
		return response()->json(['message' => "El usuario no existe"], 422);
	}

	public function update(Request $request, $id): JsonResponse {
		$user = User::where(['id' => $id])->first();
		if($user):
			try {
				DB::beginTransaction();
				$password = $user->password;
				if(!empty($request->password)):
					$password = bcrypt($request->password);
				endif;
				$user->fill(array_merge($request->all(),['password' => $password]))->save();
				DB::commit();
				return response()->json(['message' => "Registro editado exitosamente", 'user' => $user]);
			}catch (Exception $e) {
				DB::rollBack();
				return response()->json(['debug' => $e->getMessage(), 'message' => "Ocurrio un error en el servidor"], 422);
			}
		endif;
		return response()->json(['message' => "El usuario no existe"], 422);
	}

	public function delete($id): JsonResponse {
		$user = User::where(['id' => $id])->first();
		if($user):
			try {
				DB::beginTransaction();
				$user->delete();
				DB::commit();
				return response()->json(['message' => "Registro eliminado exitosamente", 'user' => $user]);
			}catch (Exception $e) {
				DB::rollBack();
				return response()->json(['debug' => $e->getMessage(), 'message' => "Ocurrio un error en el servidor"], 422);
			}
		endif;
		return response()->json(['message' => "El usuario no existe"], 422);
	}

}
