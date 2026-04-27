<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import ShopLayout from '@/layouts/ShopLayout.vue';
import { Shield, Zap, Award, Users, MapPin, CheckCircle } from 'lucide-vue-next';

defineOptions({ layout: ShopLayout });
</script>

<template>
    <Head title="À propos – ShopTech" />

    <div class="pt-24">
        <!-- Hero -->
        <section class="relative py-24 overflow-hidden bg-gradient-to-br from-blue-50 via-white to-indigo-50 dark:from-slate-950 dark:via-slate-900 dark:to-slate-950">
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-blue-400/10 rounded-full blur-[100px]"></div>
                <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-indigo-400/10 rounded-full blur-[80px]"></div>
            </div>
            <div class="max-w-5xl mx-auto px-6 lg:px-12 text-center relative z-10">
                <span class="inline-block px-4 py-1.5 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full text-[10px] font-black uppercase tracking-widest mb-6">Notre Histoire</span>
                <h1 class="text-4xl lg:text-6xl font-black tracking-tight uppercase italic mb-6">
                    Qui sommes-<span class="text-blue-600">nous ?</span>
                </h1>
                <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto leading-relaxed font-medium">
                    ShopTech est né d'une passion pour la technologie et d'une volonté de démocratiser l'accès aux meilleurs produits high-tech au Cameroun.
                </p>
            </div>
        </section>

        <!-- Mission / Values -->
        <section class="py-20 max-w-7xl mx-auto px-6 lg:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="space-y-6">
                    <span class="inline-block text-[10px] font-black uppercase tracking-widest text-blue-600">Notre Mission</span>
                    <h2 class="text-3xl font-black tracking-tight uppercase">L'innovation, <br/><span class="text-blue-600">accessible à tous</span></h2>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed font-medium">
                        Depuis notre création, nous nous engageons à proposer des produits technologiques de qualité à des prix compétitifs. Notre équipe sélectionne rigoureusement chaque article pour garantir votre satisfaction.
                    </p>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed font-medium">
                        Basés à Yaoundé, nous livrons dans tout le Cameroun avec un service client réactif et professionnel. Votre confiance est notre priorité.
                    </p>
                    <div class="flex items-center gap-3 pt-2">
                        <MapPin class="w-5 h-5 text-blue-600 shrink-0" />
                        <span class="font-semibold text-slate-700 dark:text-slate-300">Yaoundé, Cameroun – Rue de la Cathédrale</span>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div v-for="stat in [
                        { value: '500+', label: 'Produits' },
                        { value: '2 000+', label: 'Clients satisfaits' },
                        { value: '5 ans', label: 'D\'expérience' },
                        { value: '48h', label: 'Livraison max' }
                    ]" :key="stat.label" class="shop-card p-8 text-center hover:-translate-y-1">
                        <p class="text-3xl font-black text-blue-600 mb-2">{{ stat.value }}</p>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">{{ stat.label }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Values -->
        <section class="py-20 bg-slate-50 dark:bg-slate-900/50">
            <div class="max-w-7xl mx-auto px-6 lg:px-12">
                <div class="text-center mb-14">
                    <span class="inline-block text-[10px] font-black uppercase tracking-widest text-blue-600 mb-3">Ce qui nous différencie</span>
                    <h2 class="text-3xl font-black tracking-tight uppercase">Nos <span class="text-blue-600">valeurs</span></h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div v-for="val in [
                        { icon: Shield, title: 'Qualité garantie', desc: 'Tous nos produits sont soigneusement vérifiés avant livraison.' },
                        { icon: Zap, title: 'Livraison rapide', desc: 'Expédition sous 24h dans tout le Cameroun.' },
                        { icon: Award, title: 'Marques premium', desc: 'Partenaires officiels des grandes marques mondiales.' },
                        { icon: Users, title: 'Support humain', desc: 'Une équipe disponible 6j/7 pour vous accompagner.' },
                    ]" :key="val.title" class="shop-card p-7 space-y-4 hover:-translate-y-1">
                        <div class="w-12 h-12 bg-blue-600/10 dark:bg-blue-600/20 rounded-2xl flex items-center justify-center">
                            <component :is="val.icon" class="w-6 h-6 text-blue-600" />
                        </div>
                        <h3 class="font-black text-base">{{ val.title }}</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed font-medium">{{ val.desc }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why choose us -->
        <section class="py-20 max-w-7xl mx-auto px-6 lg:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="space-y-4">
                    <div v-for="item in [
                        'Produits authentiques avec garantie constructeur',
                        'Paiement sécurisé via Notch Pay, Mobile Money, Orange Money',
                        'Service après-vente disponible pendant 12 mois',
                        'Retours gratuits sous 7 jours si produit défectueux',
                        'Livraison gratuite à partir de 50 000 XAF',
                    ]" :key="item" class="flex items-start gap-3">
                        <CheckCircle class="w-5 h-5 text-blue-600 shrink-0 mt-0.5" />
                        <span class="font-semibold text-slate-700 dark:text-slate-300">{{ item }}</span>
                    </div>
                </div>
                <div class="shop-card p-10 space-y-5 bg-gradient-to-br from-blue-600 to-blue-700 text-white border-0">
                    <h3 class="text-2xl font-black uppercase">Rejoignez notre communauté</h3>
                    <p class="text-blue-100 leading-relaxed font-medium">
                        Plus de 2 000 clients nous font confiance pour leurs achats technologiques. Profitez d'offres exclusives en rejoignant notre newsletter.
                    </p>
                    <a href="/contact" class="inline-block px-6 py-3 bg-white text-blue-600 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-50 transition-colors shadow-lg">
                        Nous contacter
                    </a>
                </div>
            </div>
        </section>
    </div>
</template>
