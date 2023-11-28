@extends('admin.layouts.master')

@section('content')

    <div class="row justify-content-center">
        <div class="col-xl-7">

            <form method="post" action="{{ route('admin.store.store') }}" class="needs-validation" id="storeCreateForm">
                @csrf
                <div class="row mb-4">
                    <label for="nameInput" class="col-sm col-form-label text-sm-end">Müze Adı</label>
                    <div class="col-sm-9">
                        <input type="text" name="name" class="form-control shadow-sm @error('name') is-invalid @else border-secondary-subtle @enderror" id="nameInput" value="{{ old('name') }}" autofocus="autofocus">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="branch_name" class="col-sm col-form-label text-sm-end">Müze Şube Adı</label>
                    <div class="col-sm-9">
                        <input type="text" name="branch_name" class="form-control shadow-sm @error('branch_name') is-invalid @else border-secondary-subtle @enderror" id="branch_name" value="{{ old('branch_name') }}">
                        @error('branch_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row align-items-centers">
                <div class="offset-sm-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning shadow-sm" form="storeCreateForm">Kaydet</button>
                        <a href="{{ route('admin.store.index') }}" class="btn btn-light shadow-sm">Vazgeç</a>
                    </div>
                </div>
                </div>
            </form>


        </div><!-- .col-md -->
    </div><!-- .row -->
@endsection
