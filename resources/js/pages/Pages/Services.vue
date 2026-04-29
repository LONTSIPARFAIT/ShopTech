<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import ShopLayout from '@/layouts/ShopLayout.vue';
import { Smartphone, Laptop, Wrench, Headphones, ShieldCheck, Truck, ArrowRight, MessageCircle } from 'lucide-vue-next';

defineOptions({ layout: ShopLayout });

const services = [
    {
        icon: Smartphone,
        title: 'Vente de Smartphones',
        description: 'Large gamme de smartphones haut de gamme et milieu de gamme avec garantie officielle.',
        color: 'blue',
    },
    {
        icon: Laptop,
        title: 'Ordinateurs & Tablettes',
        description: 'PC portables, MacBook et tablettes. Configuration sur mesure pour professionnels.',
        color: 'indigo',
    },
    {
        icon: Headphones,
        title: 'Accessoires Tech',
        description: 'Écouteurs, chargeurs, claviers et tout l\'écosystème d\'accessoires pour vos appareils.',
        color: 'purple',
    },
    {
        icon: Wrench,
        title: 'Réparation & SAV',
        description: 'Service de réparation rapide. Diagnostic gratuit et techniciens certifiés.',
        color: 'orange',
    },
    {
        icon: ShieldCheck,
        title: 'Garantie & Assurance',
        description: 'Extension de garantie jusqu\'à 2 ans sur tous nos produits.',
        color: 'green',
    },
    {
        icon: Truck,
        title: 'Livraison Rapide',
        description: 'Livraison sous 24–48h à Yaoundé, Douala et les grandes villes. Gratuite dès 50 000 XAF.',
        color: 'teal',
    },
];

const colorClass: Record<string, string> = {
    blue: 'icon-blue',
    indigo: 'icon-indigo',
    purple: 'icon-purple',
    orange: 'icon-orange',
    green: 'icon-green',
    teal: 'icon-teal',
};
</script>

<template>
    <Head title="Nos Services – ShopTech" />

    <div class="services-page">
        <!-- Hero -->
        <section class="services-hero">
            <div class="services-hero-bg"></div>
            <div class="services-hero-container">
                <div class="services-hero-content">
                    <span class="services-hero-badge">Ce que nous offrons</span>
                    <h1 class="services-hero-title">
                        Nos <span class="text-blue-600">Services</span>
                    </h1>
                    <p class="services-hero-description">
                        Du smartphone à l'ordinateur, de la vente à la réparation, ShopTech vous accompagne.
                    </p>
                </div>
            </div>
        </section>

        <!-- Services Grid -->
        <section class="services-grid-section">
            <div class="services-container">
                <div class="services-grid">
                    <div v-for="service in services" :key="service.title" class="service-card">
                        <div :class="['service-icon', colorClass[service.color]]">
                            <component :is="service.icon" class="w-6 h-6" />
                        </div>
                        <h3 class="service-title">{{ service.title }}</h3>
                        <p class="service-description">{{ service.description }}</p>
                        <a href="/contact" class="service-link">
                            En savoir plus <ArrowRight class="w-3 h-3" />
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Banner -->
        <section class="services-cta">
            <div class="services-cta-container">
                <h2 class="services-cta-title">Besoin d'un service spécifique ?</h2>
                <p class="services-cta-text">
                    Notre équipe est disponible pour répondre à vos besoins personnalisés.
                </p>
                <div class="services-cta-buttons">
                    <a href="/contact" class="services-cta-btn-primary">Nous contacter</a>
                    <a href="https://wa.me/237600000000" target="_blank" class="services-cta-btn-secondary">
                        <MessageCircle class="w-4 h-4" />
                        WhatsApp
                    </a>
                </div>
            </div>
        </section>
    </div>
</template>