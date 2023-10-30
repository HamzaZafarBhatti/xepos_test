<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ButtonLink from '@/Components/ButtonLink.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Pagination from '@/Components/Pagination.vue';

defineProps({
    companies: {
        type: Object
    },
});

const confirmingDeletion = ref(false);
const companyId = ref(null);

const confirmDeletion = (id) => {
    confirmingDeletion.value = true;
    companyId.value = id
};

const deleteCompany = () => {
    console.log(companyId.value);
    axios.delete(route('companies.destroy', companyId.value))
        .then(response => {
            console.log(response);
            closeModal()
            window.location.href = route('companies.index');
        })
        .catch(error => {
            console.log(error);
        });
};

const editCompany = (id) => {
    window.location.href = route('companies.edit', id)
};

const closeModal = () => {
    confirmingDeletion.value = false;
    companyId.value = null;
};
</script>

<template>
    <Head title="Company" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Company</h2>
        </template>


        <div class="container py-12">
            <div class="mb-3 text-end">
                <ButtonLink :href="route('companies.create')" :class="'default'">
                    Add Company
                </ButtonLink>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Logo</th>
                                <th>Website</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="companies.data.length" v-for="(item, index) in companies.data" :key="index"
                                class="align-middle">
                                <td>{{ ++index }}</td>
                                <td>{{ item.name }}</td>
                                <td>{{ item.email }}</td>
                                <td>
                                    <img v-if="item.logo" :src="item.get_logo" :alt="item.name" class="w-14">
                                </td>
                                <td><a :href="item.website" target="_blank">{{ item.website }}</a></td>
                                <td>
                                    <div>
                                        <PrimaryButton @click="editCompany(item.id)">
                                            <i class="fas fa-pencil"></i>
                                        </PrimaryButton>
                                        <DangerButton @click="confirmDeletion(item.id)">
                                            <i class="fas fa-trash"></i>
                                        </DangerButton>
                                    </div>
                                </td>
                            </tr>
                            <tr v-else>
                                <td colspan="5">No Records!</td>
                            </tr>
                        </tbody>
                    </table>
                    <Pagination :links="companies.links" />
                </div>
            </div>

            <Modal :show="confirmingDeletion" @close="closeModal">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900">
                        Are you sure you want to delete this Company?
                    </h2>
                    <h4>
                        The Employees attached to this Company will be permanently deleted.
                    </h4>

                    <div class="mt-6 flex justify-end">
                        <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                        <DangerButton class="ml-3" @click="deleteCompany">
                            Delete Company
                        </DangerButton>
                    </div>
                </div>
            </Modal>
        </div>
    </AuthenticatedLayout>
</template>

<style></style>