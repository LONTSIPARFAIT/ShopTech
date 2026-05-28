<template>
    <section class="relative py-16 md:py-20 overflow-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
        <!-- Canvas pour grandes formes animées -->
        <canvas ref="canvasRef" class="absolute top-0 left-0 w-full h-full pointer-events-none z-0"></canvas>

        <!-- Effets de fond -->
        <div class="absolute inset-0 pointer-events-none z-0">
            <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-orange-500/8 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-orange-600/5 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- En-tête -->
            <div class="text-center max-w-2xl mx-auto mb-12">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-500/10 border border-orange-500/20 mb-5">
                    <span class="w-1 h-1 bg-orange-500 rounded-full"></span>
                    <span class="text-[10px] font-semibold uppercase tracking-wider text-orange-400">Notre expertise</span>
                </div>
                <h2 class="text-2xl md:text-3xl font-bold text-white mb-3">
                    La technologie <span class="text-orange-500">sans compromis</span>
                </h2>
                <p class="text-slate-300 text-sm max-w-md mx-auto">
                    Les meilleures marques pour vos projets
                </p>
            </div>

            <!-- Grille -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <TechCard
                    v-for="tech in techItems"
                    :key="tech.title"
                    :icon="tech.icon"
                    :title="tech.title"
                    :description="tech.description"
                />
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import { Wrench, Zap, Hammer } from 'lucide-vue-next';
import TechCard from '@/components/Home/TechCard.vue';

const techItems = [
    {
        icon: Wrench,
        title: 'Plomberie',
        description: 'Solutions d\'adduction d\'eau et d\'évacuation durables et fiables.'
    },
    {
        icon: Zap,
        title: 'Électricité',
        description: 'Matériel haute performance pour des installations électriques sûres.'
    },
    {
        icon: Hammer,
        title: 'Outillage',
        description: 'Outils robustes pour professionnels exigeants.'
    }
];

const canvasRef = ref<HTMLCanvasElement | null>(null);
let animationFrame: number | null = null;

// Grandes formes
let shapes: Array<{
    x: number;
    y: number;
    radius: number;
    speedX: number;
    speedY: number;
    opacity: number;
}> = [];

const initCanvas = () => {
    if (!canvasRef.value) return;

    const canvas = canvasRef.value;
    const ctx = canvas.getContext('2d');
    if (!ctx) return;

    const resizeCanvas = () => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        initShapes();
    };

    const initShapes = () => {
        shapes = [];
        // 4 grandes formes bien visibles
        for (let i = 0; i < 4; i++) {
            shapes.push({
                x: Math.random() * canvas.width,
                y: Math.random() * canvas.height,
                radius: 150 + Math.random() * 200,
                speedX: (Math.random() - 0.5) * 0.5,
                speedY: (Math.random() - 0.5) * 0.4,
                opacity: 0.15 + Math.random() * 0.1
            });
        }
    };

    const animate = () => {
        if (!ctx || !canvas) return;

        ctx.clearRect(0, 0, canvas.width, canvas.height);

        shapes.forEach(shape => {
            // Déplacement
            shape.x += shape.speedX;
            shape.y += shape.speedY;

            // Réapparition de l'autre côté
            if (shape.x + shape.radius < 0) shape.x = canvas.width + shape.radius;
            if (shape.x - shape.radius > canvas.width) shape.x = -shape.radius;
            if (shape.y + shape.radius < 0) shape.y = canvas.height + shape.radius;
            if (shape.y - shape.radius > canvas.height) shape.y = -shape.radius;

            // Dessiner le cercle avec contour visible
            ctx.beginPath();
            ctx.arc(shape.x, shape.y, shape.radius, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(249, 115, 22, ${shape.opacity})`;
            ctx.fill();

            // Contour du cercle
            ctx.beginPath();
            ctx.arc(shape.x, shape.y, shape.radius, 0, Math.PI * 2);
            ctx.strokeStyle = `rgba(249, 115, 22, ${shape.opacity + 0.1})`;
            ctx.lineWidth = 2;
            ctx.stroke();
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
