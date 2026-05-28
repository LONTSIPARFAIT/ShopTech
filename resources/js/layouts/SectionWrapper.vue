<template>
    <section :class="['py-6 md:py-8 lg:py-10', bgClass]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- En-tête de section -->
            <div class="mb-10 md:mb-14">
                <!-- Flex container -->
                <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
                    <!-- Partie gauche -->
                    <div>
                        <div v-if="badge" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full mb-4 bg-orange-100 dark:bg-orange-950/30">
                            <component :is="badgeIcon" v-if="badgeIcon" class="w-3.5 h-3.5 text-orange-500" />
                            <div class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></div>
                            <span class="text-[10px] sm:text-xs font-black uppercase tracking-wider text-orange-600 dark:text-orange-400">
                                {{ badge }}
                            </span>
                        </div>

                        <h2 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight text-foreground">
                            <slot name="title">
                                {{ title }}
                                <span v-if="accent" class="bg-gradient-to-r from-orange-500 to-orange-600 bg-clip-text text-transparent">
                                    {{ accent }}
                                </span>
                            </slot>
                        </h2>
                    </div>

                    <!-- Bouton à droite avec effet modernisé -->
                    <div v-if="viewAllLink" class="flex-shrink-0">
                        <Link
                            :href="viewAllLink"
                            class="group relative inline-flex items-center gap-2 px-5 py-2.5 rounded-lg font-semibold text-sm transition-all duration-300 bg-gradient-to-r from-orange-500 to-orange-600 text-white hover:from-orange-600 hover:to-orange-700 hover:shadow-lg hover:-translate-y-0.5 overflow-hidden"
                        >
                            <span class="relative z-10">{{ viewAllText || 'Voir tout' }}</span>
                            <ArrowRight class="relative z-10 w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" />
                            <span class="absolute inset-0 -translate-x-full group-hover:translate-x-full transition-transform duration-500 bg-gradient-to-r from-transparent via-white/20 to-transparent"></span>
                        </Link>
                    </div>
                </div>

                <!-- Sous-titre sous le flex -->
                <div v-if="subtitle" class="mt-6">
                    <div class="w-16 h-0.5 rounded-full bg-gradient-to-r from-orange-500 to-orange-300 mb-4"></div>
                    <p class="text-sm md:text-base max-w-2xl text-muted-foreground leading-relaxed">
                        {{ subtitle }}
                    </p>
                </div>
            </div>

            <!-- Slot principal -->
            <slot />
        </div>
    </section>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRight } from 'lucide-vue-next';

defineProps<{
    title?: string;
    accent?: string;
    subtitle?: string;
    badge?: string;
    badgeIcon?: any;
    viewAllLink?: string;
    viewAllText?: string;
    bgClass?: string;
    centered?: boolean;
}>();
</script>
