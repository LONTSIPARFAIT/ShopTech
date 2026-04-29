<script setup lang="ts">
defineProps<{
    label: string;
    value: string | number;
    unit?: string;
    trend?: string;
    icon?: any;
    color?: string;
}>();
</script>

<template>
    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-card-label">{{ label }}</span>
            <div :class="['stat-card-icon', color]">
                <component :is="icon" v-if="icon" class="w-5 h-5" />
            </div>
        </div>
        
        <div class="stat-card-value">
            {{ typeof value === 'number' ? value.toLocaleString() : value }}
            <span v-if="unit" class="stat-card-unit">{{ unit }}</span>
        </div>
        
        <div v-if="trend" class="stat-card-trend">
            <svg class="w-3 h-3" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
            </svg>
            {{ trend }}
        </div>
    </div>
</template>