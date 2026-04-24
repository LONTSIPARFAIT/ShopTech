<script setup lang="ts">
defineProps<{
    label: string;
    value: string | number;
    unit?: string;
}>();
</script>

<template>
    <div class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-sm">
        <p class="text-sm font-bold opacity-50 uppercase tracking-widest mb-4">{{ label }}</p>
        <p class="text-3xl font-black">
            {{ typeof value === 'number' ? value.toLocaleString() : value }}
            <span v-if="unit" class="text-xs">{{ unit }}</span>
        </p>
    </div>
</template>
