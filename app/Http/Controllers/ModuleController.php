<?php

namespace App\Http\Controllers;

use App\Module;
use App\FunctionUse;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request){
        $user=FunctionUse::isAdmin($request['email'],$request['motpass']);
        if($user){
            Module::insert([
                'nommodule'=>$request['nommodule'],
                'coff'=>$request['coff'],
                'annee'=>$request['annee'],
                'semestre'=>$request['semestre']
            ]);
            return response([
                'status'=>'succus',
                'data'=>'le module et bien creer'
            ]);
        }else{
            return response([
                'status'=>'erreur',
                'data'=>'vous avez pas le droir pour faire cette operation'
            ]);
        }
    }
    public function getmodule(Request $request){
        $modules=Module::all();
        $result='';
        foreach($modules as $module){
            $result=$result.'<option value="'.$module->idmodule.'">'.$module->nommodule.'</option>';
        }
        return response([
            'status'=>'succus',
            'data'=>$result
        ]);
    }
}
