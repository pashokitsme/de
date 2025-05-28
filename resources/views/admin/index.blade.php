@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>Админ-панель: Все карточки</h4>
            <a href="{{ route('admin.cards.pending') }}" class="btn btn-warning">Ожидающие модерации</a>
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
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Название</th>
                                    <th>Автор</th>
                                    <th>Тип</th>
                                    <th>Пользователь</th>
                                    <th>Статус</th>
                                    <th>Дата создания</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cards as $card)
                                <tr>
                                    <td>{{ $card->id }}</td>
                                    <td>{{ $card->title }}</td>
                                    <td>{{ $card->author }}</td>
                                    <td>
                                        @if($card->type == 'share')
                                            <span class="badge bg-success">Отдам</span>
                                        @else
                                            <span class="badge bg-primary">Ищу</span>
                                        @endif
                                    </td>
                                    <td>{{ $card->user->name }}</td>
                                    <td>
                                        @if($card->status == 'pending')
                                            <span class="badge bg-warning">На рассмотрении</span>
                                        @elseif($card->status == 'approved')
                                            <span class="badge bg-success">Одобрено</span>
                                        @else
                                            <span class="badge bg-danger">Отклонено</span>
                                        @endif
                                    </td>
                                    <td>{{ $card->created_at->format('d.m.Y H:i') }}</td>
                                    <td>
                                        @if($card->status == 'pending')
                                            <div class="d-flex gap-2">
                                                <form action="{{ route('admin.cards.approve', $card) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success">Одобрить</button>
                                                </form>
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $card->id }}">
                                                    Отклонить
                                                </button>
                                            </div>
                                        @elseif($card->status == 'rejected')
                                            <form action="{{ route('admin.cards.approve', $card) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">Восстановить</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                
                                <!-- Модальное окно для отклонения карточки -->
                                <div class="modal fade" id="rejectModal{{ $card->id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $card->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="rejectModalLabel{{ $card->id }}">Отклонить карточку</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('admin.cards.reject', $card) }}" method="POST">
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection 
