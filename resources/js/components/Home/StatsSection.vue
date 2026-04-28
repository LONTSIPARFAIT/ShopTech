<template>
    <section class="py-12 bg-white dark:bg-slate-950 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                <div v-for="(stat, index) in stats" :key="index" class="relative group">
                    <div class="flex flex-col items-center space-y-2">
                        <span class="text-4xl font-black italic text-blue-600 tabular-nums">{{ stat.value }}</span>
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">{{ stat.label }}</span>
                    </div>
                    <div v-if="index < stats.length - 1" class="hidden lg:block absolute -right-4 top-1/2 -translate-y-1/2 w-px h-10 bg-slate-100 dark:bg-slate-800"></div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">
const stats = [
    { value: '15K+', label: 'Clients Heureux' },
    { value: '500+', label: 'Dernières Pépites' },
    { value: '24H', label: 'Livraison Rapide' },
    { value: '100%', label: 'Paiement Sécurisé' }
];
</script>