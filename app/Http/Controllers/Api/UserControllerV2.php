<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\Usergetfirstv2Resource;
use App\Http\Resources\Userwithpostv2Resource;
use App\Http\Resources\Userallnamev2Resource;
use App\Http\Resources\Usersallemailv2Resource;

class UserControllerV2 extends Controller
{
    //Advanced concepts of API With Resource to provide a structured way to transform data in API responses ( v2 )

    //get singular data
    public function getfirstuser(Request $request){
        $user = User::first();
        return new Usergetfirstv2Resource($user);
    }

    //Show all users with related posts
    public function getalluserswithpostcollection(Request $request){
        $users = User::all();
        return Userwithpostv2Resource::collection($users);
    }

    //Get all name of the users but the request is permitted only 3 times
    public function getallnamesofusersratelimiting(Request $request){
        $users = User::all();
        return Userallnamev2Resource::collection($users);
    }

    //Get all emails of the users but the request is permitted only 5 times
    public function getallusersemailsratelimiting(Request $request){
        $users = User::all();
        return Usersallemailv2Resource::collection($users);
    }
}
