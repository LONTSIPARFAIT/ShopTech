<template>
    <div 
        class="relative p-8 rounded-xl overflow-hidden transition-all duration-300 hover:-translate-y-1"
        :class="{
            'bg-blue-600 text-white': variant === 'primary',
            'bg-slate-50 dark:bg-slate-900 border border-slate-100 dark:border-slate-800': variant === 'light',
            'bg-slate-900 dark:bg-white text-white dark:text-slate-950': variant === 'dark'
        }"
    >
        <!-- Glow effect for primary variant -->
        <div 
            v-if="variant === 'primary'" 
            class="absolute -right-8 -bottom-8 w-48 h-48 bg-white/10 blur-3xl rounded-full transition-transform duration-500 group-hover:scale-150"
        ></div>
        
        <!-- Icon -->
        <component 
            :is="icon" 
            class="w-10 h-10 mb-4"
            :class="{
                'text-white': variant === 'primary',
                'text-blue-600': variant !== 'primary'
            }"
        />
        
        <!-- Title -->
        <h3 
            class="text-xl font-black uppercase italic mb-2"
            :class="{
                'md:text-2xl': true
            }"
        >
            {{ title }}
        </h3>
        
        <!-- Description -->
        <p 
            class="text-sm font-medium leading-relaxed"
            :class="{
                'text-blue-100': variant === 'primary',
                'text-slate-500 dark:text-slate-400': variant !== 'primary'
            }"
        >
            {{ description }}
        </p>
    </div>
</template>

<script setup lang="ts">
defineProps<{
    icon: any;
    title: string;
    description: string;
    variant?: 'primary' | 'light' | 'dark';
}>();
</script>