<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BreweriesGeocode
 * 
 * @property int $id
 * @property float $latitude
 * @property float $longitude
 * @property string $accuracy
 * @property int $brewery_id
 *
 * @package App\Models
 */
class BreweriesGeocode extends Model
{
	protected $table = 'breweries_geocode';
	public $timestamps = false;

	protected $casts = [
		'latitude' => 'float',
		'longitude' => 'float',
		'brewery_id' => 'int'
	];

	protected $fillable = [
		'latitude',
		'longitude',
		'accuracy'
	];
}
