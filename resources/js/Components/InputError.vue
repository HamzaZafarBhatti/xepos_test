<script setup>
defineProps({
    message: {
        type: Array,
    },
});
</script>

<template>
    <div v-show="message ? message[0] : null">
        <p class="text-sm text-red-600">
            {{ message ? message[0] : null }}
        </p>
    </div>
</template>
