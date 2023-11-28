@extends('admin.layouts.master')

@section('title', 'Bilet Oluştur')

@section('content')

    <div class="alert" v-bind:class="{ 'alert-success': alert.success, 'alert-danger': !alert.success }" v-if="alert.show">@{{ alert.message }}</div>
    <form @submit.prevent="submitForm">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Müze</label>
                    <select class="form-select" v-model="form.store_id" v-bind:class="{ 'is-invalid': errors.store_id }">
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
                    <input type="text" class="form-control" v-model="form.name"
                        v-bind:class="{ 'is-invalid': errors.name }">
                    <div v-if="errors.name" class="invalid-feedback">
                        @{{ errors.name[0] }}
                    </div>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Bilet Açıklaması</label>
                    <textarea class="form-control" id="" rows="3"></textarea>
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
                                            <i class="fa-solid fa-minus"></i>
                                        </button>
                                        <button class="btn btn-info rounded-1" type="button" @click="addTimeRow">
                                            <i class="fa-regular fa-plus"></i>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <input type="time" v-model="row.time" class="form-control">
                                </td>
                                <td>
                                    <input type="number" v-model="row.quantity" class="form-control">
                                </td>
                                <td>
                                    <input type="text" v-model="row.price" class="form-control">
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
                        message: '',
                        success: true
                    }
                }
            },
            methods: {
                submitForm() {
                    this.spinner = true;
                    this.form.times = this.rows;
                    axios.post("{{ route('api.ticket.create') }}", this.form, {
                            headers: {
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => {
                            this.spinner = false;
                            this.alert.show = true;
                            this.alert.message = 'Bilet başarıyla oluşturuldu.';
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
                }
            }
        });
        app.mount('#app');
    </script>
@endpush
