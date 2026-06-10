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
    service: Service;
    relatedServices: Service[];
}

defineProps<Props>();

const formatPrice = (price: number): string => {
    return new Intl.NumberFormat('fr-FR').format(price);
};
</script>

<template>
    <div class="shop-product">
        <!-- Breadcrumb -->
        <div class="shop-breadcrumb">
            <Link href="/" class="shop-breadcrumb-link">Accueil</Link>
            <svg class="shop-breadcrumb-sep" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <Link href="/services" class="shop-breadcrumb-link">Services</Link>
            <svg class="shop-breadcrumb-sep" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="shop-breadcrumb-current">{{ service.name }}</span>
        </div>

        <!-- Service Detail -->
        <div class="shop-product-main">
            <!-- Gallery -->
            <div class="shop-gallery">
                <div class="shop-gallery-main">
                    <img :src="service.image_url" :alt="service.name" class="shop-gallery-img" />
                </div>
            </div>

            <!-- Product Info -->
            <div class="shop-product-info">
                <div class="shop-product-meta">
                    <span class="shop-product-category" :class="{
                        'bg-orange-100 text-primary': service.type === 'plomberie',
                        'bg-yellow-100 text-yellow-700': service.type === 'electricite'
                    }">
                        {{ service.type === 'plomberie' ? 'Plomberie' : 'Électricité' }}
                    </span>
                    <span class="shop-product-stock">Disponible</span>
                </div>

                <h1 class="shop-product-title">{{ service.name }}</h1>

                <div class="shop-product-price">
                    <div class="shop-product-price-current">{{ formatPrice(service.base_price) }} <span class="text-sm font-normal">XAF</span></div>
                </div>

                <div class="shop-product-description">
                    <p class="shop-product-description-text">{{ service.description }}</p>
                </div>

                <div class="shop-product-section">
                    <h3 class="shop-product-section-title">Ce qui est inclus</h3>
                    <p class="text-muted-foreground leading-relaxed">{{ service.details }}</p>
                </div>

                <!-- Actions -->
                <div class="shop-actions-modern">
                    <div class="shop-action-buttons-modern">
                        <Link href="/contact" class="shop-buy-btn-modern">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Demander un devis
                        </Link>
                        <a href="tel:+237XXXXXXXXX" class="shop-cart-btn-modern">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            Appeler maintenant
                        </a>
                    </div>
                </div>

                <!-- Features -->
                <div class="shop-features-modern">
                    <div class="shop-feature-modern">
                        <div class="shop-feature-icon-modern">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <span class="shop-feature-text-modern">Qualité Garantie</span>
                    </div>
                    <div class="shop-feature-modern">
                        <div class="shop-feature-icon-modern">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="shop-feature-text-modern">Intervention Rapide</span>
                    </div>
                    <div class="shop-feature-modern">
                        <div class="shop-feature-icon-modern">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <span class="shop-feature-text-modern">Garantie 2 ans</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Services -->
        <div v-if="relatedServices.length > 0" class="shop-related">
            <h2 class="shop-related-title">Services similaires</h2>
            <div class="shop-related-grid">
                <Link v-for="relService in relatedServices" :key="relService.id" :href="'/services/' + relService.slug" class="product-card group">
                    <div class="product-card-image">
                        <img :src="relService.image_url" :alt="relService.name" class="product-card-img" />
                    </div>
                    <div class="product-card-content">
                        <h3 class="product-card-title">{{ relService.name }}</h3>
                        <div class="product-card-footer">
                            <div class="product-card-price">
                                <div class="product-card-price-current">
                                    <span class="product-card-price-value">{{ formatPrice(relService.base_price) }}</span>
                                    <span class="product-card-price-currency">XAF</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </Link>
            </div>
        </div>
    </div>
</template>