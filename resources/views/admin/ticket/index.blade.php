@extends('admin.layouts.master')

@section('title', 'Bilet Listesi')

@section('options')
    <a class="btn btn-warning" href="{{ route('admin.ticket.create') }}">Bilet Oluştur</a>
@endsection

@section('content')

    <div class="table-responsive">
        <table class="table table-striped table-bordered border-dark-subtle">
            <thead class="table-info align-middle">
                <tr>
                    <th scope="col" class="py-4"></th>
                    <th scope="col">Bilet</th>
                    <th scope="col">Açıklama</th>
                    <th scope="col">Satışa Açık mı?</th>
                    <th scope="col">Oluşturma Tarihi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $ticket)
                    <tr class="align-middle">
                        <td>
                            <div class="dropdown">
                                <button class="btn bg-transparent" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis fa-lg"></i></button>
                                <ul class="dropdown-menu">
                                    <li class="d-flex justify-content-between"><a class="dropdown-item"
                                            href="{{ route('admin.ticket.edit', $ticket->id) }}">
                                            <i class="fa fa-pencil fa-sm me-2"></i> Düzenle</a></li>
                                    <li class="d-flex justify-content-between"><a class="dropdown-item" href="#">
                                            <i class="fa fa-clock fa-sm me-2"></i> Saatler</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li class="d-flex justify-content-between"><a class="dropdown-item link-danger" href="#">
                                            <i class="fa fa-trash fa-sm me-2"></i> Sil</a></li>
                                </ul>
                            </div>
                            </th>
                        <td>{{ $ticket->name }}</td>
                        <td>{{ $ticket->description }}</td>
                        <td>
                            @if ($ticket->enabled)
                                <span class="badge bg-success rounded-pill">Evet</span>
                            @else
                                <span class="badge bg-danger rounded-pill">Hayır</span>
                            @endif
                        </td>
                        <td>{{ $ticket->created_at }}</td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            <table class="table table-warning table-striped table-bordered border-dark-subtle my-auto">
                                <thead>
                                    <tr>
                                        <th scope="col">Saat</th>
                                        <th scope="col">Miktar</th>
                                        <th scope="col">Fiyat</th>
                                        <th scope="col">Son Güncelleme</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ticket->times as $time)
                                        <tr>
                                            <td>{{ $time->name }}</td>
                                            <td>{{ $time->quantity }}</td>
                                            <td>{{ $time->price }} {{ $time->currency }}</td>
                                            <td>{{ $time->updated_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
