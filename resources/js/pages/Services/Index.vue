<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import ShopLayout from '@/layouts/ShopLayout.vue';

defineOptions({
    layout: ShopLayout,
});

interface Service {
    id: number;
    name: string;
    slug: string;
    description: string;
    details: string;
    type: 'plomberie' | 'electricite';
    base_price: number;
    image_url: string;
    is_active: boolean;
}

interface Props {
    plumerieServices: Service[];
    electriciteServices: Service[];
}

defineProps<Props>();

const formatPrice = (price: number): string => {
    return new Intl.NumberFormat('fr-FR').format(price);
};
</script>

<template>
    <div class="shop-catalog">
        <!-- Header avec le style orange du site -->
        <div class="bg-gradient-to-r from-primary to-primary-dark text-white py-16">
            <div class="container mx-auto px-4 text-center">
                <h1 class="text-4xl md:text-5xl font-black uppercase italic mb-4">Nos Services</h1>
                <p class="text-lg text-orange-100 max-w-2xl mx-auto">
                    Plomberie et Électricité - Intervention rapide et qualité garantie
                </p>
            </div>
        </div>

        <div class="container mx-auto px-4 py-12">
            <!-- Services de Plomberie -->
            <div class="mb-16">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 11.894 1.788l-1.314.657 1.314.657a1 1 0 11-.894 1.788l-1.599-.8-3.954 1.582V9a1 1 0 11-2 0V7.677L6.046 6.095l-1.599.8a1 1 0 1-.894-1.788l1.314-.657-1.314-.657a1 1 0 11.894-1.788l1.599.8L9 4.323V3a1 1 0 011-1h0z"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl md:text-3xl font-bold text-foreground">Services de Plomberie</h2>
                    </div>
                    <div class="hidden md:block w-32 h-px bg-border"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="service in plumerieServices" :key="service.id" class="product-card group">
                        <div class="product-card-image">
                            <Link :href="'/services/' + service.slug" class="product-card-link">
                                <img :src="service.image_url" :alt="service.name" class="product-card-img" />
                            </Link>
                        </div>
                        <div class="product-card-content">
                            <Link :href="'/services/' + service.slug" class="product-card-title-link">
                                <h3 class="product-card-title">{{ service.name }}</h3>
                            </Link>
                            <p class="product-card-description">{{ service.description }}</p>
                            <div class="product-card-footer">
                                <div class="product-card-price">
                                    <div class="product-card-price-current">
                                        <span class="product-card-price-value">{{ formatPrice(service.base_price) }}</span>
                                        <span class="product-card-price-currency">XAF</span>
                                    </div>
                                </div>
                                <Link :href="'/services/' + service.slug" class="product-card-cart-btn">
                                    <span>Détails</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Services d'Électricité -->
            <div>
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl md:text-3xl font-bold text-foreground">Services d'Électricité</h2>
                    </div>
                    <div class="hidden md:block w-32 h-px bg-border"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="service in electriciteServices" :key="service.id" class="product-card group">
                        <div class="product-card-image">
                            <Link :href="'/services/' + service.slug" class="product-card-link">
                                <img :src="service.image_url" :alt="service.name" class="product-card-img" />
                            </Link>
                        </div>
                        <div class="product-card-content">
                            <Link :href="'/services/' + service.slug" class="product-card-title-link">
                                <h3 class="product-card-title">{{ service.name }}</h3>
                            </Link>
                            <p class="product-card-description">{{ service.description }}</p>
                            <div class="product-card-footer">
                                <div class="product-card-price">
                                    <div class="product-card-price-current">
                                        <span class="product-card-price-value">{{ formatPrice(service.base_price) }}</span>
                                        <span class="product-card-price-currency">XAF</span>
                                    </div>
                                </div>
                                <Link :href="'/services/' + service.slug" class="product-card-cart-btn">
                                    <span>Détails</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section avec style orange -->
        <div class="bg-gradient-to-r from-primary to-primary-dark text-white py-16 mt-8">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-3xl md:text-4xl font-black uppercase italic mb-4">Besoin d'un service ?</h2>
                <p class="text-lg text-orange-100 mb-8">Contactez-nous pour une intervention rapide et un devis gratuit</p>
                <Link href="/contact" class="inline-flex items-center gap-2 bg-white text-primary px-8 py-3 rounded-lg font-bold hover:bg-orange-50 transition-colors">
                    Nous Contacter
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </Link>
            </div>
        </div>
    </div>
</template>