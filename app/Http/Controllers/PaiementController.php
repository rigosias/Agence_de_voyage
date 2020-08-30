<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class PaiementController extends Controller
{
    public function getPaiement(Request $request){
        /*$pays_depart = $request->input('pays_depart');
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

        */

        $ville_from = $request->session()->get('ville_from_session');
        $ville_to = $request->session()->get('ville_to_session');
        $departure= $request->session()->get('departure_session');
        $return = $request->session()->get('return_session');
        $type_trip = $request->session()->get('trip_session');


        $vols = DB::select("SELECT V.avo_code_vol, V.avo_code_avion, concat(concat(PD.avp_nom,'-',VD.avv_nom),' => ',concat(PA.avp_nom,'-',VA.avv_nom)) AS Iteneraire, V.avo_date_depart AS date_depart, V.avo_date_arrivee AS date_arrivee, V.avo_heure_depart AS heure_depart, V.avo_heure_arrivee AS heure_arrivee, V.avo_prix_billet AS prix_billet, 'One Way' AS Type_itn,
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

        if ($type_trip == "round") {
            $vol_retour = DB::select("SELECT V.avo_code_vol, V.avo_code_avion, concat(concat(PD.avp_nom,'-',VD.avv_nom),' => ',concat(PA.avp_nom,'-',VA.avv_nom)) AS Iteneraire, V.avo_date_depart AS date_depart, V.avo_date_arrivee AS date_arrivee, V.avo_heure_depart AS heure_depart, V.avo_heure_arrivee AS heure_arrivee, V.avo_prix_billet AS prix_billet, 'Round Trip' AS Type_itn,
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
    }

    public function postPaiement(Request $request){
        $ticket_price = $request->input('ticket_price');
        $name_card = $request->input('name_card');
        $email = $request->input('email');
        $card_number = $request->input('card_number');
        $cvc = $request->input('cvc');
        $exp_date = $request->input('exp_date');

        $user_id = Auth::id();
        $info_banque = DB::table('av_info_banques')
            ->Where('id_user', '=', $user_id)
            ->first();

        $user_id_db= $info_banque->id_user;
        $card_number_db= $info_banque->avib_no_compte;
        $cvc_db = $info_banque->avib_cvc;
        $date_expiration_db= $info_banque->avib_date_expiration;
        $solde_db= $info_banque->avib_solde;

        //Random String
        function random_strings($length_of_string)
        {
            // String of all alphanumeric character
            $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

            // Shufle the $str_result and returns substring
            // of specified length
            return substr(str_shuffle($str_result),
                0, $length_of_string);
        }

        if ($user_id == $user_id_db){
            if($card_number == $card_number_db){
                if($cvc == $cvc_db){
                    if(\Carbon\Carbon::parse($exp_date)->format('d-m-y') == \Carbon\Carbon::parse($date_expiration_db)->format('d-m-y')){
                        if($solde_db >= $ticket_price ){
                            $code_paiement= random_strings(4);
                            $code_reservation= random_strings(8);

                            DB::table('av_paiements')->insert(
                                [   'avpa_code_paiement' => $code_paiement,
                                    'avpa_montant_paiement' => ltrim($ticket_price, "$"),
                                    'avpa_date_paiement' => \Carbon\Carbon::now(),
                                    'avpa_statut' => 'S',
                                    'avpa_no_compte' => $card_number,
                                    'created_at' => \Carbon\Carbon::now()
                                ]
                            );

                            $trip_type= session()->get('trip_session');

                            if ($trip_type == 'one_way'){
                                DB::table('av_reservations')->insert(
                                    [   'avr_code_reservation' => $code_reservation,
                                        'id_user' => $user_id,
                                        'avr_date_reservation' => \Carbon\Carbon::now(),
                                        'avr_code_vol' => session()->get('code_vol_session'),
                                        'avr_statut_reservation' => 'S',
                                        'avr_code_paiement' => $code_paiement,
                                        'avr_statut_paiement' => 'S',
                                        'avr_type_itineraire' => session()->get('trip_session'),
                                        'created_at' => \Carbon\Carbon::now()
                                    ]
                                );
                            }else{
                                DB::table('av_reservations')->insert(
                                    [   'avr_code_reservation' => $code_reservation,
                                        'id_user' => $user_id,
                                        'avr_date_reservation' => \Carbon\Carbon::now(),
                                        'avr_code_vol' => session()->get('code_vol_session'),
                                        'avr_statut_reservation' => 'S',
                                        'avr_code_paiement' => $code_paiement,
                                        'avr_statut_paiement' => 'S',
                                        'avr_type_itineraire' => session()->get('trip_session'),
                                        'created_at' => \Carbon\Carbon::now()
                                    ]
                                );

                                $code_reservation= random_strings(8);
                                DB::table('av_reservations')->insert(
                                    [   'avr_code_reservation' => $code_reservation,
                                        'id_user' => $user_id,
                                        'avr_date_reservation' => \Carbon\Carbon::now(),
                                        'avr_code_vol' => session()->get('code_vol_session_round'),
                                        'avr_statut_reservation' => 'S',
                                        'avr_code_paiement' => $code_paiement,
                                        'avr_statut_paiement' => 'S',
                                        'avr_type_itineraire' => session()->get('trip_session'),
                                        'created_at' => \Carbon\Carbon::now()
                                    ]
                                );
                            }

                            return redirect()->action('RecuController@getRecu');

                        }else{
                            return redirect()->back()->with('message_echec', 'You do not have enough money to buy the ticket');
                        }
                    }else{
                        return redirect()->back()->with('message_echec', 'Please verify the expiration date');
                    }
                }else{
                    return redirect()->back()->with('message_echec', 'Please verify CVC number');
                }
            }else{
                return redirect()->action('PaiementController@getPaiement')->with('message_echec', 'Please verify your card number');
            }
        }else{
            return redirect()->back()->with('message_echec', 'Make sure you have an account!');
        }

    }
}
