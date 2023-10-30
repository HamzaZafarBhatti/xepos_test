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
    employees: {
        type: Object
    },
});

const confirmingDeletion = ref(false);
const employeeId = ref(null);

const confirmDeletion = (id) => {
    confirmingDeletion.value = true;
    employeeId.value = id
};

const deleteEmployee = () => {
    console.log(employeeId.value);
    axios.delete(route('employees.destroy', employeeId.value))
        .then(response => {
            closeModal()
            window.location.href = route('employees.index');
        })
        .catch(error => {
            console.log(error);
        });
};

const editEmployee = (id) => {
    window.location.href = route('employees.edit', id)
};

const closeModal = () => {
    confirmingDeletion.value = false;
    employeeId.value = null;
};
</script>

<template>
    <Head title="Employee" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Employee</h2>
        </template>

        <div class="container py-12">
            <div class="mb-3 text-end">
                <ButtonLink :href="route('employees.create')" :class="'default'">
                    Add Employee
                </ButtonLink>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Company</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="employees.data.length" v-for="(item, index) in employees.data" :key="index"
                                class="align-middle">
                                <td>{{ ++index }}</td>
                                <td>{{ item.first_name }}</td>
                                <td>{{ item.last_name }}</td>
                                <td>{{ item.company.name }}</td>
                                <td>{{ item.email }}</td>
                                <td>{{ item.phone }}</td>
                                <td>
                                    <div>
                                        <PrimaryButton @click="editEmployee(item.id)">
                                            <i class="fas fa-pencil"></i>
                                        </PrimaryButton>
                                        <DangerButton @click="confirmDeletion(item.id)">
                                            <i class="fas fa-trash"></i>
                                        </DangerButton>
                                    </div>
                                </td>
                            </tr>
                            <tr v-else>
                                <td colspan="7">No Records!</td>
                            </tr>
                        </tbody>
                    </table>
                    <Pagination :links="employees.links" />
                </div>
            </div>

            <Modal :show="confirmingDeletion" @close="closeModal">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900">
                        Are you sure you want to delete this Employee?
                    </h2>

                    <div class="mt-6 flex justify-end">
                        <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                        <DangerButton class="ml-3" @click="deleteEmployee">
                            Delete Employee
                        </DangerButton>
                    </div>
                </div>
            </Modal>
        </div>
    </AuthenticatedLayout>
</template>
