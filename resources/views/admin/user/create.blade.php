@extends('admin.layouts.master')

@section('title', 'Kullanıcı Oluştur')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">
    <form method="post" action="{{ route('admin.user.create') }}" id="userCreateForm">
    @csrf
    <div class="row mb-4">
        <label for="nameInput" class="col-sm col-form-label text-sm-end">Kullanıcı Adı</label>
        <div class="col-sm-9">
            <input type="text" name="name" class="form-control shadow-sm @error('name') is-invalid @else border-secondary-subtle @enderror" id="nameInput" value="{{ old('name') }}" autofocus="autofocus" autocomplete="false">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="row mb-4">
        <label for="email" class="col-sm col-form-label text-sm-end">Email</label>
        <div class="col-sm-9">
            <input type="text" name="email" class="form-control shadow-sm @error('email') is-invalid @else border-secondary-subtle @enderror" id="email" value="{{ old('email') }}">
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="row mb-4">
        <label for="password" class="col-sm col-form-label text-sm-end">Şifre</label>
        <div class="col-sm-9">
            <input type="password" name="password" class="form-control shadow-sm @error('password') is-invalid @else border-secondary-subtle @enderror" id="password">
            @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-sm-9 offset-sm-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_admin" role="switch" id="isAdminCheck" value="{{ old('is_admin', 1) }}" {{ !old('is_admin', 1) ?: ' checked' }}>
                <label class="form-check-label" for="isAdminCheck">Admin yetkisine sahip.</label>
            </div>
        </div>
    </div>
    <div class="row mb-4">
                <div class="row mb-4">
                    <label for="" class="col-sm col-form-label text-sm-end">Müzeler</label>
                    <div class="col-sm-9">
                        <div class="bg-info-subtle p-3 rounded-4">
                            @foreach ($stores as $store)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="store_ids[]" value="{{ $store->id }}" id="checkStore{{ $store->id }}">
                                <label class="form-check-label" for="checkStore{{ $store->id }}">
                                    {{ $store->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
    <div class="row align-items-centers">
        <div class="offset-sm-3">
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning shadow-sm rounded-1" form="userCreateForm">Kaydet</button>
                <a href="{{ route('admin.user.index') }}" class="btn btn-light shadow-sm rounded-1 border-dark-subtle">Vazgeç</a>
            </div>
        </div>
    </div>
</form>
    </div>
</div>

@endsection
