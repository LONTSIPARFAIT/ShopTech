<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import ShopLayout from '@/layouts/ShopLayout.vue';
import { Shield, Zap, Award, Users, MapPin, CheckCircle, Heart, Star, Clock, Package } from 'lucide-vue-next';

defineOptions({ layout: ShopLayout });
</script>

<template>
    <Head title="À propos – ShopTech" />

    <div class="about-page">
        <!-- Hero -->
        <section class="about-hero">
            <div class="about-hero-bg"></div>
            <div class="about-hero-container">
                <div class="about-hero-content">
                    <span class="about-hero-badge">Notre Histoire</span>
                    <h1 class="about-hero-title">
                        Qui sommes-<span class="text-blue-600">nous ?</span>
                    </h1>
                    <p class="about-hero-description">
                        ShopTech est né d'une passion pour la technologie et d'une volonté de démocratiser l'accès aux meilleurs produits high-tech au Cameroun.
                    </p>
                </div>
            </div>
        </section>

        <!-- Mission Section -->
        <section class="about-mission">
            <div class="about-mission-container">
                <div class="about-mission-grid">
                    <div class="about-mission-content">
                        <span class="about-mission-badge">Notre Mission</span>
                        <h2 class="about-mission-title">
                            L'innovation, <br/><span class="text-blue-600">accessible à tous</span>
                        </h2>
                        <p class="about-mission-text">
                            Depuis notre création, nous nous engageons à proposer des produits technologiques de qualité à des prix compétitifs. Notre équipe sélectionne rigoureusement chaque article pour garantir votre satisfaction.
                        </p>
                        <p class="about-mission-text">
                            Basés à Yaoundé, nous livrons dans tout le Cameroun avec un service client réactif et professionnel. Votre confiance est notre priorité.
                        </p>
                        <div class="about-mission-location">
                            <MapPin class="w-5 h-5 text-blue-600" />
                            <span>Yaoundé, Cameroun – Rue de la Cathédrale</span>
                        </div>
                    </div>

                    <div class="about-stats">
                        <div v-for="stat in [
                            { value: '500+', label: 'Produits' },
                            { value: '2 000+', label: 'Clients' },
                            { value: '5 ans', label: 'D\'expérience' },
                            { value: '48h', label: 'Livraison' }
                        ]" :key="stat.label" class="about-stat-card">
                            <p class="about-stat-value">{{ stat.value }}</p>
                            <p class="about-stat-label">{{ stat.label }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Values Section -->
        <section class="about-values">
            <div class="about-values-container">
                <div class="about-values-header">
                    <span class="about-values-badge">Ce qui nous différencie</span>
                    <h2 class="about-values-title">Nos <span class="text-blue-600">valeurs</span></h2>
                </div>

                <div class="about-values-grid">
                    <div v-for="val in [
                        { icon: Shield, title: 'Qualité garantie', desc: 'Tous nos produits sont soigneusement vérifiés avant livraison.', iconClass: 'icon-blue' },
                        { icon: Zap, title: 'Livraison rapide', desc: 'Expédition sous 24h dans tout le Cameroun.', iconClass: 'icon-yellow' },
                        { icon: Award, title: 'Marques premium', desc: 'Partenaires officiels des grandes marques mondiales.', iconClass: 'icon-purple' },
                        { icon: Users, title: 'Support humain', desc: 'Une équipe disponible 6j/7 pour vous accompagner.', iconClass: 'icon-green' }
                    ]" :key="val.title" class="about-value-card">
                        <div :class="['about-value-icon', val.iconClass]">
                            <component :is="val.icon" class="w-5 h-5" />
                        </div>
                        <h3 class="about-value-title">{{ val.title }}</h3>
                        <p class="about-value-desc">{{ val.desc }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why Choose Us -->
        <section class="about-why">
            <div class="about-why-container">
                <div class="about-why-grid">
                    <div class="about-why-list">
                        <div v-for="item in [
                            'Produits authentiques avec garantie constructeur',
                            'Paiement sécurisé (Mobile Money, Orange Money)',
                            'Service après-vente disponible pendant 12 mois',
                            'Retours gratuits sous 7 jours',
                            'Livraison gratuite à partir de 50 000 XAF'
                        ]" :key="item" class="about-why-item">
                            <CheckCircle class="w-5 h-5 text-blue-600" />
                            <span>{{ item }}</span>
                        </div>
                    </div>

                    <div class="about-why-cta">
                        <h3 class="about-why-cta-title">Rejoignez notre communauté</h3>
                        <p class="about-why-cta-text">
                            Plus de 2 000 clients nous font confiance pour leurs achats technologiques.
                        </p>
                        <a href="/contact" class="about-why-cta-btn">Nous contacter</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>