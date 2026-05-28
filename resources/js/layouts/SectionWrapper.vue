<template>
    <section :class="['py-12 md:py-16 lg:py-20', bgClass]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- En-tête de section -->
            <div class="text-center max-w-3xl mx-auto mb-10 md:mb-14">
                <!-- Badge -->
                <div v-if="badge" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full mb-4" :style="{ backgroundColor: 'var(--orange-light)', color: 'var(--primary)' }">
                    <component :is="badgeIcon" v-if="badgeIcon" class="w-3.5 h-3.5" />
                    <span class="text-[10px] sm:text-xs font-black uppercase tracking-wider">{{ badge }}</span>
                </div>

                <!-- Titre -->
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight" :style="{ color: 'var(--foreground)' }">
                    {{ title }}
                </h2>

                <!-- Séparateur -->
                <div v-if="subtitle" class="flex justify-center my-4">
                    <div class="w-16 h-1 rounded-full" :style="{ backgroundColor: 'var(--primary)' }"></div>
                </div>

                <!-- Sous-titre -->
                <p v-if="subtitle" class="text-sm md:text-base max-w-2xl mx-auto" :style="{ color: 'var(--muted-foreground)' }">
                    {{ subtitle }}
                </p>
            </div>

            <!-- Slot pour le contenu -->
            <slot />

            <!-- Lien "Voir tout" optionnel -->
            <div v-if="viewAllLink" class="text-center mt-10">
                <Link
                    :href="viewAllLink"
                    class="inline-flex items-center gap-2 px-6 py-3 rounded-lg font-semibold text-sm transition-all duration-300 group"
                    :style="{
                        color: 'var(--primary)',
                        border: `1px solid var(--primary)`,
                        backgroundColor: 'transparent'
                    }"
                    @mouseenter="(e) => { e.currentTarget.style.backgroundColor = 'var(--primary)'; e.currentTarget.style.color = 'white'; }"
                    @mouseleave="(e) => { e.currentTarget.style.backgroundColor = 'transparent'; e.currentTarget.style.color = 'var(--primary)'; }"
                >
                    <span>Voir tout</span>
                    <ArrowRight class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" />
                </Link>
            </div>
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
