<template>
    <section class="py-8 border-y border-slate-100 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div v-for="stat in stats" :key="stat" class="text-center">
                    <span class="text-xs font-black uppercase tracking-[0.3em] text-slate-400">{{ stat }}</span>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">
const stats = ['15k+ Clients', '500+ Produits', '24h Livraison', '100% Sécurisé'];
</script>