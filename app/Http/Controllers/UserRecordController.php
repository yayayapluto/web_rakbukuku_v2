<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class UserRecordController extends Controller
{
    public function showBorrowForm(){
        return view("public.users.borrow",);
    }

    public function showReturnForm(){
        return view("public.users.return");
    }

    public function showProfile(){
        $user = Auth::user();
        return view("public.users.profile", compact("user"));
    }

    public function showHistory(){
        return view("public.users.history");
    }
}
