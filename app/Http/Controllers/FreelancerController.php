<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;

class FreelancerController extends Controller
{
    public function getFreelancers()
    {
        $freelancers = User::with('profiles')->where('is_admin', 0)->WhereHas('profiles', function ($q) {
            $q->where('freelancer', 1);
        })->paginate(9);
        return view('user.freelancers',compact('freelancers'));
    }
}
