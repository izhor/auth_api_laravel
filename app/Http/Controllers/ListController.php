<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListController extends Controller
{
    public function userlist(){
        //getting user with pagination
        $userList = DB::table('users')->paginate(15);

        //declaring an array variable
        $arrayList = [];

        //looping array as it pushes the value into an array list
        foreach ($userList as $list) {
            array_push($arrayList,array(
                'id' => $list->id,
                'username' => $list->username,
                'created_at' => $list->created_at,
                'updated_at' => $list->updated_at
            ));
        }
        return response()->json(Controller::apiResponse(200,$arrayList),200);
    }
}
