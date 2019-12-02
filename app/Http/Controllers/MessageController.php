<?php

namespace App\Http\Controllers;

use App\Message;
use App\Filemsg;
use App\FunctionUse;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    
    /**
     * movfile:
     * service permetre au utilisateur de transferer un fichier pour l'envoyer dans un mail
     *
     * @param  mixed $request['file']
     *
     * @return void
     */
    public function movfile(Request $request){
        $infoFile=pathinfo($_FILES["addimage"]["name"]);
        $extention=strtolower(substr(strrchr($_FILES['addimage']['name'],'.'),1));
            $path='C:\wamp\www\esi-space@IGL\esi-space\public\filemsg/'.sha1($_FILES["addimage"]["name"].$_FILES["addimage"]["size"]).'.'.$extention;
            move_uploaded_file($_FILES['addimage']['tmp_name'],$path);
        $dataimg=[
            'name_img'=>$_FILES["addimage"]["name"],
            'chemain'=>"/filemsg/".sha1($_FILES["addimage"]["name"].$_FILES["addimage"]["size"]).'.'.$extention
        ];
        return response([
            'status'=>'succus',
            'data'=>$dataimg
        ]);
    }

    /**
     * sentmsg:
     * service d'envoyer des email pour tout les utilisateur
     *
     * @param  mixed $request['to','sent','msg','lstfl']
     *
     * @return void
     */
    public function sentmsg(Request $request){
        $user=FunctionUse::isUser($request['to']);
        if($user && ($request['to'] != $request['sent'])){
            Message::insert([
                'util_envoyer'=>$request['sent'],
                'util_recevoir'=>$request['to'],
                'text'=>$request['msg']
            ]);
            if(count($request['lstfl'])>0){
                $idmsg=Message::all()->last()->idmessage;
                foreach($request['lstfl'] as $file){
                    Filemsg::insert([
                        'chemain'=>$file[0],
                        'name_file'=>$file[1],
                        'message_idmessage'=>$idmsg
                    ]);
                }
            }
            return response([
                'status'=>'succus',
                'data'=>'votre message et bien envoyer'
            ]);
        }else{
            return response([
                'status'=>'erreur',
                'data'=>"vous pouver envoyer des message que a des utilisateur de l'ecole"
            ]); 
        }
    }

    /**
     * inbox:
     * service permetre de recupérer les email recevoir pour un utilisateur
     *
     * @param  mixed $request['email','motpass']
     *
     * @return void
     */
    public function inbox(Request $request){
        $user=FunctionUse::GetUser($request['email'],$request['motpass']);
        if(count($user)>0){
            $msg=Message::whereUtil_recevoir($request['email'])
            ->join('utilisateur','utilisateur.email','=','message.util_envoyer')
            ->get();
            return response([
                'status'=>'succes',
                'data'=>[
                    'msg'=>$msg,
                    'nb'=>count($msg)
                ]
            ]);
        }
    }
    /**
     * sent:
     * service permetre de recupérer les email envoyer par un utilisateur
     *
     * @param  mixed $request['email','motpass']
     *
     * @return void
     */
    public function sent(Request $request){
        $user=FunctionUse::GetUser($request['email'],$request['motpass']);
        if(count($user)>0){
            $msg=Message::whereUtil_envoyer($request['email'])
            ->join('utilisateur','utilisateur.email','=','message.util_recevoir')
            ->get();
            return response([
                'status'=>'succes',
                'data'=>[
                    'msg'=>$msg,
                    'nb'=>count($msg)
                ]
            ]);
        }
    }
    /**
     * slctmsg:
     * service pour selectioner les information d'une message
     *
     * @param  mixed $request
     *
     * @return void
     */
    public function slctmsg(Request $request){
        $msg=Message::whereIdmessage($request['idmsg'])
        ->join('utilisateur','utilisateur.email','=','message.util_envoyer')
        ->get();
        $filmsg=Filemsg::whereMessage_idmessage($msg[0]->idmessage)->get();
        return response([
            'status'=>'succus',
            'data'=>[
                'msg'=>$msg,
                'filemsg'=>$filmsg
            ]
        ]);
    }
}
