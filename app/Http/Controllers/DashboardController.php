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
                ->when(request()->filled('search'),function(Builder $q){
                    return $q->where(function (Builder $q){
                        return $q->where('name', 'like', '%'. request()->search .'%')
                            ->orWhere('email', 'like', '%'. request()->search .'%');
                    });
                })
                ->get()
        ]);
    }
}
