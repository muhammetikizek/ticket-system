<template>
    <div class="row">
        <div class="col-md-3">
            <div class="card border-0 rounded-4 bg-white shadow mb-4 p-4">
                <ul
                    class="nav nav-pills nav-justified mb-5 bg-info-subtle rounded-pill p-1"
                >
                    <li class="nav-item">
                        <button
                            class="nav-link rounded-pill py-3"
                            :class="{ active: activeTab === 'boxOffice' }"
                            @click="activeTab = 'boxOffice'"
                        >
                            Gişe Satış
                        </button>
                    </li>
                    <li class="nav-item">
                        <button
                            class="nav-link rounded-pill py-3"
                            :class="{ active: activeTab === 'online' }"
                            @click="activeTab = 'online'"
                        >
                            Bilet Bul
                        </button>
                    </li>
                </ul>

                <div v-if="activeTab === 'boxOffice'">
                    <div
                        v-if="alert.show"
                        class="alert"
                        v-bind:class="{
                            'alert-success': alert.success,
                            'alert-danger': !alert.success,
                        }"
                    >
                        {{ alert.message }}
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label fw-bold">Bilet</label>
                        <select
                            class="form-select form-select-lg border-secondary shadow-sm rounded-1"
                            v-model="form.ticketId"
                            v-bind:class="{
                                'is-invalid border-danger': errors.ticketId,
                            }"
                        >
                            <option disabled selected>Bilet Türü</option>
                            <option
                                v-for="(ticket, index) in tickets"
                                :key="index"
                                :value="ticket.id"
                            >
                                {{ ticket.name }}
                            </option>
                        </select>
                        <div v-if="errors.ticketId" class="invalid-feedback">
                            {{ errors.ticketId[0] }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label fw-bold">Saat</label>
                        <select
                            class="form-select form-select-lg border-secondary shadow-sm rounded-1"
                            v-model="form.ticketTimeId"
                            :class="{
                                'is-invalid border-danger': errors.ticketTimeId,
                            }"
                            v-bind:disabled="!ticketTimes.length"
                        >
                            <option selected disabled>Saat Seç</option>
                            <option
                                v-for="ticketTime in ticketTimes"
                                :key="ticketTime.id"
                                :value="ticketTime.id"
                                v-bind:disabled="!ticketTime.remaining_quantity"
                            >
                                {{ ticketTime.name }} (
                                {{ ticketTime.quantity }} /
                                {{ ticketTime.remaining_quantity }}
                                adet kaldı. )
                            </option>
                        </select>
                        <div
                            v-if="errors.ticketTimeId"
                            class="invalid-feedback"
                        >
                            {{ errors.ticketTimeId[0] }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label fw-bold">Adet</label>
                        <input
                            type="numeric"
                            class="form-control form-control-lg border-secondary shadow-sm rounded-1"
                            v-model="form.quantity"
                            v-bind:class="{
                                'is-invalid border-danger': errors.quantity,
                            }"
                            :disabled="!quantityIsCustom"
                        />
                        <div v-if="errors.quantity" class="invalid-feedback">
                            {{ errors.quantity[0] }}
                        </div>
                        <div class="form-check mt-2">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="checkQuantity"
                                v-model="quantityIsCustom"
                            />
                            <label class="form-check-label" for="checkQuantity">
                                Özel miktar belirtmek istiyorum
                            </label>
                        </div>
                    </div>
                    <div>
                        <button
                            class="btn btn-lg btn-warning rounded-1 w-100 py-3 border-secondary bg-gradient"
                            @click="createOrderTicket"
                        >
                            <i
                                class="fa-solid fa-spinner fa-spin-pulse"
                                v-if="spinner"
                            ></i>
                            Bilet Ekle
                        </button>
                    </div>
                </div>
                <div v-if="activeTab === 'online'">
                    İnternet satışı yapılmış bilet sorgulama formu
                </div>
            </div>
        </div>
        <!-- .col-md -->

        <div class="col">
            <div class="card rounded-4 border-0 shadow mb-4">
                <div class="card-header h5 my-auto py-3">Sipariş Listesi</div>
                <div class="pb-3">
                    <div
                        class="d-flex justify-content-center align-items-center"
                        v-if="!orderTickets.length"
                    >
                        <h4 class="text-muted my-auto mt-3">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            Bilet listesi
                        </h4>
                    </div>
                    <div
                        class="table-responsive overflow-auto"
                        style="max-height: 500px"
                    >
                        <table
                            class="table table-striped table-borderless table-hover"
                            v-if="orderTickets.length"
                        >
                            <thead
                                class="sticky-top border-bottom border-dark-subtle shadow align-middle"
                            >
                                <tr>
                                    <th scope="col" class="py-4"></th>
                                    <th scope="col">
                                        Bilet ({{ orderTickets.length }})
                                    </th>
                                    <th scope="col">Saat</th>
                                    <th scope="col">Adet</th>
                                    <th scope="col">Tutar</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-if="orderTickets.length > 0"
                                    v-for="(orderTicket, index) in orderTickets"
                                    :key="index"
                                    class="align-middle"
                                >
                                    <td class="text-center">{{ ++index }}</td>
                                    <td>
                                        {{
                                            orderTicket.ticket_time.ticket.name
                                        }}
                                    </td>
                                    <td>
                                        {{ orderTicket.ticket_time.name }}
                                    </td>
                                    <td>
                                        {{ orderTicket.quantity }}
                                    </td>
                                    <td>
                                        <h5 class="text-secondary my-auto">
                                            ₺ {{ orderTicket.price }}
                                        </h5>
                                    </td>
                                    <td>
                                        <button
                                            type="button"
                                            class="btn btn-outline-danger py-2 rounded-pill"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal"
                                            @click="
                                                confirmDeleteOrderTicket(
                                                    orderTicket
                                                )
                                            "
                                        >
                                            <i
                                                class="fa-regular fa-trash-can fa-lg"
                                            ></i>
                                            Sil
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- .col-md -->

        <div class="col-xl">
            <div class="card rounded-4 border-0 shadow mb-4">
                <h5 class="card-header bg-info-subtle py-3 rounded-top-4">
                    Toplam Tutar
                </h5>
                <div class="card-body">
                    <h3 class="my-auto">{{ totalPrice }}</h3>
                </div>
            </div>
            <div class="card rounded-4 border-0 shadow mb-4">
                <h3 class="card-header bg-info-subtle py-3 rounded-top-4">
                    Ödeme
                </h3>
                <div class="card-body">
                    <div v-if="isModalOpen">
                        burada müşteri bilgileri olmalı
                    </div>
                    <button
                    v-if="orderTickets.length"
                        class="btn btn-lg btn-success rounded-pill py-3 px-4"
                        @click="addVisitorOpenModal"
                    >
                        Nakit Ödeme
                    </button>

                </div>
            </div>
        </div>
        <!-- .col-md -->
    </div>
    <!-- .row -->

    <div v-if="isModalOpen" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <p>Modal body text goes here.</p>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Close
                    </button>
                    <button type="button" class="btn btn-primary">
                        Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        storeId: {
            type: Number,
            required: true,
        },
    },
    data() {
        return {
            isModalOpen: false,
            totalPrice: 0,
            visitors: [],
            orderTickets: {},
            activeTab: "boxOffice",
            spinner: false,
            form: {
                ticketId: null,
                ticketTimeId: null,
                quantity: 1,
            },
            quantityIsCustom: false,
            ticketTimes: [],
            errors: {},
            tickets: {},
            alert: {
                show: false,
                success: true,
                message: "",
            },
        };
    },
    methods: {
        addVisitorOpenModal() {
            this.isModalOpen = !this.isModalOpen;
        },
        async getOrderTickets() {
            await axios
                .get("api/orders/tickets")
                .then((response) => {
                    this.orderTickets = response.data.data.orderTickets;
                    this.totalPrice = response.data.data.totalPrice;
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {
                    this.spinner = false;
                });
        },
        async confirmDeleteOrderTicket(orderTicket) {
            this.$swal({
                title: "Bilet kaldırılacak",
                text: "Bilet listeden kaldırılacak. Emin misiniz?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Evet",
                cancelButtonText: "Hayır",
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.orderTicket = orderTicket;
                    this.deleteOrderTicket();
                }
            });
        },
        async deleteOrderTicket() {
            await axios
                .delete("/api/orders/tickets/" + this.orderTicket.id)
                .then((response) => {
                    this.getOrderTickets();
                    this.getTicketTimes();
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        this.$swal({
                            title: "Bilet silinemedi",
                            text: "Bilet silinemedi. Lütfen tekrar deneyin.",
                            icon: "error",
                            confirmButtonText: "Tamam",
                            confirmButtonColor: "#3085d6",
                        });
                        this.spinner = false;
                        this.errors = error.response.data.errors;
                    }
                });
        },
        async getTickets() {
            try {
                await axios
                    .get("api/tickets", {
                        headers: {
                            storeId: this.form.storeId,
                        },
                    })
                    .then((response) => {
                        this.tickets = response.data.data;
                    })
                    .catch((error) => {
                        console.error(error);
                    })
                    .finally(() => {
                        this.spinner = false;
                    });
            } catch (error) {
                console.error(error);
            }
        },
        createOrderTicket() {
            this.spinner = true;
            this.errors = {};
            axios
                .post("/api/orders/tickets", this.form, {
                    headers: {
                        storeId: this.storeId,
                    },
                })
                .then((response) => {
                    this.quantityIsCustom = false;
                    this.spinner = false;
                    this.errors = {};
                    this.$swal({
                        title: "Bilet eklendi",
                        text: "Bilet başarıyla eklendi.",
                        icon: "success",
                        confirmButtonText: "Tamam",
                        confirmButtonColor: "#3085d6",
                    });
                    this.getTicketTimes();
                    this.getOrderTickets();
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        this.$swal({
                            title: "Bilet eklenemedi",
                            text: "Bilet eklenemedi. Lütfen formu kontrol edin.",
                            icon: "error",
                            confirmButtonText: "Tamam",
                            confirmButtonColor: "#3085d6",
                        });
                        this.spinner = false;
                        this.errors = error.response.data.errors;
                    }
                })
                .finally(() => {
                    this.spinner = false;
                });
        },
        async getTicketTimes() {
            await axios
                .get("api/tickets/times", {
                    params: {
                        ticketId: this.form.ticketId,
                    },
                    headers: {
                        storeId: this.form.storeId,
                    },
                })
                .then((response) => {
                    this.ticketTimes = response.data.data;
                })
                .catch((error) => {
                    console.error(error.response.data.errors);
                })
                .finally(() => {
                    this.spinner = false;
                });
        },
        alertMessage(message, success = true) {
            this.alert.show = true;
            this.alert.success = success;
            this.alert.message = message;
        },
    },
    watch: {
        "form.ticketId": function (newTicketId, oldTicketId) {
            if (newTicketId !== oldTicketId) {
                axios
                    .get("api/tickets/times", {
                        params: {
                            ticketId: newTicketId,
                        },
                        headers: {
                            storeId: this.form.storeId,
                        },
                    })
                    .then((response) => {
                        this.ticketTimes = response.data.data;
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            }
        },
        quantityIsCustom: function (newQuantityIsCustom, oldQuantityIsCustom) {
            if (newQuantityIsCustom !== oldQuantityIsCustom) {
                this.form.quantity = 1;
            }
            this.errors.quantity = null;
        },
    },
    mounted() {
        this.getTickets();
        this.getOrderTickets();
    },
};
</script>
