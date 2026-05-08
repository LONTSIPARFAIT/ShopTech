<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import { index as productsIndex } from '@/actions/App/Http/Controllers/ProductController';
import { register } from '@/routes';
import { Sparkles, ArrowRight, ChevronLeft, ChevronRight } from 'lucide-vue-next';

const slides = [
    {
        image: 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=1920&q=80',
        badge: 'Gros Œuvre',
        title: 'Matériaux de Construction',
        description: 'Ciment, briques et structures de qualité pour des chantiers solides.'
    },
    {
        image: 'https://images.unsplash.com/photo-1581244277943-fe4a9c777189?w=1920&q=80',
        badge: 'Installation Sanitaire',
        title: 'Expertise en Plomberie',
        description: 'Tout pour vos réseaux d\'eau : tubes, raccords et robinetterie pro.'
    },
    {
        image: 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=1920&q=80',
        badge: 'Énergie & Sécurité',
        title: 'Matériel Électrique',
        description: 'Câblage, tableaux et appareillage pour des installations aux normes.'
    }
];

const currentIndex = ref(0);
const currentSlide = computed(() => slides[currentIndex.value]);

const nextSlide = () => {
    currentIndex.value = (currentIndex.value + 1) % slides.length;
};

const prevSlide = () => {
    currentIndex.value = currentIndex.value === 0 ? slides.length - 1 : currentIndex.value - 1;
};

let autoplayInterval: ReturnType<typeof setInterval>;

onMounted(() => {
    autoplayInterval = setInterval(nextSlide, 5000);
});

onUnmounted(() => {
    if (autoplayInterval) clearInterval(autoplayInterval);
});
</script>

<template>
    <section class="shop-hero">
        <!-- Background Slider -->
        <div class="shop-hero-slide">
            <transition name="shop-hero-slide-x" mode="out-in">
                <img
                    :key="currentIndex"
                    :src="currentSlide.image"
                    :alt="currentSlide.title"
                    class="shop-hero-image"
                />
            </transition>
        </div>

        <!-- Content -->
        <div class="shop-hero-content">
            <transition name="shop-hero-content" mode="out-in">
                <div :key="currentIndex" class="shop-hero-inner">
                    <div class="shop-hero-badge">
                        <Sparkles class="w-4 h-4 text-yellow-400" />
                        {{ currentSlide.badge }}
                    </div>
                    <h1 class="shop-hero-title">{{ currentSlide.title }}</h1>
                    <p class="shop-hero-description">{{ currentSlide.description }}</p>
                    <div class="shop-hero-buttons">
                        <Link :href="productsIndex.url()" class="shop-hero-btn-primary">
                            Acheter maintenant
                            <ArrowRight class="w-5 h-5" />
                        </Link>
                        <Link
                            v-if="!$page.props.auth.user"
                            :href="register().url"
                            class="shop-hero-btn-secondary"
                        >
                            Créer un compte
                        </Link>
                    </div>
                </div>
            </transition>
        </div>

        <!-- Navigation Dots -->
        <div class="shop-hero-dots">
            <button
                v-for="(slide, index) in slides"
                :key="index"
                @click="currentIndex = index"
                class="shop-hero-dot"
                :class="currentIndex === index ? 'shop-hero-dot-active' : 'shop-hero-dot-inactive'"
            >
                <span class="sr-only">Slide {{ index + 1 }}</span>
            </button>
        </div>

        <!-- Navigation Arrows -->
        <button @click="prevSlide" class="shop-hero-nav shop-hero-nav-left">
            <ChevronLeft class="w-5 h-5" />
        </button>
        <button @click="nextSlide" class="shop-hero-nav shop-hero-nav-right">
            <ChevronRight class="w-5 h-5" />
        </button>
    </section>
</template>