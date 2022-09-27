<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * 
 * @property int $id
 * @property string $cat_name
 * @property Carbon $last_mod
 * 
 * @property Collection|Style[] $styles
 *
 * @package App\Models
 */
class Category extends Model
{
	protected $table = 'categories';
	public $timestamps = false;

	protected $dates = [
		'last_mod'
	];

	protected $fillable = [
		'cat_name',
		'last_mod'
	];

	public function styles()
	{
		return $this->hasMany(Style::class);
	}
}
