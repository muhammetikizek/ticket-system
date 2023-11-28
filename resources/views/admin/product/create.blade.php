@extends('admin.layouts.master')

@section('title', 'Bilet Oluştur')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-7">
            <form method="post" action="{{ route('admin.product.store') }}" id="productCreateForm">
                @csrf
                <div class="row mb-4">
                    <label for="" class="col-sm col-form-label text-md-end">Satış Müzesi</label>
                    <div class="col-sm-8">
                        <select name="store_id"
                            class="form-select shadow-sm @error('store_id') is-invalid @else border-secondary-subtle @enderror">
                            @forelse ($stores as $store)
                                <option value="{{ $store->id }}" {{ old('store_id', $store->id) ? 'selected' : '' }}>
                                    {{ $store->name }}</option>
                            @empty
                                <option selected>Not result</option>
                            @endforelse
                        </select>
                        <div id="emailHelp" class="form-text">Bu bilet, hangi müzeye ait?</div>
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="" class="col-sm col-form-label text-md-end">Bilet Adı</label>
                    <div class="col-sm-8">
                        <select name="category_id"
                            class="form-select shadow-sm @error('category_id') is-invalid @else border-secondary-subtle @enderror">
                            @forelse ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $store->id) ? 'selected' : '' }}>
                                    {{ $category->name }}</option>
                            @empty
                                <option selected>Not result</option>
                            @endforelse
                        </select>
                        <input type="text" name="name"
                            class="form-control shadow-sm @error('name') is-invalid @else border-secondary-subtle @enderror"
                            value="{{ old('name') }}">
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="" class="col-sm col-form-label text-md-end">Bilet Saati</label>
                    <div class="col-sm-8">
                        <input type="time" name="name"
                            class="form-control shadow-sm @error('name') is-invalid @else border-secondary-subtle @enderror"
                            value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="" class="col-sm col-form-label text-md-end">Bilet Adeti</label>
                    <div class="col-sm-8">
                        <input type="text" name="quantity"
                            class="form-control shadow-sm @error('quantity') is-invalid @else border-secondary-subtle @enderror"
                            value="{{ old('quantity') }}">
                        @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="emailHelp" class="form-text">Bu bilet, hangi müzeye ait?</div>
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-sm col-form-label text-md-end">Bilet Fiyatı</label>
                    <div class="col-sm-8">
                        <input type="text" name="price"
                            class="form-control shadow-sm @error('price') is-invalid @else border-secondary-subtle @enderror"
                            value="{{ old('price') }}">
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm col-form-label text-md-end">Saat</label>
                    <div class="col-sm-8">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Saat</th>
                                    <th scope="col">Fiyat</th>
                                    <th scope="col">Adet</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">Saat</th>
                                    <td>@mdo</td>
                                </tr>
                                <tr>
                                    <th scope="row">Fiyatı</th>
                                    <td>@fat</td>
                                </tr>
                                <tr>
                                    <th scope="row">Satış Adeti</th>
                                    <td>@twitter</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="offset-4">
                        <button class="btn btn-lg btn-warning rounded-1 border-secondary" form="productCreateForm">Bilet Oluştur</button>
                        <a href="{{ route('admin.product.index') }}" class="btn btn-lg btn-light rounded-1 border-secondary-subtle">Vazgeç</a>
                    </div>
                </div>
            </form>
        </div><!-- .col-md -->
    </div><!-- .row -->


@endsection
