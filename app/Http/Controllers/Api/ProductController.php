<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller {

	public function index(): JsonResponse {
		$products = Product::all();
		return response()->json(['products' => $products]);
	}

	public function store(Request $request): JsonResponse {
		try {
			DB::beginTransaction();
			$product = new Product();
			$product->fill($request->all())->save();
			DB::commit();
			return response()->json(['message' => "Registro registrado exitosamente", 'product' => $product]);
		}catch (Exception $e) {
			DB::rollBack();
			return response()->json(['debug' => $e->getMessage(), 'message' => "Ocurrio un error en el servidor"], 422);
		}
	}

	public function show($id): JsonResponse {
		$product = Product::where(['id' => $id])->first();
		if($product):
			return response()->json(['product' => $product]);
		endif;
		return response()->json(['message' => "El producto no existe"], 422);
	}

	public function update(Request $request, $id): JsonResponse {
		$product = Product::where(['id' => $id])->first();
		if($product):
		try {
			DB::beginTransaction();
			$product->fill($request->all())->save();
			DB::commit();
			return response()->json(['message' => "Registro editado exitosamente", 'product' => $product]);
		}catch (Exception $e) {
			DB::rollBack();
			return response()->json(['debug' => $e->getMessage(), 'message' => "Ocurrio un error en el servidor"], 422);
		}
		endif;
		return response()->json(['message' => "El producto no existe"], 422);
	}

	public function delete($id): JsonResponse {
		$product = Product::where(['id' => $id])->doesntHave('details')->first();
		if($product):
			try {
				DB::beginTransaction();
				$product->delete();
				DB::commit();
				return response()->json(['message' => "Registro eliminado exitosamente", 'product' => $product]);
			}catch (Exception $e) {
				DB::rollBack();
				return response()->json(['debug' => $e->getMessage(), 'message' => "Ocurrio un error en el servidor"], 422);
			}
		endif;
		return response()->json(['message' => "El producto no existe o tiene compras"], 422);
	}

}
