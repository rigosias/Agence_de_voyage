<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class VillesController extends Controller
{
    public function getVilles()
    {
        $villes = DB::table('av_pays_villes')
            ->select(DB::raw('apv_code_pays_ville, CONCAT(avv_nom,\'-\',avv_nom_aeroport) AS VILLE'))
            ->join('av_pays', 'av_pays_villes.apv_code_pays', '=', 'av_pays.avp_code')
            ->join('av_villes', 'av_pays_villes.apv_code_ville', '=', 'av_villes.avv_code')
            ->orderBy('avp_nom', 'asc')
            ->pluck("VILLE", "apv_code_pays_ville");

        return view('index', compact('villes'));
    }

    public function postIndex(Request $request){
        //Liste des inputs
        $ville_from = $request->input('ville_from');
        $ville_to = $request->input('ville_to');
        $departure = \Carbon\Carbon::parse($request->input('departure'))->format('yy-m-d');
        $return = \Carbon\Carbon::parse($request->input('return'))->format('yy-m-d');
        $trip_type = $request->input('trip');

        $request->session()->put('ville_from_session', $ville_from);
        $request->session()->put('ville_to_session', $ville_to);
        $request->session()->put('departure_session', $departure);
        $request->session()->put('return_session', $return);
        $request->session()->put('trip_session', $trip_type);

        if($departure >= \Carbon\Carbon::parse(now())->format('yy-m-d')) {
            if($ville_from != $ville_to) {
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
                } elseif ($trip_type == 'round' and $return == \Carbon\Carbon::parse(now())->format('yy-m-d')) {
                    return redirect()->back()->with('message_echec', 'Round Trip should have return date!');
                } else {
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
            }else{
                return redirect()->back()->with('message_echec', 'Departure city should be different from destanation city!');
            }
        }else{
            return redirect()->back()->with('message_echec', 'Departure date should be greater than today!');
        }
    }
}
