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
                                    <div class="card h-100 {{ $card->status == 'pending' ? 'border-warning' : '' }}">
                                        <div class="card-header d-flex justify-content-between align-items-center {{ $card->status == 'pending' ? 'bg-warning bg-opacity-10' : 'bg-white' }}">
                                            <h5 class="mb-0">{{ $card->title }}</h5>
                                            <span class="badge {{ $card->type == 'share' ? 'bg-success' : 'bg-primary' }}">
                                                {{ $card->type == 'share' ? 'Отдам' : 'Ищу' }}
                                            </span>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text"><strong>Автор:</strong> {{ $card->author }}</p>
                                            
                                            @if($card->publisher)
                                                <p class="card-text"><strong>Издательство:</strong> {{ $card->publisher }}</p>
                                            @endif
                                            
                                            @if($card->year)
                                                <p class="card-text"><strong>Год издания:</strong> {{ $card->year }}</p>
                                            @endif
                                            
                                            @if($card->binding)
                                                <p class="card-text"><strong>Переплет:</strong> 
                                                    {{ $card->binding == 'hard' ? 'Твердый' : 'Мягкий' }}
                                                </p>
                                            @endif
                                            
                                            @if($card->condition)
                                                <p class="card-text"><strong>Состояние:</strong> 
                                                    @switch($card->condition)
                                                        @case('perfect')
                                                            Отличное
                                                            @break
                                                        @case('normal')
                                                            Нормальное
                                                            @break
                                                        @case('needs_attention')
                                                            Требует внимания
                                                            @break
                                                        @case('table_prop')
                                                            Подпорка для стола
                                                            @break
                                                    @endswitch
                                                </p>
                                            @endif
                                            
                                            <p class="card-text mt-2">
                                                <strong>Статус:</strong>
                                                <span class="badge {{ $card->status == 'approved' ? 'bg-success' : 'bg-warning' }}">
                                                    @switch($card->status)
                                                        @case('pending')
                                                            На рассмотрении
                                                            @break
                                                        @case('approved')
                                                            Одобрено
                                                            @break
                                                    @endswitch
                                                </span>
                                            </p>
                                        </div>
                                        <div class="card-footer bg-white">
                                            <div class="d-flex justify-content-between">
                                                <form action="{{ route('cards.destroy', $card) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить эту карточку?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">Удалить</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Модальное окно для отклонения карточки -->
                                <div class="modal fade" id="rejectModal{{ $card->id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $card->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="rejectModalLabel{{ $card->id }}">Отклонить карточку</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('cards.reject', $card) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="rejection_reason" class="form-label">Причина отклонения</label>
                                                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                                                    <button type="submit" class="btn btn-danger">Отклонить</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
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
                                    <div class="card h-100 border-danger">
                                        <div class="card-header d-flex justify-content-between align-items-center bg-danger bg-opacity-10">
                                            <h5 class="mb-0">{{ $card->title }}</h5>
                                            <span class="badge {{ $card->type == 'share' ? 'bg-success' : 'bg-primary' }}">
                                                {{ $card->type == 'share' ? 'Отдам' : 'Ищу' }}
                                            </span>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text"><strong>Автор:</strong> {{ $card->author }}</p>
                                            
                                            @if($card->publisher)
                                                <p class="card-text"><strong>Издательство:</strong> {{ $card->publisher }}</p>
                                            @endif
                                            
                                            @if($card->year)
                                                <p class="card-text"><strong>Год издания:</strong> {{ $card->year }}</p>
                                            @endif
                                            
                                            @if($card->binding)
                                                <p class="card-text"><strong>Переплет:</strong> 
                                                    {{ $card->binding == 'hard' ? 'Твердый' : 'Мягкий' }}
                                                </p>
                                            @endif
                                            
                                            @if($card->condition)
                                                <p class="card-text"><strong>Состояние:</strong> 
                                                    @switch($card->condition)
                                                        @case('perfect')
                                                            Отличное
                                                            @break
                                                        @case('normal')
                                                            Нормальное
                                                            @break
                                                        @case('needs_attention')
                                                            Требует внимания
                                                            @break
                                                        @case('table_prop')
                                                            Подпорка для стола
                                                            @break
                                                    @endswitch
                                                </p>
                                            @endif
                                            
                                            <p class="card-text mt-2">
                                                <strong>Статус:</strong>
                                                <span class="badge bg-danger">Отклонено</span>
                                            </p>
                                            
                                            @if($card->rejection_reason)
                                                <div class="alert alert-danger mt-2" role="alert">
                                                    <small><strong>Причина отклонения:</strong> {{ $card->rejection_reason }}</small>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="card-footer bg-white">
                                            <div class="d-flex justify-content-between">
                                                <form action="{{ route('cards.approve', $card) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success">Восстановить</button>
                                                </form>
                                                <form action="{{ route('cards.destroy', $card) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить эту карточку?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">Удалить</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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
