<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\SpecificKeysUserResource;
use App\Http\Resources\PreserveKeysUserResource;
use App\Http\Resources\UserwithpostResource;
use App\Http\Resources\UserdatawrappingResource;
use App\Http\Resources\UserdatawrappingResourceCollection;

class UserControllerV1 extends Controller
{
    //Advanced API Creation With Resource to provide a structured way to transform data in API responses for ( v1 )

    //get singular data
    public function getfirstuser(Request $request){
        $user = User::first();
        return new UserResource($user);
    }

    //Get all collection of data
    public function getalluserscollection(Request $request){
        $user = User::all();
        return UserResource::collection($user);
    }

    //using specific keys for all data
    public function getalluserscollectionwithspecifickeys(Request $request){
        $user = User::all();
        return $user->keyBy->id;
        return SpecificKeysUserResource::collection($user);  
    }
        
    //preserve keys or keep em inside the data
    public function getalluserscollectionpreservingkeys(Request $request){
        $user = User::all()->keyBy->id;
        return PreserveKeysUserResource::collection($user);
    }

    //showing users with relation of posts
    public function getalluserswithpostcollection(Request $request){
        $user = User::all();
        return UserwithpostResource::collection($user);
    }
    
    //Data wrapping to standardize the structure of API responses.

    //Go to UserResource and then add => public static $wrap = 'users'; 
    //This converts Data into User as the key to wrap the response.
    //Showing users with relation of posts using data wrapping
    public function getalluserswithpostcollectiondatawrapping(Request $request){
        $user = User::all();
        return new UserdatawrappingResourceCollection($user);
    }

    //Without any data wrapping 
    //Go to the appserviceprovider and then add => JsonResource::withoutWrapping() in the boot
}
