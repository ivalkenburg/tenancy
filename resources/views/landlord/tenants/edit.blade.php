@extends('layouts.app')

@section('title', "{$tenant->name} - Edit Tenant")

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
@endpush

@section('content')
    <h1>Edit Tenant</h1>
    <form id="app" @submit.prevent="submit">
        <div>
            <label for="name">Name</label>
            <input v-model="form.name" type="text" id="name">
        </div>
        <div>
            <button type="button" @click="addDomain">Add Domain</button>
        </div>
        <div v-for="(domain, index) in form.domains" :key="index">
            <input type="text" v-model="domain.name">
            <input type="radio" v-model="defaultDomain" :value="index">
            <button type="button" @click="removeDomain(index)">X</button>
        </div>
        <button type="submit">Edit</button>
    </form>
@endsection

@push('js')
    <script>
        new Vue({
            data() {
                return {
                    form: @json($tenant),
                };
            },
            computed: {
                defaultDomain: {
                    get() {
                        const currentDefault = this.form.domains.find(domain => domain.default);
                        return currentDefault ? this.form.domains.indexOf(currentDefault) : null;
                    },
                    set(index) {
                        this.form.domains.forEach((domain, i) => domain.default = index === i)
                    },
                }
            },
            methods: {
                async submit() {
                    axios.put('{{ route('landlord.tenants.update', $tenant->id) }}', this.form)
                        .then(response => {
                            window.location = response.data.redirect || '{{ route('landlord.tenants.index') }}';
                        });
                },
                addDomain() {
                    this.form.domains.push({name: null, default: this.form.domains.length === 0});
                },
                removeDomain(index) {
                    if (this.form.domains[index].default && this.form.domains[0]) {
                        this.form.domains[0].default = true;
                    }

                    this.form.domains.splice(index, 1);
                },
            },
        }).$mount('#app');
    </script>
@endpush
