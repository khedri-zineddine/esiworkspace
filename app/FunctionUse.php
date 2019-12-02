<?php

namespace App;

use Illuminate\Http\Request;
use App\Utilisateur;

class FunctionUse
{
    public static function GetUser($email,$motpass){
        $user=new Utilisateur;
        $user=Utilisateur::whereEmailAndMotpass($email,sha1($motpass))->get();
        return $user;
    }
    public static function isAdmin($email,$motpass){
        $user=new Utilisateur;
        $user=Utilisateur::whereEmailAndMotpass($email,sha1($motpass))->get();
        if(count($user)){
            if($user[0]->type_utilisateur='a'){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    public static function isEnseignent($email,$motpass){
        $user=new Utilisateur;
        $user=Utilisateur::whereEmailAndMotpass($email,sha1($motpass))->get();
        if(count($user)){
            if($user[0]->type_utilisateur='n'){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    public static function isUser($email){
        $user=new Utilisateur;
        $user=Utilisateur::whereEmail($email)->get();
        if(count($user)>0){
            return true;
        }else{
            return false;
        }
    }
}