@extends('admin.layouts.master')

@section('title', 'Bilet Satışları')

@section('content')

<div class="table-responsive">
    <table class="table table-striped table-bordered border-secondary-subtle">
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">Sipariş Numarası</th>
                <th scope="col">
                    <a class="link-dark link-underline-opacity-0 d-flex justify-content-between align-items-center" href="?sort_quantity={{ request('sort_quantity') == 'desc' ? 'asc' : 'desc' }}">
                        Miktar
                        @if (request()->has('sort_quantity') && request('sort_quantity') == 'desc')
                        <i class="fa-solid fa-arrow-down text-primary"></i>
                        @else
                        <i class="fa-solid fa-arrow-up text-primary"></i>
                        @endif
                    </a>
                </th>
                <th scope="col">
                    <a class="link-dark link-underline-opacity-0 d-flex justify-content-between align-items-center" href="?sort_price={{ request('sort_price') == 'desc' ? 'asc' : 'desc' }}">
                        Fiyat
                        @if (request()->has('sort_price') && request('sort_price') == 'desc')
                        <i class="fa-solid fa-arrow-down text-primary"></i>
                        @else
                        <i class="fa-solid fa-arrow-up text-primary"></i>
                        @endif
                    </a>
                </th>
                <th scope="col">Sipariş Durumu</th>
                <th scope="col">
                    <a class="link-dark link-underline-opacity-0 d-flex justify-content-between align-items-center" href="?sort_created_at={{ request('sort_created_at') == 'desc' ? 'asc' : 'desc' }}">
                        Sipariş Tarihi
                        @if (request()->has('sort_created_at') && request('sort_created_at') == 'desc')
                        <i class="fa-solid fa-arrow-down text-primary"></i>
                        @else
                        <i class="fa-solid fa-arrow-up text-primary"></i>
                        @endif
                    </a>
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
            <tr class="align-middle">
                <td>
                    <a href="#">Detay</a>
                </td>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->quantity }}</td>
                <td>{{ $order->price }}</td>
                <td>
                    <span class="badge bg-warning text-dark">{{ $order->status }}</span>
                </td>
                <td>{{ $order->created_at }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center">Sonuç bulunamadı</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@section('pagination')
{{ $orders->links() }}
@endsection
