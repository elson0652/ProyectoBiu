<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Detail;
use App\Models\Product;
use App\Models\Shop;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller {

	public function store(Request $request): JsonResponse {
		try {
			DB::beginTransaction();
			$shop = new Shop();
			$shop->fill(array_merge(['code' => (microtime(TRUE) * 10000), 'price' => 0], $request->all()))->save();
			$price = 0;
			$details = [];
			foreach ($request->products as $key => $value) :
				$product = Product::find($value);
				$count = $request->count[$key];
				$mount = $count * $product->price;
				$price += $mount;
				$detail = new Detail();
				$detail->fill(['shop_id' => $shop->id, 'product_id' => $product->id, 'count' => $count, 'price' => $mount])->save();
				$details[] = $detail;
			endforeach;
			$shop->fill(['price' => $price])->save();
			$shop->details = $details;
			DB::commit();
			return response()->json(['message' => "Registro ingresado exitosamente", 'shop' => $shop]);
		} catch (Exception $e) {
			DB::rollBack();
			return response()->json(['debug' => $e->getMessage(), 'message' => "Ocurrio un error en el servidor"], 422);
		}
	}

}
