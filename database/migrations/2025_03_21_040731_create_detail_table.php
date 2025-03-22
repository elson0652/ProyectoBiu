<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailTable extends Migration {

	public function up() {
		Schema::create('detail', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('shop_id');
			$table->foreign('shop_id')->references('id')->on('shop');
			$table->unsignedBigInteger('product_id');
			$table->foreign('product_id')->references('id')->on('product');
			$table->integer('count');
			$table->double('price', 12,2);
			$table->timestamps();
		});
	}

	public function down() {
		Schema::dropIfExists('detail');
	}
}
