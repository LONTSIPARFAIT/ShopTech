<template>
    <section class="py-16 bg-card">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Petit en-tête optionnel -->
            <div class="text-center mb-10">
                <span class="text-xs font-semibold uppercase tracking-wider text-orange-500">Nos services</span>
                <h2 class="text-xl md:text-2xl font-bold text-foreground mt-1">
                    Pourquoi <span class="text-orange-500">nous choisir ?</span>
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <FeatureCard
                    :icon="Truck"
                    title="Livraison Partout"
                    description="Livraison rapide sur tout le Cameroun avec suivi en temps réel."
                    variant="primary"
                />
                <FeatureCard
                    :icon="ShieldCheck"
                    title="Garantie Officielle"
                    description="Garantie constructeur sur tous nos produits pour votre tranquillité."
                    variant="light"
                />
                <FeatureCard
                    :icon="Zap"
                    title="SAV Expert"
                    description="Assistance technique réactive par des professionnels qualifiés."
                    variant="dark"
                />
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">
import { Truck, ShieldCheck, Zap } from 'lucide-vue-next';
import FeatureCard from '@/components/Home/FeatureCard.vue';
</script>
