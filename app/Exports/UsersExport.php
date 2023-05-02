<?php

namespace App\Exports;

use App\Models\User;
use Auth;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UsersExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view():view
    {
        $data['users'] = [];
        if (Auth::user()->role_id == 1) {
            $data['users'] =  User::whereNotIn('role_id',[1,2])->get();
        }
        return view('Backend.User.user-list', $data);
    }
}
