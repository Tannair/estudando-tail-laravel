<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;

    protected $table = 'stages';
	public $timestamps = false;

	protected $fillable = [
        'stage',
		'description',
		'created_at'
	];

	public function tasks()
	{
		return $this->hasMany(Task::class);
	}
}
