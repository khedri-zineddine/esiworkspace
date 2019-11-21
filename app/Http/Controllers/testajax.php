<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class testajax extends Controller
{
    public function test(Request $request){
            return response([
                'status'=>'success',
                'data'=> $request['email']
            ],200);
        
    }
}
