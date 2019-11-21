<?php

namespace App\Http\Controllers;

use App\Etudiant;
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
        $user=FunctionUse::GetUser($request['email'],$request['motpass']);
        if(count($user)>0){
            if($user[0]->type_utilisateur=='a'){
                $useretud=new Utilisateur;
                Utilisateur::insert([
                    'nom'=>$request['nom'],
                    'prenom'=>$request['prenom'],
                    'email'=>$request['email_etud'],
                    'motpass'=>sha1($request['motpass']),
                    'type_utilisateur'=>'d'
                ]);
                $useretud=Utilisateur::whereEmailAndMotpass($request['email_etud'],sha1($request['motpass']))->get();
                Etudiant::insert([
                    'date_ns'=>$request['date_ns'],
                    'lieu_ns'=>$request['lieu_ns'],
                    'groupe'=>$request['group'],
                    'annee'=>$request['anne'],
                    'section'=>$request['sec'],
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
        }else{
            return response([
                'status'=>'err',
                'data'=>'vous pouvez pas faire cette opération'
            ]);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
     if(FunctionUse::isAdmin($request['email'],$request['motpass'])){
        $user=Utilisateur::whereType_utilisateur('d')
            ->join('etudiant','etudiant.utilisateur_idutilisateur','utilisateur.idutilisateur')
            ->get();
         
     }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Etudiant  $etudiant
     * @return \Illuminate\Http\Response
     */
    public function edit(Etudiant $etudiant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Etudiant  $etudiant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Etudiant $etudiant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Etudiant  $etudiant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Etudiant $etudiant)
    {
        //
    }
}
