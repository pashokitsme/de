@props([
    'card',
    'isAdmin' => false
])

<div class="card h-100 {{ 
    $card->status == 'pending' ? 'border-warning' : 
    ($card->status == 'rejected' ? 'border-danger' : '') 
}}">
    <div class="card-header d-flex justify-content-between align-items-center {{ 
        $card->status == 'pending' ? 'bg-warning bg-opacity-10' : 
        ($card->status == 'rejected' ? 'bg-danger bg-opacity-10' : 'bg-white') 
    }}">
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
            <span class="badge {{ 
                $card->status == 'approved' ? 'bg-success' : 
                ($card->status == 'rejected' ? 'bg-danger' : 'bg-warning') 
            }}">
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
        <div class="d-flex justify-content-between">
            @if($isAdmin)
                @if($card->status == 'pending')
                    <form action="{{ route('admin.cards.approve', $card) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success">Одобрить</button>
                    </form>
                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $card->id }}">
                        Отклонить
                    </button>
                @if($card->status == 'rejected')
                    <form action="{{ route('admin.cards.approve', $card) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success">Восстановить</button>
                    </form>
                @endif
            @endif
                <form action="{{ route('cards.destroy', $card) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить эту карточку?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger">Удалить</button>
                </form>
        </div>
    </div>
</div>

@if($card->status == 'pending' || $card->status == 'rejected')
    <!-- Модальное окно для отклонения карточки -->
    <div class="modal fade" id="rejectModal{{ $card->id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $card->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel{{ $card->id }}">Отклонить карточку</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ $isAdmin ? route('admin.cards.reject', $card) : route('cards.reject', $card) }}" method="POST">
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
@endif 
