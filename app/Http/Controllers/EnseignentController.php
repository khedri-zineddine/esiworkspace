<?php

namespace App\Http\Controllers;

use App\Enseignent;
use App\Note;
use App\Utilisateur;
use App\Etudiant;
use App\FunctionUse;
use Illuminate\Http\Request;

class EnseignentController extends Controller
{
    
    /**
     * premetre au admin d'ajouter un enseignent
     *
     * @param  mixed $request['nom','prenom','email_ens','date_ns','date_recrt','grade']
     *
     * @return void
     */
    public function add(Request $request){
        $user=FunctionUse::isAdmin($request['email'],$request['motpass']);
        if($user){
                $userens=new Utilisateur;
                Utilisateur::insert([
                    'nom'=>$request['nom'],
                    'prenom'=>$request['prenom'],
                    'email'=>$request['email_ens'],
                    'motpass'=>sha1($request['email_ens']),
                    'type_utilisateur'=>'n'
                ]);
                $userens=Utilisateur::whereEmailAndMotpass($request['email_ens'],sha1($request['email_ens']))->get();
                Enseignent::insert([
                    'date_ns'=>$request['date_ns'],
                    'date_recrt'=>$request['date_recrt'],
                    'grade'=>$request['grade'],
                    'utilisateur_idutilisateur'=>$userens[0]->idutilisateur
                ]);
                return response([
                    'status'=>'succus',
                    'data'=>"l'ensiegnant et bien inscrire"
                ]);
            }else{
                return response([
                    'status'=>'err',
                    'data'=>'vous pouvez pas faire cette opération'
                ]);
            }
    }
    /**
     * getlist service qui premetre au enseignent d'aubtenir la list des étudinats d'un année donneret un examen  par lui pour affectuer l'affichage des notes
     * la liste se donne dans un fichier excel
     *
     * @param  mixed $request['anneafich','exam_afich']
     *
     * @return void les donner de fichier excel
     */
    public function getlist(Request $request){
        $user=FunctionUse::isEnseignent($request['email'],$request['motpass']);
        if($user && !empty($request['anneafich']) && !empty($request['exam_afich'])){
                $etudiant=Etudiant::whereAnnee($request['anneafich'])
                    ->join('utilisateur','utilisateur.idutilisateur','=','etudiant.utilisateur_idutilisateur')
                    ->get();
                $tablehtml='<table id="tbletudiant"><tbody><tr><td>email</td><td>nom</td><td>prenom</td><td>'.$request['exam_afich'].'</td></tr>';
                foreach($etudiant as $etud){
                    $tablehtml=$tablehtml.'<tr>><td>'.$etud->email.'</td><td>'.$etud->nom.'</td><td>'.$etud->prenom.'</td><td></td></tr>';
                }
                $tablehtml=$tablehtml.'</tbody></table>';
                return response([
                    'status'=>'succus',
                    'data'=>$tablehtml
                ]);
            }else{
                return response([
                    'status'=>'err',
                    'data'=>'vous pouvez pas faire cette opération'
                ]);
            }
    }
    /**
     * addnote service qui envoyer un note d'une examen (td,ci,cf) d'une module choiser pour un étudiant 
     *
     * @param  mixed $request['email_etud','idmodule','exam','note']
     *
     * @return void
     */
    public function addnote(Request $request){
        $ens=FunctionUse::isEnseignent($request['email'],$request['motpass']);
        if($ens){
            $etud=Utilisateur::whereEmail($request['email_etud'])
                ->join('etudiant','etudiant.utilisateur_idutilisateur','=','utilisateur.idutilisateur')
                ->get();
            if(isset($etud[0]->idetudiant)){
                Note::updateOrInsert([
                        'etudiant_idetudiant' =>$etud[0]->idetudiant,
                        'module_idmodule'=>$request['idmodule']
                    ],[
                        'etudiant_idetudiant'=>$etud[0]->idetudiant,
                        'module_idmodule'=>$request['idmodule'],
                        $request['exam']=>$request['note']
                    ]);
                return response([
                    'status'=>'erreur',
                    'data'=>"la note et bien envoyer a l'etudinat"
                ]); 
            }else{
                return response([
                    'status'=>'erreur',
                    'data'=>'il ya un erreur'
                ]); 
            }
        }else{
            return response([
                'status'=>'erreur',
                'data'=>'il ya un erreur'
            ]);
        }
    }
}
