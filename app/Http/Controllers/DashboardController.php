<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function __invoke(Request $request)
    {
        return view('dashboard',[
            'users' => User::query()
                ->where('admin', '=', false)
                ->search(request()->search)
                ->get()
        ]);
    }
}
