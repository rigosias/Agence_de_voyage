<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class VolsController extends Controller
{
    public function getVols(Request $request){

        $ville_from= $request->session()->get('ville_from_session');
        $ville_to= $request->session()->get('ville_to_session');
        $departure= $request->session()->get('departure_session');
        $return= $request->session()->get('return_session');
        $trip_type= $request->session()->get('trip_session');

        if ($trip_type == "one_way") {
            $vols = DB::select("SELECT V.avo_code_vol, V.avo_code_avion, concat(concat(PD.avp_nom,'-',VD.avv_nom),' => ',concat(PA.avp_nom,'-',VA.avv_nom)) AS Iteneraire, V.avo_date_depart, V.avo_date_arrivee, V.avo_heure_depart, V.avo_heure_arrivee, V.avo_prix_billet, 'One Way' AS Type_itn,
            PD.avp_nom AS pays_depart, VD.avv_nom AS ville_depart, VD.avv_nom_aeroport AS airport, PA.avp_nom AS pays_arrivee, VA.avv_nom AS ville_arrivee, VA.avv_nom_aeroport AS airport_dest
            FROM av_vols V
            INNER JOIN av_pays_villes PVD ON V.avo_code_lieu_depart = PVD.apv_code_pays_ville
            INNER JOIN av_pays_villes PVA ON V.avo_code_lieu_destination = PVA.apv_code_pays_ville
            INNER JOIN av_pays PD ON PVD.apv_code_pays = PD.avp_code
            INNER JOIN av_pays PA ON PVA.apv_code_pays= PA.avp_code
            INNER JOIN av_villes VD ON PVD.apv_code_ville = VD.avv_code
            INNER JOIN av_villes VA ON PVA.apv_code_ville = VA.avv_code
            WHERE PVD.apv_code_pays_ville= '$ville_from' AND PVA.apv_code_pays_ville= '$ville_to' AND
            V.avo_date_depart= '$departure'");

            return view('operation.vols', compact('vols'));
        }else{
            $vols = DB::select("SELECT V.avo_code_vol, V.avo_code_avion, concat(concat(PD.avp_nom,'-',VD.avv_nom),' => ',concat(PA.avp_nom,'-',VA.avv_nom)) AS Iteneraire,
                    V.avo_date_depart, V.avo_date_arrivee, V.avo_heure_depart, V.avo_heure_arrivee, V.avo_prix_billet, 'Round Trip' AS Type_itn, PD.avp_nom AS pays_depart,
                    VD.avv_nom AS ville_depart, VD.avv_nom_aeroport AS airport, PA.avp_nom AS pays_arrivee, VA.avv_nom AS ville_arrivee, VA.avv_nom_aeroport AS airport_dest
                    FROM av_vols V
                    INNER JOIN av_pays_villes PVD ON V.avo_code_lieu_depart = PVD.apv_code_pays_ville
                    INNER JOIN av_pays_villes PVA ON V.avo_code_lieu_destination = PVA.apv_code_pays_ville
                    INNER JOIN av_pays PD ON PVD.apv_code_pays = PD.avp_code
                    INNER JOIN av_pays PA ON PVA.apv_code_pays= PA.avp_code
                    INNER JOIN av_villes VD ON PVD.apv_code_ville = VD.avv_code
                    INNER JOIN av_villes VA ON PVA.apv_code_ville = VA.avv_code
                    WHERE PVD.apv_code_pays_ville= '$ville_from' AND PVA.apv_code_pays_ville= '$ville_to' AND
                    V.avo_date_depart= '$departure'
                    union all
                    SELECT V.avo_code_vol, V.avo_code_avion, concat(concat(PD.avp_nom,'-',VD.avv_nom),' => ',concat(PA.avp_nom,'-',VA.avv_nom)) AS Iteneraire,
                    V.avo_date_depart, V.avo_date_arrivee, V.avo_heure_depart, V.avo_heure_arrivee, V.avo_prix_billet, 'Round Trip' AS Type_itn, PD.avp_nom AS pays_depart,
                    VD.avv_nom AS ville_depart, VD.avv_nom_aeroport AS airport, PA.avp_nom AS pays_arrivee, VA.avv_nom AS ville_arrivee, VA.avv_nom_aeroport AS airport_dest
                    FROM av_vols V
                    INNER JOIN av_pays_villes PVD ON V.avo_code_lieu_depart = PVD.apv_code_pays_ville
                    INNER JOIN av_pays_villes PVA ON V.avo_code_lieu_destination = PVA.apv_code_pays_ville
                    INNER JOIN av_pays PD ON PVD.apv_code_pays = PD.avp_code
                    INNER JOIN av_pays PA ON PVA.apv_code_pays= PA.avp_code
                    INNER JOIN av_villes VD ON PVD.apv_code_ville = VD.avv_code
                    INNER JOIN av_villes VA ON PVA.apv_code_ville = VA.avv_code
                    WHERE PVD.apv_code_pays_ville= '$ville_to' AND PVA.apv_code_pays_ville= '$ville_from' AND
                    V.avo_date_depart= '$return'");

            return view('operation.vols', compact('vols'));
        }
    }


    public function postVols(Request $request){
        if (Auth::check()) {
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

            if ($type_trip == "Round Trip"){
                $request->session()->put('prix_billet_session', $prix_billet*2);
                $request->session()->put('code_vol_session', $code_vol);

                $code_vol_round = DB::table('av_vols')
                                ->Where([
                                        ['avo_code_lieu_depart', '=', session()->get('ville_to_session')],
                                        ['avo_code_lieu_destination', '=', session()->get('ville_from_session')],
                                        ['avo_date_depart', '=', session()->get('return_session')]
                                ])
                                ->first();

                $code_vol= $code_vol_round->avo_code_vol;
                $request->session()->put('code_vol_session_round', $code_vol);
            }else{
                $request->session()->put('prix_billet_session', $prix_billet);
                $request->session()->put('code_vol_session', $code_vol);
            }

            $vols = DB::select("SELECT '$pays_depart' AS pays_depart, '$ville_depart' AS ville_depart, '$pays_arrivee' AS pays_arrivee,
            '$ville_arrivee' AS ville_arrivee, '$date_depart' AS date_depart, '$date_arrivee' AS date_arrivee, '$heure_depart' AS heure_depart,
            '$heure_arrivee' AS heure_arrivee, '$prix_billet' AS prix_billet, '$airport' AS airport, '$airport_dest' AS airport_dest, '$type_trip' AS Type_itn
            FROM AV_VOLS ORDER BY avo_code_vol ASC LIMIT 1");

            if ($type_trip == "Round Trip") {
                $ville_from = $request->session()->get('ville_from_session');
                $ville_to = $request->session()->get('ville_to_session');
                $return = $request->session()->get('return_session');
                $trip_type_session= $request->session()->get('trip_session');

                $vol_retour = DB::select("SELECT V.avo_code_vol, V.avo_code_avion, concat(concat(PD.avp_nom,'-',VD.avv_nom),' => ',concat(PA.avp_nom,'-',VA.avv_nom)) AS Iteneraire, V.avo_date_depart AS date_depart, V.avo_date_arrivee AS date_arrivee, V.avo_heure_depart AS heure_depart, V.avo_heure_arrivee heure_arrivee, V.avo_prix_billet, 'Round Trip' AS Type_itn,
                PD.avp_nom AS pays_depart, VD.avv_nom AS ville_depart, VD.avv_nom_aeroport AS airport, PA.avp_nom AS pays_arrivee, VA.avv_nom AS ville_arrivee, VA.avv_nom_aeroport AS airport_dest
                FROM av_vols V
                INNER JOIN av_pays_villes PVD ON V.avo_code_lieu_depart = PVD.apv_code_pays_ville
                INNER JOIN av_pays_villes PVA ON V.avo_code_lieu_destination = PVA.apv_code_pays_ville
                INNER JOIN av_pays PD ON PVD.apv_code_pays = PD.avp_code
                INNER JOIN av_pays PA ON PVA.apv_code_pays= PA.avp_code
                INNER JOIN av_villes VD ON PVD.apv_code_ville = VD.avv_code
                INNER JOIN av_villes VA ON PVA.apv_code_ville = VA.avv_code
                WHERE PVD.apv_code_pays_ville= '$ville_to' AND PVA.apv_code_pays_ville= '$ville_from' AND
                V.avo_date_depart= '$return'");

                return view('operation.paiement', compact('vols'), ['vol_retour' => $vol_retour]);
            } else {

                return view('operation.paiement', compact('vols'));
            }
        }else{
            return redirect()->back()->with('message_echec', 'Please Sign In or Sign Up before buying Ticket!');
        }
    }

}
