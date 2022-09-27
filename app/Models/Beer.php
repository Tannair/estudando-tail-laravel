<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Beer
 * 
 * @property int $id
 * @property string $name
 * @property float $abv
 * @property float $ibu
 * @property float $srm
 * @property int $upc
 * @property string $filepath
 * @property string $descript
 * @property int $add_user
 * @property Carbon $last_mod
 * @property int $category_id
 * @property int $style_id
 * @property int $brewery_id
 * 
 * @property Brewery $brewery
 *
 * @package App\Models
 */
class Beer extends Model
{
	protected $table = 'beers';
	public $timestamps = false;

	protected $casts = [
		'abv' => 'float',
		'ibu' => 'float',
		'srm' => 'float',
		'upc' => 'int',
		'add_user' => 'int',
		'category_id' => 'int',
		'style_id' => 'int',
		'brewery_id' => 'int'
	];

	protected $dates = [
		'last_mod'
	];

	protected $fillable = [
		'name',
		'abv',
		'ibu',
		'srm',
		'upc',
		'filepath',
		'descript',
		'add_user',
		'last_mod',
		'category_id',
		'style_id',
		'brewery_id'
	];

	public function brewery()
	{
		return $this->belongsTo(Brewery::class);
	}
}
