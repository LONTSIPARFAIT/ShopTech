<template>
    <div
        class="group p-6 rounded-2xl transition-all duration-300 hover:-translate-y-1"
        :class="[
            variant === 'primary' ? 'bg-gradient-to-br from-orange-500 to-orange-600 text-white shadow-lg' : '',
            variant === 'light' ? 'bg-card border border-border hover:border-orange-500/30 hover:shadow-md' : '',
            variant === 'dark' ? 'bg-slate-900 text-white dark:bg-white dark:text-slate-900 border border-slate-800 dark:border-border hover:border-orange-500/30' : ''
        ]"
    >
        <!-- Icône -->
        <div
            class="w-12 h-12 rounded-xl flex items-center justify-center mb-4 transition-all duration-300"
            :class="[
                variant === 'primary' ? 'bg-white/20 text-white' : '',
                variant === 'light' ? 'bg-orange-500/10 text-orange-500 group-hover:bg-orange-500 group-hover:text-white' : '',
                variant === 'dark' ? 'bg-orange-500/20 text-orange-400 dark:bg-orange-500/10 dark:text-orange-500 group-hover:bg-orange-500 group-hover:text-white' : ''
            ]"
        >
            <component :is="icon" class="w-6 h-6" />
        </div>

        <!-- Titre -->
        <h3
            class="text-lg font-bold mb-2 transition-colors"
            :class="[
                variant === 'primary' ? 'text-white' : '',
                variant === 'light' ? 'text-foreground group-hover:text-orange-500' : '',
                variant === 'dark' ? 'text-white dark:text-foreground group-hover:text-orange-400' : ''
            ]"
        >
            {{ title }}
        </h3>

        <!-- Description -->
        <p
            class="text-sm leading-relaxed"
            :class="[
                variant === 'primary' ? 'text-orange-100' : '',
                variant === 'light' ? 'text-muted-foreground' : '',
                variant === 'dark' ? 'text-slate-300 dark:text-muted-foreground' : ''
            ]"
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
    variant: 'primary' | 'light' | 'dark';
}>();
</script>
