{{--
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 06/07/2020
 * Time: 4:12 AM
 */
 --}}
@extends('layouts.app')
@section('content')
    <form id="form-submit" action="{{route('cancelFlight')}}" method="post">
        <table class="table table-bordered" style=" width: 95%; margin-left: 30px ">
            {{ csrf_field() }}
            <thead>
            <tr>
                <th scope="col" colspan="12">Flights to cancel</th>
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
                @if(session()->has('message_echec'))
                    <div class="alert alert-danger">
                        {{ session()->get('message_echec') }}
                    </div>
                @endif
            </tr>
            <tr>
                <th scope="col" colspan="">No.</th>
                <th scope="col" colspan="">Nom utilisateur</th>
                <th scope="col" colspan="">Code Vol</th>
                <th scope="col" colspan="">Itinéraire</th>
                <th scope="col" colspan="">Type</th>
                <th scope="col" colspan="">Date départ</th>
                <th scope="col" colspan="">Date arrivée</th>
                <th scope="col" colspan="">Heure départ</th>
                <th scope="col" colspan="">Heure arrivée</th>
                <th scope="col" colspan="">Prix Billet</th>
                <th scope="col" colspan="">Statut</th>
                <th scope="col" colspan="">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($list_vols as $info_vol)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td colspan="">{{$info_vol->nom}}</td>
                    <td colspan="">{{$info_vol->avo_code_vol}}</td>
                    <td colspan="">{{$info_vol->Iteneraire}}</td>
                    <td colspan="">{{$info_vol->Type_itn}}</td>
                    <td colspan="">{{ \Carbon\Carbon::parse($info_vol->avo_date_depart)->format('d-m-y') }}</td>
                    <td colspan="">{{ \Carbon\Carbon::parse($info_vol->avo_date_arrivee)->format('d-m-y') }}</td>
                    <td colspan="">{{ \Carbon\Carbon::parse($info_vol->avo_heure_depart)->format('H:i') }}</td>
                    <td colspan="">{{ \Carbon\Carbon::parse($info_vol->avo_heure_arrivee)->format('H:i') }}</td>
                    <td colspan="">{{"$"}}{{$info_vol->avo_prix_billet}}</td>
                    <td colspan="">{{$info_vol->statut}}</td>
                    @if(($info_vol->Type_itn == "Round Trip" && $loop->iteration%2 != 0) || ($info_vol->Type_itn == "One Way"))
                        <input type="hidden" name="code_vol" value={{$info_vol->avo_code_vol}}>
                        <input type="hidden" name="id_user" value={{$info_vol->id_user}}>
                        <input type="hidden" name="pays_depart" value="{{$info_vol->pays_depart}}">
                        <input type="hidden" name="ville_depart" value="{{$info_vol->ville_depart}}">
                        <input type="hidden" name="pays_arrivee" value="{{$info_vol->pays_arrivee}}">
                        <input type="hidden" name="ville_arrivee" value="{{$info_vol->ville_arrivee}}">
                        <input type="hidden" name="type_itn" value="{{$info_vol->Type_itn}}">
                        <input type="hidden" name="date_depart" value={{\Carbon\Carbon::parse($info_vol->avo_date_depart)->format('d-m-y')}}>
                        <input type="hidden" name="date_arrivee" value={{$info_vol->avo_date_arrivee}}>
                        <input type="hidden" name="heure_depart" value={{\Carbon\Carbon::parse($info_vol->avo_heure_depart)->format('H:i')}}>
                        <input type="hidden" name="heure_arrivee" value={{\Carbon\Carbon::parse($info_vol->avo_heure_arrivee)->format('H:i')}}>
                        <input type="hidden" name="prix_billet" value={{$info_vol->avo_prix_billet}}>
                        <input type="hidden" name="airport" value="{{$info_vol->airport}}">
                        <input type="hidden" name="airport_dest" value="{{$info_vol->airport_dest}}">
                        <td><button type='submit' class='btn btn-danger'><i class="fa-plane" aria-hidden="true"></i>{{"Cancel"}}</button></td>
                    @else
                        <td></td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </form>
@endsection
