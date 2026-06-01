<template>
    <section class="relative w-full h-[calc(100vh-5rem)] lg:h-[calc(100vh-6rem)] mt-20 lg:mt-24 overflow-hidden bg-black">
        <!-- Canvas pour effets visuels -->
        <canvas ref="canvasRef" class="absolute top-0 left-0 w-full h-full pointer-events-none z-0"></canvas>

        <!-- Slides Container -->
        <div class="relative w-full h-full overflow-hidden">
            <div
                class="flex w-full h-full will-change-transform"
                :style="trackStyle"
                @touchstart="handleTouchStart"
                @touchmove="handleTouchMove"
                @touchend="handleTouchEnd"
            >
                <div
                    v-for="(slide, index) in slidesWithDuplicate"
                    :key="slide.id"
                    class="relative flex-none w-full h-full overflow-hidden"
                    :class="{ 'z-10': isActive(index) }"
                >
                    <!-- Image avec parallax -->
                    <div class="absolute -inset-[10%] w-[120%] h-[120%] overflow-hidden">
                        <img
                            :src="slide.image"
                            :alt="slide.title"
                            class="w-full h-full object-cover brightness-[0.45] saturate-110 will-change-transform transition-transform duration-[8000ms] ease-out"
                            :class="{ 'scale-110': isActive(index) }"
                            loading="eager"
                            fetchpriority="high"
                        />
                        <div class="absolute inset-0 bg-gradient-to-br from-black/60 via-black/30 to-black/70"></div>
                    </div>

                    <!-- Contenu -->
                    <Transition name="slide-content" mode="out-in">
                        <div :key="currentIndex" class="absolute inset-0 flex items-center justify-center z-20 pt-20 pb-24 sm:pb-32">
                            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                                <div class="max-w-3xl">
                                    <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 text-white text-xs font-semibold uppercase tracking-wider mb-4">
                                        <span class="w-1.5 h-1.5 bg-primary rounded-full animate-pulse"></span>
                                        {{ slide.badge }}
                                    </div>
                                    <h1 class="text-4xl sm:text-6xl md:text-7xl lg:text-8xl font-extrabold text-white mb-3 drop-shadow-lg">
                                        {{ slide.title }}
                                    </h1>
                                    <p class="text-sm sm:text-base md:text-lg text-white/80 max-w-lg mb-6 leading-relaxed">
                                        {{ slide.description }}
                                    </p>
                                    <div class="flex flex-col sm:flex-row gap-3">
                                        <Link
                                            :href="productsIndex.url()"
                                            class="group inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-primary to-primary-dark rounded-xl font-semibold text-white text-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_20px_30px_-10px_rgba(249,115,22,0.4)] relative overflow-hidden"
                                        >
                                            <span class="relative z-10">Acheter maintenant</span>
                                            <ArrowRight class="w-4 h-4 relative z-10 transition-transform duration-300 group-hover:translate-x-1" />
                                            <div class="absolute inset-0 -translate-x-full group-hover:translate-x-0 transition-transform duration-500 bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
                                        </Link>
                                        <Link
                                            v-if="!$page.props.auth.user"
                                            :href="register().url"
                                            class="group inline-flex items-center justify-center gap-2 px-6 py-3 bg-white/10 backdrop-blur-sm rounded-xl font-semibold text-white text-sm border border-white/30 transition-all duration-300 hover:-translate-y-0.5 hover:bg-white/20 hover:border-primary/50"
                                        >
                                            <span>Créer un compte</span>
                                            <Sparkles class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-0.5" />
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </Transition>
                </div>
            </div>
        </div>

        <!-- Navigation - Flèches (contenues dans la section) -->
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-30 flex items-center gap-4 bg-black/50 backdrop-blur-md px-4 py-2 rounded-full border border-white/20">
            <button
                @click="prevSlide"
                class="w-9 h-9 flex items-center justify-center bg-white/20 rounded-full text-white transition-all duration-300 hover:bg-primary hover:scale-110"
            >
                <ChevronLeft class="w-4 h-4" />
            </button>
            <div class="flex gap-1">
                <button
                    v-for="(slide, idx) in slides"
                    :key="idx"
                    @click="goToSlide(idx)"
                    class="transition-all duration-300 rounded-full"
                    :class="[
                        currentIndex === idx
                            ? 'w-6 h-1.5 bg-primary'
                            : 'w-1.5 h-1.5 bg-white/50 hover:bg-white/80'
                    ]"
                ></button>
            </div>
            <button
                @click="nextSlide"
                class="w-9 h-9 flex items-center justify-center bg-white/20 rounded-full text-white transition-all duration-300 hover:bg-primary hover:scale-110"
            >
                <ChevronRight class="w-4 h-4" />
            </button>
        </div>
    </section>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted, watch, nextTick } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { index as productsIndex } from '@/actions/App/Http/Controllers/ProductController';
import { register } from '@/routes';
import { Sparkles, ArrowRight, ChevronLeft, ChevronRight } from 'lucide-vue-next';

const page = usePage();

interface Slide {
    id: number;
    image: string;
    badge: string;
    title: string;
    description: string;
}

const slides: Slide[] = [
    {
        id: 1,
        image: '/images/hero/plomberie.jpg',
        badge: 'Plomberie',
        title: 'Installation Sanitaire',
        description: 'Tuyauterie, robinetterie, chauffe-eau. Installation et réparation par des plombiers certifiés.'
    },
    {
        id: 2,
        image: '/images/hero/electricite.jpg',
        badge: 'Électricité',
        title: 'Installation Électrique',
        description: 'Câblage, tableaux, éclairage. Mise aux normes et dépannage par des électriciens professionnels.'
    }
];

const currentIndex = ref(0);
const isAnimating = ref(false);
const touchStartX = ref(0);
const touchEndX = ref(0);
const canvasRef = ref<HTMLCanvasElement | null>(null);
let autoplayInterval: ReturnType<typeof setInterval> | null = null;
let animationFrame: number | null = null;

const slidesWithDuplicate = computed(() => {
    return [slides[slides.length - 1], ...slides, slides[0]];
});

const isActive = (index: number): boolean => {
    const virtualCurrentIndex = currentIndex.value + 1;
    return index === virtualCurrentIndex;
};

const trackStyle = computed(() => {
    const virtualIndex = currentIndex.value + 1;
    const translateX = -(virtualIndex * 100);
    return {
        transform: `translateX(${translateX}%)`,
        transition: isAnimating.value ? 'transform 0.6s cubic-bezier(0.4, 0, 0.2, 1)' : 'none'
    };
});

const nextSlide = async () => {
    if (isAnimating.value) return;
    isAnimating.value = true;

    const nextIndex = currentIndex.value + 1;
    if (nextIndex >= slides.length) {
        currentIndex.value = 0;
        await nextTick();
        setTimeout(() => { isAnimating.value = false; }, 600);
    } else {
        currentIndex.value = nextIndex;
        setTimeout(() => { isAnimating.value = false; }, 600);
    }
    resetAutoplay();
};

const prevSlide = async () => {
    if (isAnimating.value) return;
    isAnimating.value = true;

    const prevIndex = currentIndex.value - 1;
    if (prevIndex < 0) {
        currentIndex.value = slides.length - 1;
        await nextTick();
        setTimeout(() => { isAnimating.value = false; }, 600);
    } else {
        currentIndex.value = prevIndex;
        setTimeout(() => { isAnimating.value = false; }, 600);
    }
    resetAutoplay();
};

const goToSlide = async (index: number) => {
    if (isAnimating.value || index === currentIndex.value) return;
    isAnimating.value = true;
    currentIndex.value = index;
    resetAutoplay();
    setTimeout(() => { isAnimating.value = false; }, 600);
};

const startAutoplay = () => {
    if (autoplayInterval) clearInterval(autoplayInterval);
    autoplayInterval = setInterval(() => {
        if (!isAnimating.value) nextSlide();
    }, 6000);
};

const resetAutoplay = () => {
    if (autoplayInterval) {
        clearInterval(autoplayInterval);
        startAutoplay();
    }
};

const handleTouchStart = (e: TouchEvent) => { touchStartX.value = e.touches[0].clientX; };
const handleTouchMove = (e: TouchEvent) => { touchEndX.value = e.touches[0].clientX; };
const handleTouchEnd = () => {
    const deltaX = touchEndX.value - touchStartX.value;
    if (Math.abs(deltaX) > 50) {
        deltaX > 0 ? prevSlide() : nextSlide();
    }
};

const initCanvas = () => {
    if (!canvasRef.value) return;
    const canvas = canvasRef.value;
    const ctx = canvas.getContext('2d');
    if (!ctx) return;

    let particles: any[] = [];

    const resizeCanvas = () => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        particles = [];
        const count = Math.min(Math.floor(window.innerWidth / 40), 50);
        for (let i = 0; i < count; i++) {
            particles.push({
                x: Math.random() * canvas.width,
                y: Math.random() * canvas.height,
                radius: Math.random() * 2 + 0.5,
                alpha: Math.random() * 0.2 + 0.05,
                speedX: (Math.random() - 0.5) * 0.3,
                speedY: (Math.random() - 0.5) * 0.3
            });
        }
    };

    const animate = () => {
        if (!ctx || !canvas) return;
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        particles.forEach(p => {
            p.x += p.speedX;
            p.y += p.speedY;
            if (p.x < 0) p.x = canvas.width;
            if (p.x > canvas.width) p.x = 0;
            if (p.y < 0) p.y = canvas.height;
            if (p.y > canvas.height) p.y = 0;
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(249, 115, 22, ${p.alpha})`;
            ctx.fill();
        });
        animationFrame = requestAnimationFrame(animate);
    };

    window.addEventListener('resize', resizeCanvas);
    resizeCanvas();
    animate();
};

onMounted(async () => {
    await nextTick();
    startAutoplay();
    initCanvas();
});

onUnmounted(() => {
    if (autoplayInterval) clearInterval(autoplayInterval);
    if (animationFrame) cancelAnimationFrame(animationFrame);
});
</script>

<style scoped>
.slide-content-enter-active, .slide-content-leave-active {
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}
.slide-content-enter-from {
    opacity: 0;
    transform: translateY(20px);
}
.slide-content-leave-to {
    opacity: 0;
    transform: translateY(-20px);
}
</style>
