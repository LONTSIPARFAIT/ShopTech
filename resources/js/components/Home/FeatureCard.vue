<template>
    <div :class="['p-10 rounded-[2.5rem] space-y-5 relative overflow-hidden group', cardClass]">
        <div v-if="variant === 'primary'" class="absolute -right-8 -bottom-8 w-48 h-48 bg-white/10 blur-3xl rounded-full group-hover:scale-150 transition-transform duration-700"></div>
        
        <component :is="icon" :class="['w-10 h-10 mb-2', iconClass]" />
        
        <h3 :class="['text-2xl font-black tracking-tight uppercase italic', variant === 'primary' ? 'text-white' : '']">
            {{ title }}
        </h3>
        
        <p :class="['font-medium leading-relaxed text-sm', descriptionClass]">
            {{ description }}
        </p>
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps<{
    icon: any;
    title: string;
    description: string;
    variant?: 'primary' | 'light' | 'dark';
}>();

const cardClass = computed(() => {
    const variants = {
        primary: 'bg-blue-600 text-white',
        light: 'bg-slate-50 dark:bg-slate-900 border border-slate-100 dark:border-slate-800',
        dark: 'bg-slate-900 dark:bg-white text-white dark:text-slate-950',
    };
    return variants[props.variant || 'light'];
});

const iconClass = computed(() => {
    return props.variant === 'primary' ? 'text-white' : 'text-blue-600';
});

const descriptionClass = computed(() => {
    return props.variant === 'primary' 
        ? 'text-blue-100' 
        : 'text-slate-500 dark:text-slate-400';
});
</script>