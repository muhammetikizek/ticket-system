@extends('admin.layouts.master')

@section('title', $title)

@section('content')

@section('options')
    <div class="d-flex gap-2">
        <a href="{{ route('admin.user.create') }}" class="btn btn-primary shadow-sm rounded-1">Yeni Kullanıcı</a>
    </div>
@endsection

<div class="table-responsive">
    <table class="table table-striped table-bordered border-secondary-subtle">
        <thead class="table-info">
            <tr>
                <th scope="col"></th>
                <th scope="col">Ad Soyad</th>
                <th scope="col">Email</th>
                <th scope="col">Admin</th>
                <th scope="col">Aktif</th>
                <th scope="col">Tarih</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr class="align-middle">
                    <td>
                        <div class="dropdown">
                            <button class="btn bg-transparent" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="fa-solid fa-ellipsis fa-lg"></i></button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.user.edit', $user->id) }}">Düzenle</a></li>
                                @if (auth()->guard('admin')->user()->id !== $user->id)
                                    <li><a class="dropdown-item" href="#">Sil</a></li>
                                @endif
                            </ul>
                        </div>
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge bg-{{ $user->isAdmin() ? 'success' : 'danger' }} rounded-pill">
                            {{ $user->isAdmin() ? 'Evet' : 'Hayır' }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-{{ $user->isEnabled() ? 'success' : 'danger' }} rounded-pill">
                            {{ $user->isEnabled() ? 'Evet' : 'Hayır' }}
                        </span>
                    </td>
                    <td>{{ $user->created_at }}</td>
                </tr>
            @empty
                boş
            @endforelse
        </tbody>
    </table>
</div>

@endsection
