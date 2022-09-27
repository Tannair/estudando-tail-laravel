<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Style
 * 
 * @property int $id
 * @property string $style_name
 * @property Carbon $last_mod
 * @property int $category_id
 * 
 * @property Category $category
 *
 * @package App\Models
 */
class Style extends Model
{
	protected $table = 'styles';
	public $timestamps = false;

	protected $casts = [
		'category_id' => 'int'
	];

	protected $dates = [
		'last_mod'
	];

	protected $fillable = [
		'style_name',
		'last_mod',
		'category_id'
	];

	public function category()
	{
		return $this->belongsTo(Category::class);
	}
}
