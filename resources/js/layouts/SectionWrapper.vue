<template>
    <section :class="['py-16', bgClass]">
        <div class="max-w-7xl mx-auto px-6 lg:px-12 space-y-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="space-y-3">
                    <div v-if="badge" class="inline-flex items-center gap-2 text-indigo-600 font-black uppercase tracking-widest text-[10px]">
                        <component :is="badgeIcon" class="w-4 h-4" v-if="badgeIcon" />
                        {{ badge }}
                    </div>
                    <h2 class="text-3xl font-black tracking-tight uppercase italic">{{ title }}</h2>
                    <p v-if="subtitle" class="text-slate-500 dark:text-slate-400">{{ subtitle }}</p>
                </div>
                <Link 
                    v-if="viewAllLink"
                    :href="viewAllLink" 
                    class="group flex items-center gap-3 font-black text-xs uppercase tracking-widest"
                >
                    Tout voir 
                    <ArrowRight class="w-4 h-4 group-hover:translate-x-2 transition-transform" />
                </Link>
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