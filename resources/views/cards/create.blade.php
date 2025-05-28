@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Создание новой карточки</h5>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('cards.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="author" class="form-label">Автор <span class="text-danger">*</span></label>
                        <input id="author" type="text" class="form-control @error('author') is-invalid @enderror" name="author" value="{{ old('author') }}" required autofocus>
                        @error('author')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Название <span class="text-danger">*</span></label>
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label d-block">Тип карточки <span class="text-danger">*</span></label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="type" id="type-share" value="share" {{ old('type') == 'share' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="type-share">Отдам</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="type" id="type-want" value="want" {{ old('type') == 'want' ? 'checked' : '' }}>
                            <label class="form-check-label" for="type-want">Ищу</label>
                        </div>
                        @error('type')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="publisher" class="form-label">Издательство</label>
                        <input id="publisher" type="text" class="form-control @error('publisher') is-invalid @enderror" name="publisher" value="{{ old('publisher') }}">
                        @error('publisher')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="year" class="form-label">Год издания <span class="text-danger">*</span></label>
                        <input id="year" type="number" min="1800" max="{{ date('Y') }}" class="form-control @error('year') is-invalid @enderror" name="year" value="{{ old('year') }}">
                        @error('year')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="binding" class="form-label">Переплет <span class="text-danger">*</span></label>
                        <select id="binding" class="form-select @error('binding') is-invalid @enderror" name="binding">
                            <option value="">Выберите тип переплета</option>
                            <option value="hard" {{ old('binding') == 'hard' ? 'selected' : '' }}>Твердый</option>
                            <option value="soft" {{ old('binding') == 'soft' ? 'selected' : '' }}>Мягкий</option>
                        </select>
                        @error('binding')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="condition" class="form-label">Состояние <span class="text-danger">*</span></label>
                        <select id="condition" class="form-select @error('condition') is-invalid @enderror" name="condition">
                            <option value="">Выберите состояние</option>
                            <option value="perfect" {{ old('condition') == 'perfect' ? 'selected' : '' }}>Отличное</option>
                            <option value="normal" {{ old('condition') == 'normal' ? 'selected' : '' }}>Нормальное</option>
                            <option value="needs_attention" {{ old('condition') == 'needs_attention' ? 'selected' : '' }}>Требует внимания</option>
                            <option value="table_prop" {{ old('condition') == 'table_prop' ? 'selected' : '' }}>Подпорка для стола</option>
                        </select>
                        @error('condition')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('cards.index') }}" class="btn btn-outline-secondary">Отмена</a>
                        <button type="submit" class="btn btn-primary">Создать карточку</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 
