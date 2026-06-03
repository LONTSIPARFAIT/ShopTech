<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import products from '@/routes/products';
import { ArrowRight, Package, Sparkles, Star, Eye, TrendingUp } from 'lucide-vue-next';

defineProps<{
    category: {
        id: number;
        name: string;
        slug: string;
        description: string | null;
        image?: string;
        url?: string;
        products_count: number;
    };
}>();

// Canvas animation pour chaque carte
const canvasRef = ref<HTMLCanvasElement | null>(null);
let animationFrame: number | null = null;
let particles: Array<{
    x: number;
    y: number;
    radius: number;
    alpha: number;
    speedX: number;
    speedY: number;
}> = [];

const initCanvas = () => {
    if (!canvasRef.value) return;

    const canvas = canvasRef.value;
    const ctx = canvas.getContext('2d');
    if (!ctx) return;

    const resizeCanvas = () => {
        const rect = canvas.parentElement?.getBoundingClientRect();
        if (rect) {
            canvas.width = rect.width;
            canvas.height = rect.height;
            initParticles();
        }
    };

    const initParticles = () => {
        const rect = canvas.parentElement?.getBoundingClientRect();
        if (!rect) return;

        particles = [];
        const particleCount = Math.min(Math.floor(rect.width / 50), 30);

        for (let i = 0; i < particleCount; i++) {
            particles.push({
                x: Math.random() * rect.width,
                y: Math.random() * rect.height,
                radius: Math.random() * 2 + 0.5,
                alpha: Math.random() * 0.3 + 0.1,
                speedX: (Math.random() - 0.5) * 0.5,
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

onMounted(() => {
    initCanvas();
});

onUnmounted(() => {
    if (animationFrame) {
        cancelAnimationFrame(animationFrame);
        animationFrame = null;
    }
});
</script>

<template>
    <Link
        :href="products.index({ category: category.slug }).url"
        class="group relative block h-80 md:h-96 lg:h-[420px] rounded-2xl overflow-hidden cursor-pointer shadow-lg transition-all duration-500 hover:shadow-2xl hover:-translate-y-2"
    >
        <!-- Canvas pour animations -->
        <canvas ref="canvasRef" class="absolute top-0 left-0 w-full h-full pointer-events-none z-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></canvas>

        <!-- Image avec overlay -->
        <div class="absolute inset-0">
            <img
                v-if="category.url || category.image"
                :src="category.url || category.image"
                :alt="category.name"
                class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110"
                loading="lazy"
            />
            <div v-else class="w-full h-full bg-gradient-to-br from-secondary via-muted to-secondary"></div>

            <!-- Overlay gradient amélioré -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-black/10 transition-all duration-500 group-hover:from-black/95 group-hover:via-black/60 group-hover:to-black/20"></div>

            <!-- Effet de brillance au survol -->
            <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-primary/20 via-transparent to-transparent"></div>
            </div>

            <!-- Anneau lumineux -->
            <div class="absolute inset-0 rounded-2xl ring-2 ring-transparent transition-all duration-300 group-hover:ring-primary/60 group-hover:ring-offset-2 group-hover:ring-offset-black/20"></div>
        </div>

        <!-- Badge tendance -->
        <div class="absolute top-4 right-4 z-10 flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-primary to-primary-dark backdrop-blur-sm rounded-full text-white text-[10px] font-black uppercase tracking-wider shadow-lg transform transition-all duration-300 group-hover:scale-105">
            <TrendingUp class="w-3 h-3" />
            Tendance
        </div>

        <!-- Badge stock -->
        <div v-if="category.products_count > 50" class="absolute top-4 left-4 z-10 flex items-center gap-1.5 px-3 py-1.5 bg-emerald-500/90 backdrop-blur-sm rounded-full text-white text-[10px] font-black uppercase tracking-wider shadow-lg transform transition-all duration-300 group-hover:scale-105">
            <Package class="w-3 h-3" />
            {{ category.products_count }} en stock
        </div>

        <!-- Badge nouveau -->
        <div v-else class="absolute top-4 left-4 z-10 flex items-center gap-1.5 px-3 py-1.5 bg-amber-500/90 backdrop-blur-sm rounded-full text-white text-[10px] font-black uppercase tracking-wider shadow-lg transform transition-all duration-300 group-hover:scale-105">
            <Sparkles class="w-3 h-3" />
            Nouveau
        </div>

        <!-- Contenu -->
        <div class="relative z-10 flex flex-col justify-end h-full p-6">
            <!-- Icône décorative animée -->
            <div class="w-12 h-12 rounded-xl bg-white/10 backdrop-blur-sm flex items-center justify-center mb-4 transition-all duration-300 group-hover:bg-primary group-hover:scale-110 group-hover:rotate-6 shadow-lg">
                <Package class="w-6 h-6 text-white transition-transform duration-300 group-hover:scale-110" />
            </div>

            <!-- Titre avec effet de soulignement -->
            <h4 class="text-2xl md:text-3xl font-black uppercase tracking-tight text-white transition-all duration-300 group-hover:text-primary group-hover:-translate-y-1">
                {{ category.name }}
            </h4>
            <div class="w-12 h-0.5 bg-primary/50 rounded-full mt-2 transition-all duration-300 group-hover:w-20 group-hover:bg-primary"></div>

            <!-- Description -->
            <p v-if="category.description" class="text-sm text-white/80 line-clamp-2 mt-3 mb-3 leading-relaxed transition-all duration-300 group-hover:text-white/90">
                {{ category.description }}
            </p>

            <!-- Footer -->
            <div class="flex items-center justify-between mt-3 pt-2 border-t border-white/10">
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-full text-white text-[11px] font-bold uppercase tracking-wider transition-all duration-300 group-hover:bg-primary/30">
                        <Eye class="w-3 h-3" />
                        {{ category.products_count }} articles
                    </span>
                </div>

                <!-- Cercle flèche animé -->
                <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center transform translate-x-3 opacity-0 transition-all duration-300 group-hover:translate-x-0 group-hover:opacity-100 shadow-lg shadow-primary/40 hover:scale-110">
                    <ArrowRight class="w-5 h-5 text-white transition-transform duration-300 group-hover:translate-x-0.5" />
                </div>
            </div>

            <!-- Barre de progression animée -->
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-primary/20 rounded-b-2xl overflow-hidden">
                <div class="h-full w-0 bg-gradient-to-r from-primary to-primary-dark transition-all duration-700 group-hover:w-full"></div>
            </div>
        </div>

        <!-- Overlay de survol supplémentaire -->
        <div class="absolute inset-0 bg-black/0 transition-all duration-500 group-hover:bg-black/10 pointer-events-none"></div>
    </Link>
</template>
