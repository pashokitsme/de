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
            <div class="row">
                @foreach($cards as $card)
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center bg-white">
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
                                    <span class="badge {{ $card->status == 'approved' ? 'bg-success' : ($card->status == 'rejected' ? 'bg-danger' : 'bg-warning') }}">
                                        @switch($card->status)
                                            @case('pending')
                                                На рассмотрении
                                                @break
                                            @case('approved')
                                                Одобрено
                                                @break
                                            @case('rejected')
                                                Отклонено
                                                @break
                                        @endswitch
                                    </span>
                                </p>
                                
                                @if($card->status == 'rejected' && $card->rejection_reason)
                                    <div class="alert alert-danger mt-2" role="alert">
                                        <small><strong>Причина отклонения:</strong> {{ $card->rejection_reason }}</small>
                                    </div>
                                @endif
                            </div>
                            <div class="card-footer bg-white">
                                <form action="{{ route('cards.destroy', $card) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить эту карточку?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Удалить</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection 
