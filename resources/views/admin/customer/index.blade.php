@extends('admin.layouts.master')

@section('title', 'Müşteri Listesi')

@section('content')

<div class="table-responsive">
<table class="table table-striped table-bordered border-dark-subtle">
  <thead class="table-info align-middle">
    <tr>
      <th scope="col"></th>
      <th scope="col">Ad</th>
      <th scope="col">Soyad</th>
      <th scope="col">Email</th>
      <th scope="col">Telefon Numarası</th>
      <th scope="col">Satın Alınan Bilet Sayısı</th>
      <th scope="col">Eklenme Tarihi</th>
    </tr>
  </thead>
  <tbody>
    @forelse ($customers as $customer)
    <tr class="align-middle {{ request('select') != $customer->id ?: 'border-primary table-primary border-2' }}">
      <td>
      </td>
      <td>{{ $customer->name }}</td>
      <td>{{ $customer->surname }}</td>
      <td>{{ $customer->email }}</td>
      <td>{{ $customer->phone }}</td>
      <td>{{ $customer->orderTicket->count() }}</td>
      <td>{{ $customer->created_at }}</td>
    </tr>
    @empty
    <tr>
      <td colspan="7">Ziyaretçi bulunamadı.</td>
    </tr>
    @endforelse
  </tbody>
</table>
</div>

{{ $customers->links() }}

@endsection
