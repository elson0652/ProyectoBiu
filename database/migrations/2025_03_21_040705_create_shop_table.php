<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopTable extends Migration {

	public function up() {
		Schema::create('shop', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('user_id');
			$table->foreign('user_id')->references('id')->on('user');
			$table->string('code')->unique();
			$table->double('price', 12,2);
			$table->timestamps();
		});
	}

	public function down() {
		Schema::dropIfExists('shop');
	}
}
