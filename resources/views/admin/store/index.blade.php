@extends('admin.layouts.master')

@section('title', 'Müze Listesi')
@section('content')

@section('options')
    <a href="{{ route('admin.store.create') }}" class="btn btn-warning">Müze Oluştur</a>
@endsection

<div class="table-responsive-sm">
    <table class="table table-striped table-bordered border-dark-subtle">
        <thead class="table-info align-middle">
            <tr>
                <th scope="col"></th>
                <th scope="col">Müze Adı</th>
                <th scope="col">Müze Şube Adı</th>
                <th scope="col">Toplam Sipariş Sayısı</th>
                <th scope="col">Etkin mi?</th>
                <th scope="col">Oluşturma Tarihi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($stores as $store)
                <tr class="align-middle {{ session('ActiveStoreId') == $store->id ? 'table-info' : '' }}">
                    <td>
                        <div class="dropdown">
                            <button class="btn bg-transparent" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="fa-solid fa-ellipsis fa-lg"></i></button>
                            <ul class="dropdown-menu">
                                @if (session('adminStoreId') != $store->id)
                                    <li><a class="dropdown-item"
                                            href="{{ route('admin.store.switch', ['storeId' => $store->id]) }}">Geçiş
                                            Yap</a></li>
                                @endif
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.store.edit', $store->id) }}">Düzenle</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li class="d-flex justify-content-between"><a class="dropdown-item link-danger"
                                        href="#">
                                        <i class="fa fa-trash fa-sm me-2"></i> Sil</a></li>
                            </ul>
                        </div>
                    </td>
                    <td>{{ $store->name }}</td>
                    <td>{{ $store->branch_name }}</td>
                    <td>{{ $store->orders->count() }}</td>
                    <td>{{ $store->enabled }}</td>
                    <td>{{ $store->created_at }}</td>
                </tr>
            @empty
                <tr class="text-center">
                    <td colspan="4">Sonuç Bulunamadı</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>




@endsection
