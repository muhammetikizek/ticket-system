<nav class="navbar navbar-expand-lg py-4 bg-dark mb-4"  style="--bs-bg-opacity: .2;" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="https://media.discordapp.net/attachments/1167388098599075840/1172461882758660146/logo-white.png?ex=65606738&amp;is=654df238&amp;hm=98c8c0406eb53ad7b89466cef793ec5ec9e311617cd20bc27d4451a364d622f6&amp;="
                class="logo-image" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="me-auto mb-2 mb-lg-0">
                <button type="button" class="btn btn-lg btn-primary bg-transparent border-2 rounded-pill"
                    data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    {{ auth()->guard('user')->user()->lastUsedStore->name }}
                </button>
            </div>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active fw-bold"
                        href="#">{{ auth()->guard('user')->user()->name ?? 'Ziyaretçi' }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout')}}">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        Çıkış Yap
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Müze Değiştir</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body rounded-4">
                <div class="list-group list-group-flush">
                    @foreach ($stores as $store)
                    <a class="list-group-item list-group-item-action d-flex justify-content-between py-3 rounded-1 mb-3 border-0 {{ $store->id != session('storeId') ?: 'active disabled' }}"
                        href="{{ route('store.switch', $store->id) }}">
                        <span>{{ $store->name }}</span>
                        <span>
                            @if (session('storeId') == $store->id)
                            <i class="fa-regular fa-circle-check fa-lg"></i>
                            @endif
                        </span>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
