{{--
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 29/06/2020
 * Time: 11:57 PM
 */--}}
@extends('layouts.app')
@section('content')
<style>
    @media print {
        #imprimer_recu_id {
            display: none;
        }

        #entete_recu{
            display: none;
        }

        #Header, #Footer {
            display: none !important;
        }

        body  {
            size: landscape;
            margin-left: 5.5rem !important;
            margin-top :8.0rem !important ;
        }
    }
</style>
<!-- Custom JS-->
<script>
    function printContent(el){
        var restorepage = document.body.innerHTML;
        var printcontent = document.getElementById(el).innerHTML;
        document.body.innerHTML = printcontent;
        window.print();
        document.body.innerHTML = restorepage;
    }
</script>
    <div class="container">
        <div id= "recu_box" class="card">
            <div class="card-header">Reçu</div>
            <div class="card-body">
                <h5>Trip 1</h5>
                @foreach($recu as $info_recu)
                    <div class="row">
                        <div class="col-md-4">
                            <label>{{"Prénom: "}}</label><label>{{$info_recu->name}}</label>
                        </div>
                        <div class="col-md-4">
                            <label>{{"Nom: "}}</label><label>{{$info_recu->last_name}}</label>
                        </div>
                        <div class="col-md-4">
                            <label>{{"Code réservation: "}}</label><label>{{$info_recu->avr_code_reservation}}</label>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <label>{{"Date départ: "}}</label><label>{{\Carbon\Carbon::parse($info_recu->avo_date_depart)->format('d-m-y')}}</label>
                        </div>
                        <div class="col-md-4">
                            <label>{{"Heure départ: "}}</label><label>{{\Carbon\Carbon::parse($info_recu->avo_heure_depart)->format('H:i')}}</label>
                        </div>
                        <div class="col-md-4">
                            <label>{{"Heure arrivée: "}}</label><label>{{\Carbon\Carbon::parse($info_recu->avo_heure_arrivee)->format('H:i')}}</label>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <label>{{"Itinéraire: "}}</label><label>{{"$info_recu->Iteneraire"}}</label>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <label>{{"Code Paiement: "}}</label><label>{{ $info_recu->avr_code_paiement }}</label>
                        </div>
                        <div class="col-md-4">
                            <label>{{"Montant: "}}</label><label>{{$info_recu->avo_prix_billet}}</label>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <label>{{"Ligne Aérienne: "}}</label><label>{{$info_recu->avc_nom}}</label>
                        </div>
                        <div class="col-md-4">
                            <label>{{"Code Vol: "}}</label><label>{{$info_recu->avo_code_vol}}</label>
                        </div>
                    </div>
                    <br>
                @endforeach
                @if(session()->get('trip_session') == 'round')
                    <h5>Trip 2</h5>
                    @foreach($recu_retour as $info_recu_round)
                            <div class="row">
                                <div class="col-md-4">
                                    <label>{{"Prénom: "}}</label><label>{{$info_recu_round->name}}</label>
                                </div>
                                <div class="col-md-4">
                                    <label>{{"Nom: "}}</label><label>{{$info_recu_round->last_name}}</label>
                                </div>
                                <div class="col-md-4">
                                    <label>{{"Code réservation: "}}</label><label>{{$info_recu_round->avr_code_reservation}}</label>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>{{"Date départ: "}}</label><label>{{\Carbon\Carbon::parse($info_recu_round->avo_date_depart)->format('d-m-y')}}</label>
                                </div>
                                <div class="col-md-4">
                                    <label>{{"Heure départ: "}}</label><label>{{\Carbon\Carbon::parse($info_recu_round->avo_heure_depart)->format('H:i')}}</label>
                                </div>
                                <div class="col-md-4">
                                    <label>{{"Heure arrivée: "}}</label><label>{{\Carbon\Carbon::parse($info_recu_round->avo_heure_arrivee)->format('H:i')}}</label>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>{{"Itinéraire: "}}</label><label>{{"$info_recu_round->Iteneraire"}}</label>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>{{"Code Paiement: "}}</label><label>{{ $info_recu_round->avr_code_paiement }}</label>
                                </div>
                                <div class="col-md-4">
                                    <label>{{"Montant: "}}</label><label>{{$info_recu_round->avo_prix_billet}}</label>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>{{"Ligne Aérienne: "}}</label><label>{{$info_recu_round->avc_nom}}</label>
                                </div>
                                <div class="col-md-4">
                                    <label>{{"Code Vol: "}}</label><label>{{$info_recu_round->avo_code_vol}}</label>
                                </div>
                            </div>
                    @endforeach
                @endif
                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary" id="imprimer_recu_id" onclick="printContent('recu_box')">
                                {{ __('Print Receipt') }}
                            </button>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection
