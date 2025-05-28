@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>Мои карточки</h4>
            <a href="{{ route('cards.create') }}" class="btn btn-primary">Создать новую карточку</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($cards->isEmpty())
            <div class="card">
                <div class="card-body text-center py-5">
                    <h5 class="text-muted mb-3">У вас пока нет карточек</h5>
                    <p>Создайте свою первую карточку, нажав на кнопку "Создать новую карточку"</p>
                </div>
            </div>
        @else
            <!-- Tabs for Active and Archived Cards -->
            <ul class="nav nav-tabs mb-4" id="cardsTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="active-tab" data-bs-toggle="tab" data-bs-target="#active-cards" type="button" role="tab" aria-controls="active-cards" aria-selected="true">
                        Активные карточки
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="archived-tab" data-bs-toggle="tab" data-bs-target="#archived-cards" type="button" role="tab" aria-controls="archived-cards" aria-selected="false">
                        Архив
                    </button>
                </li>
            </ul>
            
            <div class="tab-content" id="cardsTabContent">
                <!-- Active Cards Tab -->
                <div class="tab-pane fade show active" id="active-cards" role="tabpanel" aria-labelledby="active-tab">
                    @php
                        $activeCards = $cards->filter(function($card) {
                            return $card->status !== 'rejected';
                        });
                    @endphp
                    
                    @if($activeCards->isEmpty())
                        <div class="alert alert-info">
                            У вас нет активных карточек.
                        </div>
                    @else
                        <div class="row">
                            @foreach($activeCards as $card)
                                <div class="col-md-6 mb-4">
                                    <x-card :card="$card" :isAdmin="false" />
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                
                <!-- Archived Cards Tab -->
                <div class="tab-pane fade" id="archived-cards" role="tabpanel" aria-labelledby="archived-tab">
                    @php
                        $archivedCards = $cards->filter(function($card) {
                            return $card->status === 'rejected';
                        });
                    @endphp
                    
                    @if($archivedCards->isEmpty())
                        <div class="alert alert-info">
                            У вас нет карточек в архиве.
                        </div>
                    @else
                        <div class="row">
                            @foreach($archivedCards as $card)
                                <div class="col-md-6 mb-4">
                                    <x-card :card="$card" :isAdmin="false" />
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection 
