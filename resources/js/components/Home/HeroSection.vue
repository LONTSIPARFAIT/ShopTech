<template>
    <section class="relative min-h-[95vh] flex items-center overflow-hidden pt-24 lg:pt-32">
        <!-- Background Image avec transition horizontale -->
        <div class="absolute inset-0 z-0 overflow-hidden">
            <transition name="slide-x" mode="out-in">
                <div :key="currentIndex" class="absolute inset-0">
                    <img
                        :src="currentSlide.image"
                        :alt="currentSlide.title"
                        class="w-full h-full object-cover brightness-[0.4] lg:brightness-[0.6]"
                    />
                    <!-- Plus de gradient latéral, juste un overlay subtil si besoin, mais on l'enlève pour satisfaire l'utilisateur -->
                </div>
            </transition>
        </div>

        <!-- Contenu principal -->
        <div class="relative z-10 w-full">
            <div class="max-w-7xl mx-auto px-6 lg:px-12">
                <div class="max-w-3xl space-y-8">
                    <transition name="slide-up" mode="out-in">
                        <div :key="currentSlide" class="space-y-6">
                            <!-- Badge -->
                            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-md rounded-full text-white text-sm font-semibold">
                                <Sparkles class="w-4 h-4 text-yellow-400" />
                                {{ currentSlide.badge }}
                            </div>

                            <!-- Title -->
                            <h1 class="text-4xl sm:text-5xl md:text-7xl lg:text-8xl font-bold text-white leading-[1.1]">
                                {{ currentSlide.title }}
                            </h1>
                            
                            <!-- Description -->
                            <p class="text-base sm:text-lg md:text-xl text-gray-200 max-w-2xl">
                                {{ currentSlide.description }}
                            </p>

                            <!-- CTA Buttons -->
                            <div class="flex flex-wrap gap-4">
                                <Link
                                    :href="productsIndex.url()"
                                    class="px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold transition-all hover:scale-105 inline-flex items-center gap-2"
                                >
                                    Acheter maintenant
                                    <ArrowRight class="w-5 h-5" />
                                </Link>
                                <Link
                                    v-if="!$page.props.auth.user"
                                    :href="register()"
                                    class="px-8 py-4 bg-white/10 backdrop-blur-md hover:bg-white/20 text-white rounded-xl font-semibold transition-all"
                                >
                                    Créer un compte
                                </Link>
                            </div>
                        </div>
                    </transition>
                </div>
            </div>
        </div>

        <!-- Dots de navigation -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-20 flex gap-3">
            <button
                v-for="(slide, index) in slides"
                :key="index"
                @click="currentIndex = index"
                class="transition-all duration-300 rounded-full bg-white/30 hover:bg-white/60"
                :class="currentIndex === index ? 'w-8 bg-blue-600' : 'w-2 h-2'"
                :style="currentIndex === index ? { width: '32px', height: '8px' } : { width: '8px', height: '8px' }"
            >
                <span class="sr-only">Slide {{ index + 1 }}</span>
            </button>
        </div>

        <!-- Flèches de navigation -->
        <button
            @click="prevSlide"
            class="absolute left-6 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-white/10 backdrop-blur-md hover:bg-white/20 transition-all flex items-center justify-center group"
        >
            <ChevronLeft class="w-6 h-6 text-white group-hover:scale-110 transition-transform" />
        </button>
        <button
            @click="nextSlide"
            class="absolute right-6 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-white/10 backdrop-blur-md hover:bg-white/20 transition-all flex items-center justify-center group"
        >
            <ChevronRight class="w-6 h-6 text-white group-hover:scale-110 transition-transform" />
        </button>
    </section>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import { index as productsIndex } from '@/actions/App/Http/Controllers/ProductController';
import { register } from '@/routes';
import { Sparkles, ArrowRight, ChevronLeft, ChevronRight } from 'lucide-vue-next';

const slides = [
    {
        image: 'https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?w=1920&q=80',
        badge: 'Nouvelle Collection',
        title: 'iPhone 15 Pro Max',
        description: 'Le plus puissant iPhone jamais créé. Design en titanium, puce A17 Pro et autonomie exceptionnelle.'
    },
    {
        image: 'https://images.unsplash.com/photo-1541807084-5c52b6b3adef?w=1920&q=80',
        badge: 'Performance Extrême',
        title: 'MacBook Pro M3',
        description: 'Jusqu\'à 22h d\'autonomie. La puissance d\'une station de travail dans un laptop.'
    },
    {
        image: 'https://images.unsplash.com/photo-1581091226033-d5c48150dbaa?w=1920&q=80',
        badge: 'Black Friday',
        title: 'Jusqu\'à -40%',
        description: 'Profitez des meilleures offres sur une sélection de produits high-tech. Quantités limitées !'
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

let autoplayInterval: NodeJS.Timeout;

const startAutoplay = () => {
    autoplayInterval = setInterval(nextSlide, 5000);
};

onMounted(() => {
    startAutoplay();
});

onUnmounted(() => {
    if (autoplayInterval) {
        clearInterval(autoplayInterval);
    }
});
</script>

<style scoped>
.slide-x-enter-active,
.slide-x-leave-active {
    transition: all 1s cubic-bezier(0.4, 0, 0.2, 1);
}
.slide-x-enter-from {
    transform: translateX(100%);
}
.slide-x-leave-to {
    transform: translateX(-100%);
}

.slide-up-enter-active,
.slide-up-leave-active {
    transition: all 0.5s ease-out;
}
.slide-up-enter-from {
    opacity: 0;
    transform: translateY(30px);
}
.slide-up-leave-to {
    opacity: 0;
    transform: translateY(-30px);
}
</style>