<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {

	public function up() {
		Schema::create('user', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('surname');
			$table->string('email')->unique();
			$table->timestamp('email_verified_at')->nullable();
			$table->string('password');
			$table->rememberToken();
			$table->timestamps();
		});
	}

	public function down() {
		Schema::dropIfExists('user');
	}
}
