<template>
    <section class="relative w-full h-[calc(100vh-5rem)] lg:h-[calc(100vh-6rem)] mt-20 lg:mt-24 overflow-hidden bg-black">
        <!-- Canvas pour effets visuels -->
        <canvas ref="canvasRef" class="absolute top-0 left-0 w-full h-full pointer-events-none z-5"></canvas>
        
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
                    
                    <!-- Contenu avec transitions Vue -->
                    <Transition name="slide-content" mode="out-in">
                        <div :key="currentIndex" class="absolute inset-0 flex items-center pt-10 sm:pt-20 z-20">
                            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                                <div class="max-w-3xl">
                                    <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 text-white text-xs font-semibold uppercase tracking-wider mb-4">
                                        <span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-pulse"></span>
                                        {{ slide.badge }}
                                    </div>
                                    <h1 class="text-4xl sm:text-6xl md:text-7xl lg:text-8xl font-extrabold leading-[1.1] text-white mb-3 uppercase tracking-tighter drop-shadow-lg">
                                        {{ slide.title }}
                                    </h1>
                                    <p class="text-sm sm:text-base md:text-lg text-white/80 max-w-lg mb-6 leading-relaxed">
                                        {{ slide.description }}
                                    </p>
                                    <div class="flex flex-col sm:flex-row gap-3">
                                        <Link 
                                            :href="productsIndex.url()" 
                                            class="group inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl font-semibold text-white text-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_20px_30px_-10px_rgba(37,99,235,0.4)] relative overflow-hidden"
                                        >
                                            <span class="relative z-10">Acheter maintenant</span>
                                            <ArrowRight class="w-4 h-4 relative z-10 transition-transform duration-300 group-hover:translate-x-1" />
                                            <div class="absolute inset-0 -translate-x-full group-hover:translate-x-0 transition-transform duration-500 bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
                                        </Link>
                                        <Link
                                            v-if="!$page.props.auth.user"
                                            :href="register().url"
                                            class="group inline-flex items-center justify-center gap-2 px-6 py-3 bg-white/10 backdrop-blur-sm rounded-xl font-semibold text-white text-sm border border-white/30 transition-all duration-300 hover:-translate-y-0.5 hover:bg-white/20"
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

        <!-- Navigation Flottante -->
        <div class="absolute bottom-2 sm:bottom-4 right-4 sm:right-8 z-30 flex items-center gap-2 sm:gap-3 bg-black/40 backdrop-blur-sm px-2 py-2 rounded-full border border-white/10">
            <button 
                class="group relative w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center bg-white/10 rounded-full text-white transition-all duration-300 hover:bg-blue-600 hover:scale-105"
                @click="prevSlide"
                aria-label="Slide précédent"
            >
                <ChevronLeft class="w-4 h-4 sm:w-5 sm:h-5" />
                <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-black/80 rounded text-[10px] text-white whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                    Précédent
                </span>
            </button>
            
            <div class="min-w-[80px] sm:min-w-[100px] flex items-center gap-2 sm:gap-3">
                <div class="flex-1 h-0.5 bg-white/20 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-blue-500 to-purple-500 rounded-full transition-all duration-300" :style="{ width: `${progressPercent}%` }"></div>
                </div>
                <div class="text-xs sm:text-sm font-semibold text-white tabular-nums">
                    <span class="text-blue-400">{{ currentIndex + 1 }}</span>
                    <span class="text-white/50 mx-0.5">/</span>
                    <span>{{ slides.length }}</span>
                </div>
            </div>
            
            <button 
                class="group relative w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center bg-white/10 rounded-full text-white transition-all duration-300 hover:bg-blue-600 hover:scale-105"
                @click="nextSlide"
                aria-label="Slide suivant"
            >
                <ChevronRight class="w-4 h-4 sm:w-5 sm:h-5" />
                <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-black/80 rounded text-[10px] text-white whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                    Suivant
                </span>
            </button>
        </div>

        <!-- Thumbnails -->
        <div class="absolute bottom-2 sm:bottom-4 left-4 sm:left-8 z-30 max-w-[280px] sm:max-w-[400px] overflow-x-auto scrollbar-hide">
            <div ref="thumbnailsTrackRef" class="flex gap-2 sm:gap-3 p-1">
                <button
                    v-for="(slide, index) in slides"
                    :key="index"
                    class="group relative flex-none w-14 h-14 sm:w-[70px] sm:h-[70px] rounded-xl overflow-hidden cursor-pointer transition-all duration-300 opacity-50 hover:opacity-75"
                    :class="{ 'ring-2 ring-blue-500 opacity-100 scale-105': currentIndex === index }"
                    @click="goToSlide(index)"
                >
                    <img :src="slide.image" :alt="slide.title" class="w-full h-full object-cover" />
                    <span class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent text-white text-[10px] font-semibold py-1 text-center uppercase">{{ slide.badge.split(' ')[0] }}</span>
                </button>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute left-4 sm:left-8 bottom-2 sm:bottom-4 z-30 flex flex-col items-center gap-2">
            <span class="text-[10px] font-semibold tracking-[0.2em] text-white/60 [writing-mode:vertical-rl] rotate-180">SCROLL</span>
            <div class="w-px h-10 bg-gradient-to-b from-white/60 to-transparent animate-[scrollLine_2s_ease-in-out_infinite]"></div>
        </div>
    </section>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted, watch, nextTick } from 'vue';
import { Link } from '@inertiajs/vue3';
import { index as productsIndex } from '@/actions/App/Http/Controllers/ProductController';
import { register } from '@/routes';
import { Sparkles, ArrowRight, ChevronLeft, ChevronRight } from 'lucide-vue-next';

// Types
interface Slide {
    id: number;
    image: string;
    badge: string;
    title: string;
    description: string;
}

// Slides data
const slides: Slide[] = [
    {
        id: 1,
        image: '/images/hero/construction.jpg',
        badge: 'Gros Œuvre',
        title: 'Matériaux de Construction',
        description: 'Ciment, briques et structures de qualité pour des chantiers solides.'
    },
    {
        id: 2,
        image: '/images/hero/plomberie.jpg',
        badge: 'Installation Sanitaire',
        title: 'Expertise en Plomberie',
        description: 'Tout pour vos réseaux d\'eau : tubes, raccords et robinetterie pro.'
    },
    {
        id: 3,
        image: '/images/hero/electricite.jpg',
        badge: 'Énergie & Sécurité',
        title: 'Matériel Électrique',
        description: 'Câblage, tableaux et appareillage pour des installations aux normes.'
    }
];

// État
const currentIndex = ref(0);
const isAnimating = ref(false);
const touchStartX = ref(0);
const touchEndX = ref(0);
const progressPercent = ref(0);
const canvasRef = ref<HTMLCanvasElement | null>(null);
const thumbnailsTrackRef = ref<HTMLElement | null>(null);
let autoplayInterval: ReturnType<typeof setInterval> | null = null;
let animationFrame: number | null = null;

// Création d'un tableau avec duplication pour effet infini
const slidesWithDuplicate = computed(() => {
    return [slides[slides.length - 1], ...slides, slides[0]];
});

// Vérifier si un slide est actif
const isActive = (index: number): boolean => {
    const virtualCurrentIndex = currentIndex.value + 1;
    return index === virtualCurrentIndex;
};

// Style du track pour le défilement horizontal
const trackStyle = computed(() => {
    const virtualIndex = currentIndex.value + 1;
    const translateX = -(virtualIndex * 100);
    return {
        transform: `translateX(${translateX}%)`,
        transition: isAnimating.value ? 'transform 0.6s cubic-bezier(0.4, 0, 0.2, 1)' : 'none'
    };
});

// Mise à jour de la progression
const updateProgress = () => {
    progressPercent.value = ((currentIndex.value + 1) / slides.length) * 100;
};

// Navigation
const nextSlide = async () => {
    if (isAnimating.value) return;
    
    isAnimating.value = true;
    
    const nextIndex = currentIndex.value + 1;
    if (nextIndex >= slides.length) {
        currentIndex.value = 0;
        await nextTick();
        setTimeout(() => {
            isAnimating.value = false;
        }, 600);
    } else {
        currentIndex.value = nextIndex;
        setTimeout(() => {
            isAnimating.value = false;
        }, 600);
    }
    
    updateProgress();
    resetAutoplay();
};

const prevSlide = async () => {
    if (isAnimating.value) return;
    
    isAnimating.value = true;
    
    const prevIndex = currentIndex.value - 1;
    if (prevIndex < 0) {
        currentIndex.value = slides.length - 1;
        await nextTick();
        setTimeout(() => {
            isAnimating.value = false;
        }, 600);
    } else {
        currentIndex.value = prevIndex;
        setTimeout(() => {
            isAnimating.value = false;
        }, 600);
    }
    
    updateProgress();
    resetAutoplay();
};

const goToSlide = async (index: number) => {
    if (isAnimating.value || index === currentIndex.value) return;
    
    isAnimating.value = true;
    currentIndex.value = index;
    updateProgress();
    resetAutoplay();
    
    setTimeout(() => {
        isAnimating.value = false;
    }, 600);
};

// Autoplay
const startAutoplay = () => {
    if (autoplayInterval) clearInterval(autoplayInterval);
    autoplayInterval = setInterval(() => {
        if (!isAnimating.value) {
            nextSlide();
        }
    }, 6000);
};

const resetAutoplay = () => {
    if (autoplayInterval) {
        clearInterval(autoplayInterval);
        startAutoplay();
    }
};

// Touch events pour mobile
const handleTouchStart = (e: TouchEvent) => {
    touchStartX.value = e.touches[0].clientX;
};

const handleTouchMove = (e: TouchEvent) => {
    touchEndX.value = e.touches[0].clientX;
};

const handleTouchEnd = () => {
    const deltaX = touchEndX.value - touchStartX.value;
    if (Math.abs(deltaX) > 50) {
        if (deltaX > 0) {
            prevSlide();
        } else {
            nextSlide();
        }
    }
    touchStartX.value = 0;
    touchEndX.value = 0;
};

// Effet canvas (particules)
const initCanvas = () => {
    if (!canvasRef.value) return;
    
    const canvas = canvasRef.value;
    const ctx = canvas.getContext('2d');
    if (!ctx) return;
    
    let particles: Array<{
        x: number;
        y: number;
        radius: number;
        alpha: number;
        speedX: number;
        speedY: number;
    }> = [];
    
    const resizeCanvas = () => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        initParticles();
    };
    
    const initParticles = () => {
        particles = [];
        const particleCount = Math.min(Math.floor(window.innerWidth / 30), 40);
        for (let i = 0; i < particleCount; i++) {
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
    
    const animateParticles = () => {
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
            ctx.fillStyle = `rgba(255, 255, 255, ${p.alpha})`;
            ctx.fill();
        });
        
        animationFrame = requestAnimationFrame(animateParticles);
    };
    
    window.addEventListener('resize', resizeCanvas);
    resizeCanvas();
    animateParticles();
};

// Scroll des thumbnails
const updateThumbnailsScroll = () => {
    if (!thumbnailsTrackRef.value) return;
    const activeThumb = thumbnailsTrackRef.value.querySelector('.ring-2') as HTMLElement;
    if (activeThumb) {
        const containerRect = thumbnailsTrackRef.value.parentElement?.getBoundingClientRect();
        const thumbRect = activeThumb.getBoundingClientRect();
        if (containerRect && (thumbRect.right > containerRect.right || thumbRect.left < containerRect.left)) {
            activeThumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
        }
    }
};

// Cycle de vie
onMounted(async () => {
    await nextTick();
    
    // Préchargement des images
    const imagePromises = slides.map(slide => {
        return new Promise((resolve) => {
            const img = new Image();
            img.src = slide.image;
            img.onload = resolve;
            img.onerror = resolve;
        });
    });
    await Promise.all(imagePromises);
    
    // Initialisation
    startAutoplay();
    initCanvas();
    updateProgress();
    
    // Observer pour les thumbnails
    watch(currentIndex, () => {
        updateThumbnailsScroll();
    });
});

onUnmounted(() => {
    if (autoplayInterval) clearInterval(autoplayInterval);
    if (animationFrame) cancelAnimationFrame(animationFrame);
});
</script>

<style scoped>
/* Animation pour le contenu des slides */
.slide-content-enter-active {
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}
.slide-content-leave-active {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.slide-content-enter-from {
    opacity: 0;
    transform: translateY(20px);
}
.slide-content-leave-to {
    opacity: 0;
    transform: translateY(-20px);
}

/* Animation pour scrollLine */
@keyframes scrollLine {
    0% {
        transform: scaleY(0.3);
        opacity: 0;
        transform-origin: top;
    }
    50% {
        transform: scaleY(1);
        opacity: 1;
        transform-origin: top;
    }
    100% {
        transform: scaleY(0.3);
        opacity: 0;
        transform-origin: top;
    }
}

.animate-\[scrollLine_2s_ease-in-out_infinite\] {
    animation: scrollLine 2s ease-in-out infinite;
}

/* Cacher la scrollbar pour les thumbnails */
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
</style>