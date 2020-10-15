@extends('character.layout', ['isMyo' => $character->is_myo_slot])

@section('profile-title') {{ $character->fullName }}'s Profile @endsection

@section('meta-img') {{ $character->image->thumbnailUrl }} @endsection

@section('profile-content')
<div class="row no-gutters">
    <div class="col-md-8 my-auto">
        {!! breadcrumbs([($character->is_myo_slot ? 'MYO Slot Masterlist' : 'Character Masterlist') => ($character->is_myo_slot ? 'myos' : 'masterlist'), $character->fullName => $character->url, 'Profile' => $character->url . '/profile']) !!}
    </div>

    <!-- character trade/gift status badges section -->
    <div class="col-md-4 text-center text-md-right my-auto">
        <h1>
        <span class="badge {{ $character->is_trading ? 'badge-success' : 'badge-danger' }}" data-toggle="tooltip" title="{{ $character->is_trading ? 'OPEN for sale and trade offers.' : 'CLOSED for sale and trade offers.' }}"><i class="fas fa-comments-dollar"></i></span>
        @if(!$character->is_myo_slot)
            <span class="badge {{ $character->is_gift_art_allowed ? 'badge-success' : 'badge-danger' }}" data-toggle="tooltip" title="{{ $character->is_gift_art_allowed ? 'OPEN for gift art.' : 'CLOSED for gift art.' }}"><i class="fas fa-pencil-ruler"></i></span>
        @endif
        </h1>
    </div>
</div>

@include('character._header', ['character' => $character])

<div class="text-center mb-3">
    <a href="{{ $character->image->imageUrl }}" data-lightbox="entry" data-title="{{ $character->slug }}">
        <img src="{{ $character->image->imageUrl }}" class="image" />
    </a>
</div>

{{-- Bio --}}
@if(Auth::check() && ($character->user_id == Auth::user()->id || Auth::user()->hasPower('manage_characters')))
    <div class="text-right mb-2">
        <a href="{{ $character->url . '/profile/edit' }}" class="btn btn-outline-info btn-sm"><i class="fas fa-cog"></i> Edit Profile</a>
    </div>
@endif
@if($character->profile->parsed_text)
    <div class="card mb-3">
        <div class="card-body parsed-text">
                {!! $character->profile->parsed_text !!}
        </div>
    </div>
@endif

@if($character->is_trading || $character->is_gift_art_allowed)
    <div class="card mb-3">
        @if($character->is_trading || $character->is_gift_art_allowed)
            <ul class="list-group list-group-flush">
                @if($character->is_gift_art_allowed >= 1 && !$character->is_myo_slot)
                    <li class="list-group-item"><h5 class="mb-0"><i class="{{ $character->is_gift_art_allowed == 1 ? 'text-success' : 'text-secondary' }} far fa-circle fa-fw mr-2"></i> {{ $character->is_gift_art_allowed == 1 ? 'Gift art is allowed' : 'Please ask before gift art' }}</h5></li>
                @endif
                @if($character->is_trading)
                    <li class="list-group-item"><h5 class="mb-0"><i class="text-success far fa-circle fa-fw mr-2"></i> Open for trades</h5></li>
                @endif
            </ul>
        @endif
    </div>
@endif
@endsection