<?php

namespace App\Http\Controllers;

use App\Etudiant;
use App\Note;
use App\Utilisateur;
use App\FunctionUse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EtudiantController extends Controller
{
    /**
     * creating a new etudiant.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function Add(Request $request)
    {
        $user=FunctionUse::isAdmin($request['email'],$request['motpass']);
        if($user){
                $useretud=new Utilisateur;
                Utilisateur::insert([
                    'nom'=>$request['nom'],
                    'prenom'=>$request['prenom'],
                    'email'=>$request['email_etud'],
                    'motpass'=>sha1($request['email_etud']),
                    'type_utilisateur'=>'d'
                ]);
                $useretud=Utilisateur::whereEmailAndMotpass($request['email_etud'],sha1($request['email_etud']))->get();
                Etudiant::insert([
                    'date_ns'=>$request['date_ns'],
                    'lieu_ns'=>$request['lieu_ns'],
                    'groupe'=>$request['groupe'],
                    'annee'=>$request['annee'],
                    'section'=>$request['section'],
                    'utilisateur_idutilisateur'=>$useretud[0]->idutilisateur
                ]);
                return response([
                    'status'=>'succus',
                    'data'=>"l'etudiant et bien inscrire"
                ]);
        }else{
            return response([
                'status'=>'err',
                'data'=>'vous pouvez pas faire cette opération'
            ]);
        }
        
    }
    /**
     * GetIdetudiant
     *
     * @param  mixed $email
     * @param  mixed $motpass
     *
     * @return void
     */
    public function GetIdetudiant($email,$motpass){
        $id=Utilisateur::whereType_utilisateurAndEmailAndMotpass('d',$email,$motpass)
            ->join('etudiant','etudiant.utilisateur_idutilisateur','=','utilisateur.idutilisateur')
            ->get();
        return $id[0];
    }
    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function mesnote(Request $request)
    {
        $idetudiant=GetIdetudiant($request['email'],$request['motpass']);
        $note=Note::whereEtudiant_idetudiant($idetudiant->idetudiant)
            ->join('module','note.module_idmodule','=','module.idmodule')
            ->where('module.annee','=',$idetudiant->annee)
            ->get();
        if(count($note)>0){
            return response([
                'status'=>'succus',
                'data'=>$note[0]
            ]);
        }else{
            return response([
                'status'=>'erreur',
                'data'=>null
            ]);
        }
    }
}
