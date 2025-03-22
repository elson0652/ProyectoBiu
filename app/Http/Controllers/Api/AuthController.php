<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller {

	public function login(Request $request): JsonResponse {
		$user = User::where(['email' => $request->email, 'type' => 2])->first();
		if (!empty($user)) :
			if (Hash::check($request->password, $user->password)) :
				$token = JWTAuth::attempt($request->only('email', 'password'));
				return response()->json(['login' => TRUE, 'message' => "Ingreso exitoso", 'user' => $user, 'token' => $token]);
			else :
				return response()->json(['login' => FALSE, 'message' => "Su clave es incorrecta"], 422);
			endif;
		endif;
		return response()->json(['login' => FALSE, 'message' => "Su cuenta no existe"], 422);
	}

}
