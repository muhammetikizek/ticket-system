@extends('layouts.master')

@section('title', 'Bilet Satışı')

@section('content')

<div class="row">
    <div class="col-md-3">

        <div class="card rounded-3 bg-white shadow mb-4 p-4">

            <ul class="nav nav-pills nav-justified mb-5 bg-info-subtle rounded-pill p-1" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill py-3 active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Gişe</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill py-3" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Online</button>
                </li>
            </ul>

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                    <div v-if="alert.show" class="alert" v-bind:class="{'alert-success': alert.success, 'alert-danger': !alert.success}">
                        @{{ alert.message }}
                    </div>
                    <order-ticket-create-form/>
                    <div class="mb-3">
                        <label class="col-form-label fw-bold">Bilet</label>
                        <select class="form-select form-select-lg border-secondary shadow-sm rounded-1" v-model="formData.ticketId" v-bind:class="{'is-invalid border-danger': errors.ticketId}">
                            <option disabled selected>Bilet Türü</option>
                            @foreach ($tickets as $ticket)
                            <option value="{{ $ticket->id }}">
                                {{ $ticket->name }}
                            </option>
                            @endforeach
                        </select>
                        <div v-if="errors.ticketId" class="invalid-feedback">
                            @{{ errors.ticketId[0] }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label fw-bold">Saat</label>
                        <select class="form-select form-select-lg border-secondary shadow-sm rounded-1" v-model="formData.ticketTimeId" :class="{'is-invalid border-danger': errors.ticketTimeId}" v-bind:disabled="!ticketTimes.length">
                            <option selected disabled>Saat Seç</option>
                            <option v-for="ticketTime in ticketTimes" :key="ticketTime.id" :value="ticketTime.id" v-bind:disabled="!ticketTime.remaining_quantity">
                                @{{ ticketTime.name }}
                                (
                                @{{ ticketTime.quantity }} / @{{ ticketTime.remaining_quantity }}
                                adet kaldı.
                                )
                            </option>
                        </select>
                        <div v-if="errors.ticketTimeId" class="invalid-feedback">
                            @{{ errors.ticketTimeId[0] }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label fw-bold">Adet</label>
                        <input type="numeric" class="form-control form-control-lg border-secondary shadow-sm rounded-1" v-model="formData.quantity" v-bind:class="{ 'is-invalid border-danger': errors.quantity }" :disabled="!quantityIsCustom">
                        <div v-if="errors.quantity" class="invalid-feedback">
                            @{{ errors.quantity[0] }}
                        </div>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" id="checkQuantity" v-model="quantityIsCustom">
                            <label class="form-check-label" for="checkQuantity">
                                Özel miktar belirtmek istiyorum
                            </label>
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-lg btn-warning rounded-1 w-100 py-3 border-secondary bg-gradient" @click="createOrder">
                            <i class="fa-solid fa-spinner fa-spin-pulse" v-if="spinnerCreateOrder"></i>
                            Bilet Ekle
                        </button>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                    <div class="mb-3">
                        <input type="text" class="form-control form-control-lg rounded-1" v-model="orderFindSearchInput" v-bind:class="{ 'is-invalid': errorMessage, 'border-secondary': !errorMessage }" placeholder="Ürün adı veya barkod numarası giriniz.">
                        <div v-if="errorMessage" class="invalid-feedback">
                            @{{ errorMessage }}
                        </div>
                    </div>
                    <div class="">
                        <button class="btn btn-lg btn-warning rounded-1 w-100 py-3 border-secondary bg-gradient" type="button" @click="findOrder" v-bind:disabled="!orderFindSearchInput || orderFindLoader">
                            <span class="spinner-border spinner-border-sm my-auto" v-if="orderFindLoader"></span>
                            <span v-if="!orderFindLoader">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                Bilet Bul
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .col-md -->
    <div class="col-md-6">
        <div v-if="alert.show" class="alert" v-bind:class="{'alert-success': alert.success, 'alert-danger': !alert.success}">
            @{{ alert.message }}
        </div>
        <div class="bg-white rounded-3 shadow py-3 mb-4">
            <div class="d-flex justify-content-center align-items-center h-100" v-if="!orderTickets.length">
                <h1 class="text-muted my-auto">
                    <i class="fa-solid fa-circle-exclamation text-warning"></i>
                    Bilet listesi
                </h1>
            </div>

            <div class="table-responsive overflow-auto" style="max-height:450px;">
                <table class="table table-striped table-borderless table-hover" v-if="orderTickets.length">
                    <thead class="sticky-top border-bottom border-dark-subtle shadow align-middle">
                        <tr>
                            <th scope="col" class="py-4"></th>
                            <th scope="col">Bilet (@{{ orderTickets.length }})</th>
                            <th scope="col">Saat</th>
                            <th scope="col">Adet</th>
                            <th scope="col">Tutar</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="orderTickets.length > 0" v-for="(orderTicket, index) in orderTickets" :key="index" class="align-middle">
                            <td class="text-center">@{{ ++index }}</td>
                            <td>
                                @{{ orderTicket.ticket_time.ticket.name }}
                            </td>
                            <td>
                                @{{ orderTicket.ticket_time.name }}
                            </td>
                            <td>
                                @{{ orderTicket.quantity }}
                            </td>
                            <td>
                                <h5 class="text-secondary my-auto">₺ @{{ orderTicket.price }}</h5>
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-danger py-2 rounded-pill" data-bs-toggle="modal" data-bs-target="#deleteModal" @click="openDeleteModal(orderTicket)">
                                    <i class="fa-regular fa-trash-can fa-lg"></i>
                                    Kaldır
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div><!-- .col-md -->
    <div class="col-12 col-md-6 col-lg-3">

        <div class="row">
            <div class="col-sm-6">
                <div class="bg-white rounded-3 p-3 mb-4">
                    <div class="row d-flex justify-content-between align-items-center">
                        <div class="col-md-auto">
                            <i class="fa-solid fa-globe fa-xl"></i>
                        </div><!-- .col-md -->
                        <div class="col-md">
                            <h6 class="my-auto fw-bold text-muted">Online Satışlar</h6>
                            <h1 class="fw-bold my-auto">{{ $onlineOrderCount }}</h1>
                        </div><!-- .col-md -->
                    </div><!-- .row -->
                </div>
            </div><!-- .col-md -->
            <div class="col-sm-6">
                <div class="bg-white rounded-3 p-3 mb-4">
                    <div class="row d-flex justify-content-between align-items-center">
                        <div class="col-md-auto">
                            <i class="fa-solid fa-cash-register fa-xl"></i>
                        </div><!-- .col-md -->
                        <div class="col-md">
                            <h6 class="my-auto fw-bold text-muted">Gişe Satışlar</h6>
                            <h1 class="fw-bold my-auto">{{ $onsiteOrderCount }}</h1>
                        </div><!-- .col-md -->
                    </div><!-- .row -->
                </div>
            </div><!-- .col-md -->
            <div class="col-sm-6">
                <div class="bg-white rounded-3 p-3 mb-4">
                    <div class="row d-flex justify-content-between align-items-center">
                        <div class="col-md-auto">
                            <i class="fa-regular fa-calendar-days fa-xl"></i>
                        </div><!-- .col-md -->
                        <div class="col-md">
                            <h6 class="my-auto fw-bold text-muted">Bugün</h6>
                            <h1 class="fw-bold my-auto">{{ $todayTotalOrderCount }}</h1>
                        </div><!-- .col-md -->
                    </div><!-- .row -->
                </div>
            </div><!-- .col-md -->

        </div><!-- .row -->

        <div class="card border-0 rounded-3 p-5">

            <ul class="list-group list-group-flush mb-4">
                <li class="list-group-item d-flex justify-content-between align-items-center px-0 d-none">
                    <h6 class="my-auto">İndirim:</h6>
                    <h6>0,00 TL</h6>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center px-0 d-none">
                    <h6 class="my-auto">KDV:</h6>
                    <h6>0,00 TL</h6>
                </li>
                <li class="list-group-item px-0">
                    <h6 class="text-muted">Toplam Fiyatı</h6>
                    <h2 class="fw-bold text-success">@{{ totalPrice }} TL</h2>
                </li>
            </ul>

            <div class="row gap-0 row-gap-4">

                <div class="col-sm-12 col-xl-6">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-success w-100 py-3 rounded-1" data-bs-toggle="modal" data-bs-target="#cashPaymentPopup">
                        Nakit
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="cashPaymentPopup" tabindex="-1" aria-labelledby="cashPaymentPopupLabel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="cashPaymentPopupLabel">Nakit Ödeme</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-0">
                                    <div v-if="alert.show" class="alert m-4" v-bind:class="{'alert-success': alert.success, 'alert-danger': !alert.success}">
                                        @{{ alert.message }}
                                    </div>
                                    <div class="bg-black-subtle" v-for="(orderTicket, index) in orderTickets" :key="index">
                                        <div class="bg-dark-subtle bg-gradient sticky-top shadow-sm border-bottom border-dark-subtle p-4">
                                            <div class="row">
                                                <div class="col-md">
                                                    <strong>Bilet:</strong> @{{ orderTicket.ticket_time.ticket.name }}
                                                </div>
                                                <div class="col-md">
                                                    <strong>Saat:</strong> @{{ orderTicket.ticket_time.name }}
                                                </div>
                                                <div class="col-md">
                                                    <strong>Adet:</strong> @{{ orderTicket.quantity }}
                                                </div>
                                                <div class="col-md">
                                                    <strong>Tutar:</strong> ₺ @{{ orderTicket.price }}
                                                </div>
                                            </div><!-- .row -->
                                        </div>
                                        <ul class="list-group list-group-flush mt-4">
                                            <li class="list-group-item py-3" v-for="(quantity, i) in orderTicket.quantity" :key="i">
                                                <div class="row gap-0 d-flex justify-content-center align-items-center">
                                                    <div class="col-md">
                                                    </div>
                                                    <div class="col-md">
                                                        <input type="text" v-model="customers[0].name" class="form-control form-control-lg border-secondary rounded-1" placeholder="Ad:">
                                                    </div>
                                                    <div class="col-md">
                                                        <input type="text" class="form-control form-control-lg border-secondary rounded-1" placeholder="Soyad">
                                                    </div>
                                                    <div class="col-md">
                                                        <input type="email" class="form-control form-control-lg border-secondary rounded-1" placeholder="Email">
                                                    </div>
                                                    <div class="col-md">
                                                        <input type="text" class="form-control form-control-lg border-secondary rounded-1" placeholder="Telefon Numarası">
                                                    </div>
                                                </div><!-- .row -->
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary py-3 px-4 rounded-1" data-bs-dismiss="modal">Vazgeç</button>
                                    <button type="button" class="btn btn-success py-3 px-4 rounded-1" @click="completeCashOrderPayment">
                                        <span class="spinner-border spinner-border-sm my-auto" v-if="spinner"></span>
                                        Bilet Yazdır
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- .col-md -->
                <div class="col-sm-12 col-xl-6">
                    <button class="btn btn-primary w-100 py-3 rounded-1" type="button">
                        POS
                    </button>
                </div><!-- .col-md -->

            </div><!-- .row -->
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel">
    <div class="modal-dialog">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteModalLabel">Silmek istiyor musunuz?</h1>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item border-secondary-subtle bg-transparent d-flex justify-content-between">
                    Bilet:
                    <span>@{{ orderTicket.ticket_time }}</span>
                </li>
                <li class="list-group-item border-secondary-subtle bg-transparent d-flex justify-content-between">
                    Bilet Kodu: <span>@{{ orderTicket.code }}</span>
                </li>
                <li class="list-group-item border-secondary-subtle bg-transparent d-flex justify-content-between align-items-center">
                    Adet: <h5 class="my-auto">@{{ orderTicket.quantity }}</h5>
                </li>
                <li class="list-group-item border-secondary-subtle bg-transparent d-flex justify-content-between align-items-center">
                    Fiyat: <h2 class="h4 my-auto">₺ @{{ orderTicket.price }}</h2>
                </li>
            </ul>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-lg rounded-1 w-100" data-bs-dismiss="modal">Vazgeç</button>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-lg btn-danger rounded-1 w-100" @click="deleteOrderTicket" v-bind:disabled="orderTicketIsDeleted">Sil</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
@endpush

@push('scripts')
<script>
    const app = Vue.createApp({
        data() {
            return {
                customers: [{
                    orderTicketId: null,
                    name: "",
                }],
                spinner: false,
                totalPrice: 0,
                errorMessage: null,
                successMessage: null,
                formData: {
                    storeId: "{{ session('storeId') }}",
                    ticketId: null,
                    ticketTimeId: null,
                    quantity: 1,
                },
                ticketTimes: {},
                orderTicket: {},
                orderTickets: {},
                errors: {},
                orderFindSearchInput: "",
                orderFindLoader: false,
                spinnerCreateOrder: false,
                alert: {
                    show: false,
                    success: true,
                    message: ""
                },
                quantityIsCustom: false,
                orderTicketIsDeleted: false,
            }
        },
        methods: {
            async completeCashOrderPayment() {
                this.spinner = true;
                const response = await axios.post("{{ route('api.order.payment.cash') }}", {
                        orderTicketIds: this.orderTickets.map(order => order.id),
                        customers: this.customers,
                    })
                    .then(response => {
                        this.alertMessage('Bilet hazırlanıyor...');
                        console.log(this.customers);
                        if (response.data.success) {
                            window.location.href = response.data.file;
                        }
                    })
                    .catch(error => {
                        this.alertMessage(error.response.data.error, false);
                    })
                    .finally(() => {
                        this.spinner = false;
                    });
            },
            async getTicketTimes() {
                await axios.get("{{ route('api.ticket.times') }}", {
                        params: {
                            ticketId: this.formData.ticketId
                        },
                        headers: {
                            'storeId': this.formData.storeId,
                        }
                    })
                    .then(response => {
                        this.ticketTimes = response.data.data;
                    })
                    .catch(error => {
                        console.error(error.response.data.errors);
                    })
                    .finally(() => {
                        this.spinner = false;
                    });
            },
            async createOrder() {
                this.spinnerCreateOrder = true;
                axios.post("{{ route('api.order.create') }}", this.formData)
                    .then(response => {
                        this.formData.quantity = 1;
                        this.alertMessage('Bilet listeye eklendi.');
                        this.orderTickets.push(response.data.data);
                        this.errors = {};
                        this.customers.push({
                            orderTicketId: response.data.data.id,
                            name: "",
                        });
                    })
                    .catch(error => {
                        if (error.response.status === 422) {
                            this.alertMessage(error.response.data.message, false);
                            this.errors = error.response.data.errors;
                        }
                    })
                    .finally(() => {
                        this.spinnerCreateOrder = false;
                        this.getOrdersWithStatusPending();
                        this.getTicketTimes();
                    })
            },
            async getOrdersWithStatusPending() {
                await axios.get("{{ route('api.order.status.pending') }}")
                    .then(response => {
                        this.orderTickets = response.data.data;
                        this.totalPrice = response.data.totalPrice;
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors;
                    })
                    .finally(() => {
                        this.spinner = false;
                    })
            },
            async findOrder() {
                if (this.orderFindSearchInput) {
                    this.orderFindLoader = true;
                    const response = await axios.get('/api/externals/orders', {
                            params: {
                                search: this.orderFindSearchInput,
                            }
                        })
                        .then(response => {
                            this.onlineOrders = Array.isArray(response.data) ? response.data : [response
                                .data
                            ];
                            this.orderFindLoader = false;
                        }).catch(error => {
                            this.alertMessage(error.response.data.error, false);
                        }).finally(() => {
                            this.orderFindLoader = false;
                        });
                }
            },
            openDeleteModal(orderTicket) {
                this.orderTicket = orderTicket;
                this.orderTicketIsDeleted = false;
            },
            async deleteOrderTicket() {
                await axios.delete('/api/orders/tickets/' + this.orderTicket.id)
                    .then(response => {
                        this.getOrdersWithStatusPending();
                        this.getTicketTimes();
                        this.orderTicketIsDeleted = true;
                        deleteModal.hide();
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors;
                    })
                    .finally(() => {
                        this.alertMessage('Bilet listeden kaldırıldı.');
                    })
            },
            async createTicketSubmit() {
                try {
                    this.getOrdersWithStatus();
                    axios.post("{{ route('order.store') }}", this.formData)
                        .then(response => {
                            this.formData = {};
                            $('#exampleModal').modal('hide');
                        })
                        .catch(error => {
                            if (error.response.status === 422) {
                                this.errors = error.response.data.errors;
                            }
                        });
                } catch (error) {
                    this.alertMessage(error.response.data.error, false);
                }
            },
            /**
             * @param {string} message
             * @param {boolean} success
             */
            async alertMessage(message, success = true) {
                this.alert.show = true;
                this.alert.success = success;
                this.alert.message = message;
            },
        },
        watch: {
            'formData.ticketId': function(newTicketId, oldTicketId) {
                this.spinnerTicketTimes = true;
                if (newTicketId !== oldTicketId) {
                    axios.get("{{ route('api.ticket.times') }}", {
                            params: {
                                ticketId: newTicketId,
                            },
                            headers: {
                                'storeId': this.formData.storeId,
                            }
                        })
                        .then(response => {
                            this.ticketTimes = response.data.data;
                            this.spinnerTicketTimes = false;
                        })
                        .catch(error => {
                            console.error(error);
                        });
                }
            },
            'quantityIsCustom': function(newQuantityIsCustom, oldQuantityIsCustom) {
                if (newQuantityIsCustom !== oldQuantityIsCustom) {
                    this.formData.quantity = 1;
                }
            },
        },
        computed: {},
        mounted() {
            deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'), {
                keyboard: false,
                backdrop: 'static'
            });
            this.getOrdersWithStatusPending();
            this.findOrder();
        }
    });
    app.mount("#app");
</script>
@endpush
