@extends('admin.layouts.master')

@section('title', 'Bilet Satışları')

@section('content')

    <ul class="nav nav-pills mb-4">
        <li class="nav-item">
            <a class="nav-link active" href="#">Pending</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">İnternetten</a>
        </li>
    </ul>

    <div class="table-responsive">
        <table class="table table-striped table-bordered border-secondary-subtle">
            <thead class="table-info">
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Bilet Kodu</th>
                    <th scope="col">Bilet</th>
                    <th scope="col">Saat</th>
                    <th scope="col">
                        <a class="link-dark link-underline-opacity-0 d-flex justify-content-between align-items-center"
                            href="?sort_quantity={{ request('sort_quantity') == 'desc' ? 'asc' : 'desc' }}">
                            Miktar
                            @if (request()->has('sort_quantity') && request('sort_quantity') == 'desc')
                                <i class="fa-solid fa-arrow-down text-primary"></i>
                            @else
                                <i class="fa-solid fa-arrow-up text-primary"></i>
                            @endif
                        </a>
                    </th>
                    <th scope="col">
                        <a class="link-dark link-underline-opacity-0 d-flex justify-content-between align-items-center"
                            href="?sort_price={{ request('sort_price') == 'desc' ? 'asc' : 'desc' }}">
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
                        İnternetten mi?
                    </th>
                    <th scope="col">
                        <a class="link-dark link-underline-opacity-0 d-flex justify-content-between align-items-center"
                            href="?sort_created_at={{ request('sort_created_at') == 'desc' ? 'asc' : 'desc' }}">
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
                @forelse ($orderTickets as $orderTicket)
                    <tr class="align-middle">
                        <td>{{ $orderTicket->id }}</td>
                        <td>{{ $orderTicket->code }}</td>
                        <td>{{ $orderTicket->ticketTime->ticket->name }}</td>
                        <td class="text-center">{{ $orderTicket->ticketTime->name }}</td>
                        <td class="text-end">{{ $orderTicket->quantity }}</td>
                        <td class="text-end">
                            {{ $orderTicket->price }}
                            {{ $orderTicket->ticketTime->currency }}
                        </td>
                        <td>
                            <span class="badge bg-success rounded-pill">{{ $orderTicket->status }}</span>
                        </td>
                        <td>
                            @if ($orderTicket->is_online)
                                <span class="badge bg-success rounded-pill">Evet</span>
                            @else
                                <span class="badge bg-danger rounded-pill">Hayır</span>
                            @endif
                        </td>
                        <td>{{ $orderTicket->created_at }}</td>
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
    {{ $orderTickets->links() }}
@endsection
