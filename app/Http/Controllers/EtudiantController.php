<?php

namespace App\Http\Controllers;

use App\Etudiant;
use App\Module;
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
    public function Add(Request $request){
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
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function mesnote(Request $request)
    {
        $idetudiant=Utilisateur::whereType_utilisateurAndEmailAndMotpass('d',$request['email'],sha1($request['motpass']))
        ->join('etudiant','etudiant.utilisateur_idutilisateur','=','utilisateur.idutilisateur')
        ->get();
        $sem1=$sem2='';
        $modules=Module::where('annee','=',$idetudiant[0]->annee)
            ->get();
        foreach($modules as $module){
            $note=Note::whereEtudiant_idetudiantAndModule_idmodule($idetudiant[0]->idetudiant,$module->idmodule)
            ->get();
            $ci=$cf=$td='non affiché';
            if(count($note)>0){
                if($note[0]->cntrl_intr){
                    $ci=$note[0]->cntrl_intr;
                };
                if($note[0]->cntrl_final){
                    $cf=$note[0]->cntrl_final;
                };
                if($note[0]->td){
                    $td=$note[0]->td;
                };
                if($module->semestre=="1"){
                    $sem1=$sem1.'<tr class="_block_load">
                    <td class="_elem_load">
                        <div class="_lngtb">'.$module->nommodule.'</div>
                    </td>
                    <td class="_elem_load" colspan="2">
                        <div class="_lngtb" >'.$ci.'</div>
                    </td>
                    <td class="_elem_load" colspan="2">
                        <div class="_lngtb">'.$cf.'</div>
                    </td>
                    <td class="_elem_load">
                        <div class="_lngtb">'.$td.'</div>
                    </td>
                    <td class="_elem_load">
                        <div class="_lngtb">'.$module->coff.'</div>
                    </td>
                </tr>';
                }else if($module->semestre=="2"){
                    $sem2=$sem2.'<tr class="_block_load">
                    <td class="_elem_load">
                        <div class="_lngtb">'.$module->nommodule.'</div>
                    </td>
                    <td class="_elem_load" colspan="2">
                        <div class="_lngtb" >'.$ci.'</div>
                    </td>
                    <td class="_elem_load" colspan="2">
                        <div class="_lngtb">'.$cf.'</div>
                    </td>
                    <td class="_elem_load">
                        <div class="_lngtb">'.$td.'</div>
                    </td>
                    <td class="_elem_load">
                        <div class="_lngtb">'.$module->coff.'</div>
                    </td>
                </tr>';
                }
            }else{
                if($module->semestre=="1"){
                    $sem1=$sem1.'<tr class="_block_load">
                    <td class="_elem_load">
                        <div class="_lngtb">'.$module->nommodule.'</div>
                    </td>
                    <td class="_elem_load" colspan="2">
                        <div class="_lngtb" >'.$ci.'</div>
                    </td>
                    <td class="_elem_load" colspan="2">
                        <div class="_lngtb">'.$cf.'</div>
                    </td>
                    <td class="_elem_load">
                        <div class="_lngtb">'.$td.'</div>
                    </td>
                    <td class="_elem_load">
                        <div class="_lngtb">'.$module->coff.'</div>
                    </td>
                </tr>';
                }else if($module->semestre=="2"){
                    $sem2=$sem2.'<tr class="_block_load">
                    <td class="_elem_load">
                        <div class="_lngtb">'.$module->nommodule.'</div>
                    </td>
                    <td class="_elem_load" colspan="2">
                        <div class="_lngtb" >'.$ci.'</div>
                    </td>
                    <td class="_elem_load" colspan="2">
                        <div class="_lngtb">'.$cf.'</div>
                    </td>
                    <td class="_elem_load">
                        <div class="_lngtb">'.$td.'</div>
                    </td>
                    <td class="_elem_load">
                        <div class="_lngtb">'.$module->coff.'</div>
                    </td>
                </tr>';
                }
            }
        }
        $data=[
            '0'=>$sem1,
            '1'=>$sem2
        ];
        return response([
            'status'=>'succus',
            'data'=>$data
        ]);
    }
}