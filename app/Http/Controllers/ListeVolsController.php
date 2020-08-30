<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ListeVolsController extends Controller
{
    public function getListeVols(){

        $user_id= Auth::id();

        $list_vols = DB::select("SELECT V.avo_code_vol, V.avo_code_avion, concat(concat(PD.avp_nom,'-',VD.avv_nom),' => ',concat(PA.avp_nom,'-',VA.avv_nom)) AS Iteneraire,
        V.avo_date_depart, V.avo_date_arrivee, V.avo_heure_depart, V.avo_heure_arrivee, V.avo_prix_billet, case when avr_type_itineraire= 'round' then 'Round Trip' Else 'One Way' End AS Type_itn, PD.avp_nom AS pays_depart,
        VD.avv_nom AS ville_depart, VD.avv_nom_aeroport AS airport, PA.avp_nom AS pays_arrivee, VA.avv_nom AS ville_arrivee, VA.avv_nom_aeroport AS airport_dest,
        case when avr_statut_reservation= 'S' then 'VALIDË'
             when avr_statut_reservation= 'D' then 'Demande Annulation'
             when avr_statut_reservation= 'X' then 'ANNULÉ'
             ELSE 'A DETERMINER' END AS statut
        FROM av_vols V
        INNER JOIN av_pays_villes PVD ON V.avo_code_lieu_depart = PVD.apv_code_pays_ville
        INNER JOIN av_pays_villes PVA ON V.avo_code_lieu_destination = PVA.apv_code_pays_ville
        INNER JOIN av_pays PD ON PVD.apv_code_pays = PD.avp_code
        INNER JOIN av_pays PA ON PVA.apv_code_pays= PA.avp_code
        INNER JOIN av_villes VD ON PVD.apv_code_ville = VD.avv_code
        INNER JOIN av_villes VA ON PVA.apv_code_ville = VA.avv_code
        INNER JOIN av_reservations ON V.avo_code_vol = avr_code_vol
        WHERE id_user= '$user_id' AND avr_statut_reservation IN ('S', 'X', 'D') AND avr_statut_paiement= 'S'
        AND avr_date_annulation is null
        ORDER BY Type_itn, avo_date_depart Asc");

        return view('operation.list_vols', compact('list_vols'));
    }

    public function postCancel(Request $request){
        $code_vol = $request->input('code_vol');
        $pays_depart = $request->input('pays_depart');
        $ville_depart = $request->input('ville_depart');
        $pays_arrivee = $request->input('pays_arrivee');
        $ville_arrivee = $request->input('ville_arrivee');
        $date_depart = $request->input('date_depart');
        $date_arrivee = $request->input('date_arrivee');
        $heure_depart = $request->input('heure_depart');
        $heure_arrivee = $request->input('heure_arrivee');
        $prix_billet = $request->input('prix_billet');
        $airport = $request->input('airport');
        $airport_dest = $request->input('airport_dest');
        $type_trip = $request->input('type_itn');
        $user_id= Auth::id();

        if ($type_trip=="Round Trip"){

            $infos_first_vol = DB::table('av_vols')
                ->Where([
                    ['avo_code_vol', '=', $code_vol]
                ])
                ->first();

            $code_lieu_depart= $infos_first_vol->avo_code_lieu_depart;
            $code_lieu_arrive= $infos_first_vol->avo_code_lieu_destination;

            $infos_second_vol = DB::table('av_vols')
                ->Where([
                    ['avo_code_lieu_depart', '=', $code_lieu_arrive],
                    ['avo_code_lieu_destination', '=', $code_lieu_depart],
                    ['avo_date_depart', '=', session()->get('return_session')]
                ])
                ->first();

            $code_vol_round= $infos_second_vol->avo_code_vol;

            DB::table('av_reservations')
            ->Where([['id_user', '=', $user_id], ['avr_code_vol', '=', $code_vol]])
            ->update(['avr_statut_reservation' => 'D']);

            DB::table('av_reservations')
                ->Where([['id_user', '=', $user_id], ['avr_code_vol', '=', $code_vol_round]])
                ->update(['avr_statut_reservation' => 'D']);

            return redirect()->back()->with('message', 'Cancel request has been sent, please verify in a few moment.');

        }else{

            DB::table('av_reservations')
                ->Where([['id_user', '=', $user_id], ['avr_code_vol', '=', $code_vol]])
                ->update(['avr_statut_reservation' => 'D']);

            return redirect()->back()->with('message', 'Cancel request has been sent, please verify in a few moment.');

        }

    }
}
