<template>
    <div class="tech-card">
        <component :is="icon" :class="['tech-card-icon', {
            'tech-card-icon-blue': iconColor === 'blue',
            'tech-card-icon-purple': iconColor === 'purple',
            'tech-card-icon-emerald': iconColor === 'emerald'
        }]" />
        <h3 class="tech-card-title">{{ title }}</h3>
        <p class="tech-card-description">{{ description }}</p>
    </div>
</template>

<script setup lang="ts">
defineProps<{
    icon: any;
    iconColor: string;
    title: string;
    description: string;
}>();
</script>