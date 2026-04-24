<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps<{
    status: string;
    type?: 'order' | 'payment';
}>();

const classes = computed(() => {
    if (props.type === 'payment') {
        return props.status === 'paid' 
            ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' 
            : 'bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400';
    }

    return {
        'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400': props.status === 'pending',
        'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400': props.status === 'processing',
        'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400': props.status === 'delivered',
        'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400': props.status === 'cancelled',
    };
});
</script>

<template>
    <span 
        class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider inline-block"
        :class="classes"
    >
        {{ status }}
    </span>
</template>
