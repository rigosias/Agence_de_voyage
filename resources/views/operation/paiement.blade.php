
{{--
* Created by PhpStorm.
* User: Admin
* Date: 26/06/2020
* Time: 2:13 AM--}}
@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Flight information</div>
            <div class="card-body">
                <h5>{{"Trip 1"}}</h5>
                @foreach($vols as $vol)
                    <div class="row">
                        <div class="col-md-8">
                                <label>{{"Departure: "}}</label><label>{{$vol->pays_depart." - ".$vol->ville_depart." - ".$vol->airport}}</label>
                        </div>
                        <div class="col-md-2">
                            <label>{{"Date: "}}</label><label>{{\Carbon\Carbon::parse($vol->date_depart)->format('d-m-y')}}</label>
                        </div>
                        <div class="col-md-2">
                            <label>{{"Time: "}}</label><label>{{\Carbon\Carbon::parse($vol->heure_depart)->format('H:i')}}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <label>{{"Destination: "}}</label><label>{{$vol->pays_arrivee." - ".$vol->ville_arrivee." - ".$vol->airport_dest}}</label>
                        </div>
                        <div class="col-md-2">
                            <label>{{"Date: "}}</label><label>{{\Carbon\Carbon::parse($vol->date_arrivee)->format('d-m-y')}}</label>
                        </div>
                        <div class="col-md-2">
                            <label>{{"Time: "}}</label><label>{{\Carbon\Carbon::parse($vol->heure_arrivee)->format('H:i')}}</label>
                        </div>
                    </div>
                @endforeach
                @if(session()->get('trip_session') == "round")
                    <h5>{{"Trip 2"}}</h5>
                    @foreach($vol_retour as $info_vol_retour)
                    <div class="row">
                        <div class="col-md-8">
                            <label>{{"Departure: "}}</label><label>{{$info_vol_retour->pays_depart." - ".$info_vol_retour->ville_depart." - ".$info_vol_retour->airport}}</label>
                        </div>
                        <div class="col-md-2">
                            <label>{{"Date: "}}</label><label>{{\Carbon\Carbon::parse($info_vol_retour->date_depart)->format('d-m-y')}}</label>
                        </div>
                        <div class="col-md-2">
                            <label>{{"Time: "}}</label><label>{{\Carbon\Carbon::parse($info_vol_retour->heure_depart)->format('H:i')}}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <label>{{"Destination: "}}</label><label>{{$info_vol_retour->pays_arrivee." - ".$info_vol_retour->ville_arrivee." - ".$info_vol_retour->airport_dest}}</label>
                        </div>
                        <div class="col-md-2">
                            <label>{{"Date: "}}</label><label>{{\Carbon\Carbon::parse($info_vol_retour->date_arrivee)->format('d-m-y')}}</label>
                        </div>
                        <div class="col-md-2">
                            <label>{{"Time: "}}</label><label>{{\Carbon\Carbon::parse($info_vol_retour->heure_arrivee)->format('H:i')}}</label>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
        <br>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Ticket Payment') }}
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
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{route("paiement")}}">
                            @csrf

                            <div class="form-group row">
                                <label for="ticket_price" class="col-md-4 col-form-label text-md-right">{{ __('Ticket Price') }}</label>

                                <div class="col-md-6">
                                    <input id="ticket_price" type="text" readonly class="form-control @error('ticket_price') is-invalid @enderror" name="ticket_price" value="{{ "$".session()->get('prix_billet_session') }}" required autocomplete="ticket_price" autofocus>

                                    @error('ticket_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name_card" class="col-md-4 col-form-label text-md-right">{{ __('Name on card') }}</label>

                                <div class="col-md-6">
                                    <input id="name_card" type="text" class="form-control @error('name_card') is-invalid @enderror" name="name_card" value="{{ old('name_card') }}" required autocomplete="name_card" autofocus>

                                    @error('name_card')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="card_number" class="col-md-4 col-form-label text-md-right">{{ __('Card Number') }}</label>

                                <div class="col-md-6">
                                    <input id="card_number" type="text" class="form-control @error('card_number') is-invalid @enderror" name="card_number" placeholder="1234 1234 1234 1234" value="{{ old('name_card') }}" required autocomplete="name_card" autofocus>

                                    @error('card_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="cvc" class="col-md-4 col-form-label text-md-right">{{ __('CVC') }}</label>

                                <div class="col-md-6">
                                    <input id="cvc" type="text" class="form-control @error('cvc') is-invalid @enderror" name="cvc" value="{{ old('cvc') }}" required autocomplete="cvc" autofocus>

                                    @error('cvc')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="exp_date" class="col-md-4 col-form-label text-md-right">{{ __('Expiration date') }}</label>

                                <div class="col-md-6">
                                    <input id="exp_date" type="date" class="form-control @error('exp_date') is-invalid @enderror" name="exp_date" placeholder="MM/YY" value="{{ old('exp_date') }}" required autocomplete="exp_date" autofocus>

                                    @error('exp_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('PAY TICKET') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
