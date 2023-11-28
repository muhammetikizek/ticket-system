@extends('admin.layouts.master')

@section('title', 'Güncel Durum')
@section('content')

<div class="row">
<div class="col-md-3 p-2">
        <div class="card shadow-sm p-4 border-2 rounded-4 bg-warning-subtle">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted fw-bold">Günlük Siparişler</span>
                    <h2 class="my-auto fw-bold">{{ $widget->getTodayOrderCount() }}</h2>
                </div>
                <i class="fa-solid fa-ticket fa-2xl"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 p-2">
        <div class="card shadow-sm p-4 border-2 rounded-4 bg-warning-subtle">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted fw-bold">Toplam Bilet Satışı</span>
                    <h2 class="my-auto fw-bold">{{ $widget->getTotalOrderCount() }}</h2>
                </div>
                <i class="fa-solid fa-ticket fa-2xl"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 p-2">
        <div class="card shadow-sm p-4 border-2 rounded-4 bg-success-subtle">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted fw-bold">Toplam Gelir</span>
                    <h2 class="my-auto fw-bold">{{ $widget->getTotalOrderPrice() }}</h2>
                </div>
                <i class="fa-solid fa-wallet fa-2xl"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 p-2">
        <div class="card shadow-sm p-4 border-2 rounded-4 bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted fw-bold">{{ $widget->title = 'Online Bilet Satışlar'}}</span>
                    <h2 class="my-auto fw-bold">{{ $widget->getTotalOnlineOrderCount() }}</h2>
                </div>
                <i class="fa-solid fa-users fa-2xl"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 p-2">
        <div class="card shadow-sm p-4 border-2 rounded-4 bg-info-subtle">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted fw-bold">Toplam Müşteri</span>
                    <h2 class="my-auto fw-bold">{{ $widget->getTotalCustomerCount() }}</h2>
                </div>
                <i class="fa-solid fa-users fa-2xl"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 p-2">
        <div class="card shadow-sm p-4 border-2 rounded-4 bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted fw-bold">Onay Beklyen Siparişler</span>
                    <h2 class="my-auto fw-bold">{{ $widget->getTotalCustomerCount() }}</h2>
                </div>
                <i class="fa-solid fa-users fa-2xl"></i>
            </div>
        </div>
    </div>
</div>

@endsection


@push('styles')
<style>
    .widget {
        --bs-card-spacer-y: 1rem;
        --bs-card-spacer-x: 1rem;
        --bs-card-title-spacer-y: 0.5rem;
        --bs-card-title-color: ;
        --bs-card-subtitle-color: ;
        --bs-card-border-width: var(--bs-border-width);
        --bs-card-border-color: var(--bs-border-color-translucent);
        --bs-card-border-radius: var(--bs-border-radius);
        --bs-card-box-shadow: ;
        --bs-card-inner-border-radius: calc(var(--bs-border-radius) - (var(--bs-border-width)));
        --bs-card-cap-padding-y: 0.5rem;
        --bs-card-cap-padding-x: 1rem;
        --bs-card-cap-bg: rgba(var(--bs-body-color-rgb), 0.03);
        --bs-card-cap-color: ;
        --bs-card-height: ;
        --bs-card-color: ;
        --bs-card-bg: var(--bs-body-bg);
        --bs-card-img-overlay-padding: 1rem;
        --bs-card-group-margin: 0.75rem;
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        height: var(--bs-card-height);
        color: var(--bs-body-color);
        word-wrap: break-word;
        background-color: var(--bs-card-bg);
        background-clip: border-box;
        border: var(--bs-card-border-width) solid var(--bs-card-border-color);
        border-radius: var(--bs-card-border-radius);
    }
</style>
@endpush
