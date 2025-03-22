<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model {
	use HasFactory;

	protected $table = "product";
	protected $fillable = ['name', 'code', 'price'];

	public function details(): HasMany {
		return $this->hasMany(Detail::class);
	}
}
