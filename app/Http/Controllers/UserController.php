<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Brewery;
use Inertia\Inertia;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(5);

        $query = Brewery::has('beers', '>', 0)->withCount('beers');

        // if ($search) {
        //     $query->where('name', 'like', "%$search%" );
        // }

        $breweries = $query->paginate(8);


        return Inertia::render('Users', ['users' => $users, 'breweries' => $breweries]);
    }
}
