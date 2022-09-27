<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Brewery
 * 
 * @property int $id
 * @property string $name
 * @property string $address1
 * @property string $address2
 * @property string $city
 * @property string $state
 * @property string $code
 * @property string $country
 * @property string $phone
 * @property string $website
 * @property string $filepath
 * @property string $descript
 * @property int $add_user
 * @property Carbon $last_mod
 * 
 * @property Collection|Beer[] $beers
 *
 * @package App\Models
 */
class Brewery extends Model
{
	protected $table = 'breweries';
	public $timestamps = false;

	protected $casts = [
		'add_user' => 'int'
	];

	protected $dates = [
		'last_mod'
	];

	protected $fillable = [
		'name',
		'address1',
		'address2',
		'city',
		'state',
		'code',
		'country',
		'phone',
		'website',
		'filepath',
		'descript',
		'add_user',
		'last_mod'
	];

	public function beers()
	{
		return $this->hasMany(Beer::class);
	}
}
