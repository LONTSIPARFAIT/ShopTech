<template>
    <div
        class="group p-5 rounded-xl transition-all duration-300 hover:-translate-y-1"
        :class="[
            variant === 'primary' ? 'bg-gradient-to-br from-orange-500 to-orange-600 text-white shadow-lg shadow-orange-500/20' : '',
            variant === 'light' ? 'bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-orange-300 dark:hover:border-orange-600 hover:shadow-md' : '',
            variant === 'dark' ? 'bg-slate-800 dark:bg-slate-900 text-white border border-slate-700 dark:border-slate-700 hover:border-orange-500/50' : ''
        ]"
    >
        <!-- En-tête avec icône et titre sur la même ligne -->
        <div class="flex items-center gap-3 mb-3">
            <!-- Icône -->
            <div
                class="w-10 h-10 rounded-lg flex items-center justify-center transition-all duration-300 flex-shrink-0"
                :class="[
                    variant === 'primary' ? 'bg-white/20 text-white' : '',
                    variant === 'light' ? 'bg-orange-100 dark:bg-orange-900/30 text-orange-500 group-hover:bg-orange-500 group-hover:text-white' : '',
                    variant === 'dark' ? 'bg-orange-500/20 text-orange-400 group-hover:bg-orange-500 group-hover:text-white' : ''
                ]"
            >
                <component :is="icon" class="w-5 h-5" />
            </div>

            <!-- Titre -->
            <h3
                class="text-base font-bold transition-colors"
                :class="[
                    variant === 'primary' ? 'text-white' : '',
                    variant === 'light' ? 'text-slate-800 dark:text-white group-hover:text-orange-500' : '',
                    variant === 'dark' ? 'text-white group-hover:text-orange-400' : ''
                ]"
            >
                {{ title }}
            </h3>
        </div>

        <!-- Description -->
        <p
            class="text-sm leading-relaxed"
            :class="[
                variant === 'primary' ? 'text-orange-100' : '',
                variant === 'light' ? 'text-slate-500 dark:text-slate-400' : '',
                variant === 'dark' ? 'text-slate-300' : ''
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
