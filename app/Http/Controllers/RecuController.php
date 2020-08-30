<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class RecuController extends Controller
{
    public function getRecu(){

        $id_user = Auth::id();
        $code_vol_session = session()->get('code_vol_session');
        $code_vol_session_round = session()->get('code_vol_session_round');
        $trip_session = session()->get('trip_session');

        if ($trip_session == 'one_way'){
            $recu = DB::select("SELECT name, last_name, avr_code_reservation, concat(concat(PD.avp_nom,'-',VD.avv_nom),' => ',concat(PA.avp_nom,'-',VA.avv_nom)) AS Iteneraire, V.avo_date_depart,
            V.avo_heure_depart, V.avo_heure_arrivee, V.avo_code_vol, avr_code_paiement, avpa_montant_paiement, V.avo_prix_billet, avc_nom
            FROM av_reservations
            INNER JOIN av_vols V ON avr_code_vol = V.avo_code_vol
            INNER JOIN av_paiements ON avr_code_paiement = avpa_code_paiement
            INNER JOIN users ON id_user = id
            INNER JOIN av_avions ON V.avo_code_avion = ava_code_avion
            INNER JOIN av_compagnies ON ava_code_compagnie = avc_code
            INNER JOIN av_pays_villes PVD ON V.avo_code_lieu_depart = PVD.apv_code_pays_ville
            INNER JOIN av_pays_villes PVA ON V.avo_code_lieu_destination = PVA.apv_code_pays_ville
            INNER JOIN av_pays PD ON PVD.apv_code_pays = PD.avp_code
            INNER JOIN av_pays PA ON PVA.apv_code_pays= PA.avp_code
            INNER JOIN av_villes VD ON PVD.apv_code_ville = VD.avv_code
            INNER JOIN av_villes VA ON PVA.apv_code_ville = VA.avv_code
            WHERE id_user= '$id_user' AND avo_code_vol IN ('$code_vol_session')
            ORDER BY V.avo_date_depart");

            return view('operation.recu', compact('recu'));
        }else{
            $recu = DB::select("SELECT name, last_name, avr_code_reservation, concat(concat(PD.avp_nom,'-',VD.avv_nom),' => ',concat(PA.avp_nom,'-',VA.avv_nom)) AS Iteneraire, V.avo_date_depart,
            V.avo_heure_depart, V.avo_heure_arrivee, V.avo_code_vol, avr_code_paiement, avpa_montant_paiement, V.avo_prix_billet, avc_nom
            FROM av_reservations
            INNER JOIN av_vols V ON avr_code_vol = V.avo_code_vol
            INNER JOIN av_paiements ON avr_code_paiement = avpa_code_paiement
            INNER JOIN users ON id_user = id
            INNER JOIN av_avions ON V.avo_code_avion = ava_code_avion
            INNER JOIN av_compagnies ON ava_code_compagnie = avc_code
            INNER JOIN av_pays_villes PVD ON V.avo_code_lieu_depart = PVD.apv_code_pays_ville
            INNER JOIN av_pays_villes PVA ON V.avo_code_lieu_destination = PVA.apv_code_pays_ville
            INNER JOIN av_pays PD ON PVD.apv_code_pays = PD.avp_code
            INNER JOIN av_pays PA ON PVA.apv_code_pays= PA.avp_code
            INNER JOIN av_villes VD ON PVD.apv_code_ville = VD.avv_code
            INNER JOIN av_villes VA ON PVA.apv_code_ville = VA.avv_code
            WHERE id_user= '$id_user' AND avo_code_vol IN ('$code_vol_session')
            ORDER BY V.avo_date_depart");

            $recu_retour = DB::select("SELECT name, last_name, avr_code_reservation, concat(concat(PD.avp_nom,'-',VD.avv_nom),' => ',concat(PA.avp_nom,'-',VA.avv_nom)) AS Iteneraire, V.avo_date_depart,
            V.avo_heure_depart, V.avo_heure_arrivee, V.avo_code_vol, avr_code_paiement, avpa_montant_paiement, V.avo_prix_billet, avc_nom
            FROM av_reservations
            INNER JOIN av_vols V ON avr_code_vol = V.avo_code_vol
            INNER JOIN av_paiements ON avr_code_paiement = avpa_code_paiement
            INNER JOIN users ON id_user = id
            INNER JOIN av_avions ON V.avo_code_avion = ava_code_avion
            INNER JOIN av_compagnies ON ava_code_compagnie = avc_code
            INNER JOIN av_pays_villes PVD ON V.avo_code_lieu_depart = PVD.apv_code_pays_ville
            INNER JOIN av_pays_villes PVA ON V.avo_code_lieu_destination = PVA.apv_code_pays_ville
            INNER JOIN av_pays PD ON PVD.apv_code_pays = PD.avp_code
            INNER JOIN av_pays PA ON PVA.apv_code_pays= PA.avp_code
            INNER JOIN av_villes VD ON PVD.apv_code_ville = VD.avv_code
            INNER JOIN av_villes VA ON PVA.apv_code_ville = VA.avv_code
            WHERE id_user= '$id_user' AND avo_code_vol IN ('$code_vol_session_round')
            ORDER BY V.avo_date_depart");

            return view('operation.recu', compact('recu'), compact('recu_retour'));
        }
    }
}
