<template>
    <section :class="['py-16', bgClass]">
        <div class="max-w-7xl mx-auto px-6 lg:px-12 space-y-12">
            <div class="space-y-4 text-center max-w-3xl mx-auto">
                <div v-if="badge" class="inline-flex px-4 py-1.5 bg-blue-600/10 text-blue-600 rounded-full font-black uppercase tracking-widest text-[9px] border border-blue-600/10">
                    {{ badge }}
                </div>
                <h2 class="text-3xl md:text-4xl font-black">
                    {{ title }}
                </h2>
                <div v-if="subtitle" class="h-1 w-20 bg-blue-600 mx-auto rounded-full"></div>
                <p v-if="subtitle" class="text-slate-500 dark:text-slate-400 font-medium text-sm">{{ subtitle }}</p>
            </div>
            <slot />
        </div>
    </section>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRight } from 'lucide-vue-next';

defineProps<{
    title?: string;
    subtitle?: string;
    badge?: string;
    badgeIcon?: any;
    viewAllLink?: string;
    bgClass?: string;
}>();
</script>