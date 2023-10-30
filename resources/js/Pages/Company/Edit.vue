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
        company: Object
    },
    data() {
        return {
            form: {
                name: this.company.name,
                email: this.company.email,
                website: this.company.website,
                logo: '',
            },
            imageName: '',
            errors: {
                name: [],
                email: [],
                website: [],
                logo: [],
            },
        };
    },
    methods: {
        selectLogo: () => {
            document.getElementById('file-input').click()
        },
        uploadImage(event) {
            this.imageName = event.target.files[0].name
            this.form.logo = event.target.files[0]
        },
        submit() {
            axios.post(route('companies.update', this.company.id), this.form, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(response => {
                    window.location.href = route('companies.index');
                })
                .catch(error => {
                    this.errors = error.response.data.errors
                });
        }
    }
}
</script>

<template>
    <Head title="Edit Company" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Company</h2>
        </template>
        <div class="container py-12">
            <div class="w-full mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <form @submit.prevent="submit">
                    <div class="row gap-y-5">
                        <div class="col-md-6">
                            <div>
                                <InputLabel for="name" value="Name" />

                                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" autofocus
                                    autocomplete="name" />

                                <InputError class="mt-2" :message="errors.name" />
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
                                <InputLabel for="website" value="Website" />

                                <TextInput id="website" type="text" class="mt-1 block w-full" v-model="form.website"
                                    autocomplete="website" />

                                <InputError class="mt-2" :message="errors.website" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <InputLabel for="logo" value="Logo" />

                                <div class="d-flex align-items-end gap-2">
                                    <input type="file" accept="image/*" @change="uploadImage($event)" id="file-input"
                                        class="d-none">
                                    <button type="button" for="file-input" @click="selectLogo"
                                        class="rounded-md bg-white px-2.5 py-2 mt-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Select
                                        Logo</button>
                                    <p>{{ imageName }}</p>
                                </div>

                                <InputError class="mt-2" :message="errors.logo" />
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Update
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
