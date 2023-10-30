<script>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
export default {
    components: {
        AuthenticatedLayout, Head,
        InputLabel,
        TextInput,
        InputError,
        PrimaryButton
    },
    props: {
        companies: Object
    },
    data() {
        return {
            form: {
                first_name: '',
                last_name: '',
                company_id: '',
                email: '',
                phone: '',
            },
            errors: {
                first_name: [],
                last_name: [],
                company_id: [],
                email: [],
                phone: [],
            },
        };
    },
    methods: {
        submit() {
            axios.post(route('employees.store'), this.form)
                .then(response => {
                    this.resetForm();
                    window.location.href = route('employees.index');
                })
                .catch(error => {
                    this.errors = error.response.data.errors
                });
        },
        resetForm() {
            this.form = {
                first_name: '',
                last_name: '',
                company_id: '',
                email: '',
                phone: '',
            }
            this.errors = {
                first_name: [],
                last_name: [],
                company_id: [],
                email: [],
                phone: [],
            }
        }
    }
}
</script>

<template>
    <Head title="Add Employee" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Employee</h2>
        </template>
        <div class="container py-12">
            <div class="w-full mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <form @submit.prevent="submit">
                    <div class="row gap-y-5">
                        <div class="col-md-6">
                            <div>
                                <InputLabel for="first_name" value="First Name" />

                                <TextInput id="first_name" type="text" class="mt-1 block w-full" v-model="form.first_name"
                                    autofocus autocomplete="first_name" />

                                <InputError class="mt-2" :message="errors.first_name" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <InputLabel for="last_name" value="Last Name" />

                                <TextInput id="last_name" type="text" class="mt-1 block w-full" v-model="form.last_name"
                                    autofocus autocomplete="last_name" />

                                <InputError class="mt-2" :message="errors.last_name" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <InputLabel for="company_id" value="Company" />

                                <select v-model="form.company_id" id="company_id"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm  mt-1 block w-full">
                                    <option value="">Select Company</option>
                                    <option v-for="(company, index) in companies" :key="index" :value="index">
                                        {{ company }}
                                    </option>
                                </select>

                                <InputError class="mt-2" :message="errors.company_id" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <InputLabel for="email" value="Email" />

                                <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email"
                                    autocomplete="username" />

                                <InputError class="mt-2" :message="errors.email" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <InputLabel for="phone" value="Phone" />

                                <TextInput id="phone" type="text" class="mt-1 block w-full" v-model="form.phone"
                                    autocomplete="phone" />

                                <InputError class="mt-2" :message="errors.phone" />
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Save
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
