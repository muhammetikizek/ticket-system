@extends('admin.layouts.master')

@section('title', 'Biletler')
@section('content')

@section('options')
    <a href="#" class="btn btn-primary shadow-sm">Sync To Online</a>
    <a href="{{ route('admin.product.create') }}" class="btn btn-warning shadow-sm">Yeni Bilet Oluştur</a>
@endsection

<table class="table table-striped align-middle">
  <thead>
    <tr>
      <th scope="col"></th>
      <th scope="col">Bilet Adı</th>
      <th scope="col">Saat</th>
      <th scope="col">Limit</th>
      <th scope="col">Fiyat</th>
      <th scope="col">Kullanılabilir</th>
      <th scope="col">Eklenme Tarihi</th>
    </tr>
  </thead>
  <tbody>
    @forelse ($products as $product)
        <tr>
            <td>
                <a class="link-offset-3 link-danger me-2" href="#">Sil</a>
                <a class="link-offset-3" href="">Düzenle</a>
            </td>
            <td>{{ $product->category->name }}</td>
            <td>{{ $product->name}}</td>
            <td>{{ $product->quantity }}</td>
            <td>{{ $product->price }}</td>
            <td><span class="badge bg-success rounded-pill">{{ $product->enabled ? 'Evet' : 'Hayır' }}</span></td>
            <td>{{ $product->created_at }}</td>
        </tr>
    @empty
        <tr>
            <td colspan=""></td>
        </tr>
    @endforelse
  </tbody>
</table>

@endsection
