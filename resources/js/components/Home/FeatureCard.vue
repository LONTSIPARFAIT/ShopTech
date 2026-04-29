<template>
    <div :class="['feature-card', {
        'feature-card-primary': variant === 'primary',
        'feature-card-light': variant === 'light',
        'feature-card-dark': variant === 'dark'
    }]">
        <div v-if="variant === 'primary'" class="feature-card-glow"></div>
        <component :is="icon" :class="['feature-card-icon']" />
        <h3 class="feature-card-title">{{ title }}</h3>
        <p class="feature-card-description">{{ description }}</p>
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