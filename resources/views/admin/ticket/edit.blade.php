@extends('admin.layouts.master')

@section('title', 'Bilet Düzenle')

@section('content')

    <div class="alert" v-bind:class="{ 'alert-success': alert.success, 'alert-danger': !alert.success }" v-if="alert.show">
        @{{ alert.message }}</div>
    <form @submit.prevent="submitForm">
        <div class="row d-flexs justify-content-centers">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Müze</label>
                    <select class="form-select border-secondary" v-model="form.store_id"
                        v-bind:class="{ 'is-invalid': errors.store_id }">
                        <option selected disabled>Müze Seç</option>
                        @foreach ($stores as $store)
                            <option value="{{ $store->id }}">{{ $store->name }}</option>
                        @endforeach
                    </select>
                    <div v-if="errors.store_id" class="invalid-feedback">
                        @{{ errors.store_id[0] }}
                    </div>
                    <div v-if="!errors.store_id" id="storeSelectHelp" class="form-text">Bu bilet, hangi müzeye ait?</div>
                </div>
                <div class="mb-3">
                    <label for="nameInput" class="form-label">Bilet Adı</label>
                    <input type="text" class="form-control border-secondary" v-model="form.name"
                        v-bind:class="{ 'is-invalid': errors.name }">
                    <div v-if="errors.name" class="invalid-feedback">
                        @{{ errors.name[0] }}
                    </div>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Satışa Açık mı?</label>
                    <div class="btn-group d-block" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" id="enabled" v-model="form.enabled" :value="1"
                            :checked="form.enabled">
                        <label class="btn btn-outline-success" for="enabled">Evet</label>

                        <input type="radio" class="btn-check" id="disabled" v-model="form.enabled" :value="0"
                            :checked="!form.enabled">
                        <label class="btn btn-outline-danger" for="disabled">Hayır</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Bilet Açıklaması</label>
                    <textarea class="form-control border-secondary" id="" rows="3">@{{ form.description }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="" class="form-label">Bilet Satış Saatleri</label>
                    <table class="table table-striped table-borderless">
                        <thead class="table-primary">
                            <tr>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col">Saat <span>(@{{ rows.length }})</span></th>
                                <th scope="col">Adet</th>
                                <th scope="col">Fiyat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(row, index) in rows" :key="index" class="align-middle">
                                <th scope="row">@{{ index + 1 }}</th>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-danger rounded-1" type="button"
                                            @click="removeTimeRow(index)" :disabled="rows.length <= 1">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                        <button class="btn btn-info rounded-1" type="button" @click="addTimeRow">
                                            <i class="fa-regular fa-plus"></i>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <input type="time" v-model="row.time" class="form-control border-secondary"
                                        :class="{ 'is-invalid': errors && errors['times.' + index + '.time'] }">
                                    <div v-if="errors && errors['times.' + index + '.time']" class="invalid-feedback">
                                        @{{ errors['times.' + index + '.time'][0] }}
                                    </div>
                                </td>
                                <td>
                                    <input type="number" v-model="row.quantity" class="form-control border-secondary"
                                        :class="{ 'is-invalid': errors && errors['times.' + index + '.quantity'] }">
                                    <div v-if="errors && errors['times.' + index + '.quantity']" class="invalid-feedback">
                                        @{{ errors['times.' + index + '.quantity'][0] }}
                                    </div>
                                </td>
                                <td>
                                    <input type="text" v-model="row.price" class="form-control border-secondary"
                                        :class="{ 'is-invalid': errors && errors['times.' + index + '.price'] }">
                                    <div v-if="errors && errors['times.' + index + '.price']" class="invalid-feedback">
                                        @{{ errors['times.' + index + '.price'][0] }}
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-grid gap-3 d-md-block">
                    <button type="submit" class="btn btn-warning">
                        <i class="fa-solid fa-spinner fa-spin-pulse" v-if="spinner"></i>
                        Kaydet
                    </button>
                    <a class="btn btn-light" href="{{ route('admin.ticket.index') }}">Vazgeç</a>
                </div>
            </div><!-- col -->
            <div class="col-md">
                <h4 class="mb-4">Örnek Bilet</h4>
                <div class="card p-4 border-3 border-secondary shadow-lg" style="border:dashed;">
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-md-4">
                            <h2 class="fw-bold">₺ 0,00</h2>
                        </div>
                        <div class="col-md">
                            <h4>{{ $ticket->name }}</h4>
                            <h6>MUHAMMET IKIZEK</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- row -->
    </form>

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
                    form: {
                        store_id: '',
                        name: '',
                        description: '',
                        enabled: null,
                        times: [],
                    },
                    errors: {},
                    totalTimeCount: 1,
                    spinner: false,
                    rows: [{
                        time: '',
                        quantity: 1,
                        price: 0
                    }],
                    alert: {
                        show: false,
                        success: true,
                        message: "",
                    }
                }
            },
            methods: {
                getTicket() {
                    axios.get("{{ route('api.ticket.show', $ticket->id) }}")
                        .then(response => {
                            this.form = response.data.data;
                            this.rows = response.data.data.times;
                            if (this.rows.length === 0) {
                                this.addTimeRow();
                            }
                        })
                        .catch(error => {
                            this.alert.show = true;
                            this.alert.success = false;
                        })
                        .finally(() => {
                            this.spinner = false;
                        })
                },
                submitForm() {
                    this.spinner = true;
                    this.form.times = this.rows;
                    axios.put("{{ route('api.ticket.update', $ticket->id) }}", this.form, {
                            headers: {
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => {
                            this.spinner = false;
                            this.alert.show = true;
                            this.alert.message = 'Bilet başarıyla güncellendi.';
                            this.form = response.data.data;
                            this.errors = {};
                        })
                        .catch(error => {
                            this.errors = error.response.data.errors;
                            this.spinner = false;
                        })
                        .finally(() => {
                            this.spinner = false;
                        })
                },
                addTimeRow() {
                    this.rows.push({
                        time: '',
                        quantity: '',
                        price: ''
                    });
                },
                removeTimeRow(index) {
                    if (this.rows.length > 1) {
                        this.rows.splice(index, 1);
                    }
                },
                async deleteTimeRow(id) {
                    await axios.delete("{{ route('api.ticket.time.delete', $ticket->id) }}", {
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            data: {
                                id: id
                            }
                        })
                        .then(response => {
                            this.alert.show = true;
                            this.alert.success = true;
                            this.alert.message = 'Bilet satış saati başarıyla silindi.';
                            this.getTicket();
                        })
                        .catch(error => {
                            this.alert.show = true;
                            this.alert.success = false;
                            this.alert.message = 'Bilet satış saati silinirken bir hata oluştu.';
                        })
                        .finally(() => {
                            this.spinner = false;
                        });
                }
            },
            mounted() {
                this.getTicket();
            }
        });
        app.mount('#app');
    </script>
@endpush
