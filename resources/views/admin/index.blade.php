@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>Админ-панель: Все карточки</h4>
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
                    <h5 class="text-muted mb-3">В системе пока нет карточек</h5>
                </div>
            </div>
        @else
            <!-- Tabs for All, Pending, Approved and Rejected Cards -->
            <ul class="nav nav-tabs mb-4" id="cardsTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all-cards" type="button" role="tab" aria-controls="all-cards" aria-selected="true">
                        Все карточки
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending-cards" type="button" role="tab" aria-controls="pending-cards" aria-selected="false">
                        На рассмотрении
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved-cards" type="button" role="tab" aria-controls="approved-cards" aria-selected="false">
                        Одобренные
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejected-cards" type="button" role="tab" aria-controls="rejected-cards" aria-selected="false">
                        Отклоненные
                    </button>
                </li>
            </ul>
            
            <div class="tab-content" id="cardsTabContent">
                <!-- All Cards Tab -->
                <div class="tab-pane fade show active" id="all-cards" role="tabpanel" aria-labelledby="all-tab">
                    <div class="row">
                        @foreach($cards as $card)
                            <div class="col-md-4 mb-4">
                                <x-card :card="$card" :isAdmin="true" />
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Pending Cards Tab -->
                <div class="tab-pane fade" id="pending-cards" role="tabpanel" aria-labelledby="pending-tab">
                    @php
                        $pendingCards = $cards->filter(function($card) {
                            return $card->status === 'pending';
                        });
                    @endphp
                    
                    @if($pendingCards->isEmpty())
                        <div class="alert alert-info">
                            Нет карточек, ожидающих модерации.
                        </div>
                    @else
                        <div class="row">
                            @foreach($pendingCards as $card)
                                <div class="col-md-4 mb-4">
                                    <x-card :card="$card" :isAdmin="true" />
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                
                <!-- Approved Cards Tab -->
                <div class="tab-pane fade" id="approved-cards" role="tabpanel" aria-labelledby="approved-tab">
                    @php
                        $approvedCards = $cards->filter(function($card) {
                            return $card->status === 'approved';
                        });
                    @endphp
                    
                    @if($approvedCards->isEmpty())
                        <div class="alert alert-info">
                            Нет одобренных карточек.
                        </div>
                    @else
                        <div class="row">
                            @foreach($approvedCards as $card)
                                <div class="col-md-4 mb-4">
                                    <x-card :card="$card" :isAdmin="true" />
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                
                <!-- Rejected Cards Tab -->
                <div class="tab-pane fade" id="rejected-cards" role="tabpanel" aria-labelledby="rejected-tab">
                    @php
                        $rejectedCards = $cards->filter(function($card) {
                            return $card->status === 'rejected';
                        });
                    @endphp
                    
                    @if($rejectedCards->isEmpty())
                        <div class="alert alert-info">
                            Нет отклоненных карточек.
                        </div>
                    @else
                        <div class="row">
                            @foreach($rejectedCards as $card)
                                <div class="col-md-4 mb-4">
                                    <x-card :card="$card" :isAdmin="true" />
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
