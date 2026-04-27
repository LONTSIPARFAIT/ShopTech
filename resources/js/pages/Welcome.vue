<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import ProductCard from '@/components/Shop/ProductCard.vue';
import ShopLayout from '@/Layouts/ShopLayout.vue';
import products from '@/routes/products';
import { Sparkles, Zap, ShieldCheck, Truck, ArrowRight, Star, Layers, Cpu, Smartphone, Headphones } from 'lucide-vue-next';

const props = defineProps<{
    canRegister: boolean;
    newArrivals: any[];
    discountedProducts: any[];
    categories: any[];
}>();

const isLoaded = ref(false);

onMounted(() => {
    isLoaded.value = true;
});
</script>

<template>
    <ShopLayout>
        <Head title="Bienvenue chez ShopTech - L'excellence Technologique" />

        <!-- Hero Section -->
        <section class="relative pt-48 pb-32 overflow-hidden">
            <!-- Background Elements -->
            <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-[800px] h-[800px] bg-blue-500/10 blur-[120px] rounded-full pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/2 w-[600px] h-[600px] bg-purple-500/10 blur-[100px] rounded-full pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-6 lg:px-12 text-center space-y-12 relative">
                <div 
                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full text-[10px] font-black tracking-[0.2em] uppercase mb-4 animate-fade-in border border-blue-100 dark:border-blue-800"
                >
                    <Sparkles class="w-3 h-3" />
                    L'innovation à portée de main
                </div>

                <h1 class="text-6xl md:text-9xl font-black tracking-tighter leading-[0.85] max-w-5xl mx-auto uppercase italic">
                    The Next <br/> <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-400">Digital Era</span>
                </h1>

                <p class="text-xl text-slate-500 dark:text-slate-400 max-w-2xl mx-auto leading-relaxed font-medium">
                    Plongez dans l'univers de la haute technologie. Des produits sélectionnés pour leur performance et leur design d'exception.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-6 pt-8">
                    <Link 
                        :href="products.index().url" 
                        class="px-12 py-5 bg-slate-900 dark:bg-white text-white dark:text-slate-950 rounded-2xl font-black text-lg shadow-2xl hover:-translate-y-1 transition-all active:scale-[0.98] uppercase tracking-widest"
                    >
                        Boutique
                    </Link>
                    <Link 
                        v-if="!$page.props.auth.user"
                        href="/register" 
                        class="px-12 py-5 bg-white dark:bg-slate-900 text-slate-900 dark:text-white border border-slate-200 dark:border-slate-800 rounded-2xl font-black text-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-all uppercase tracking-widest"
                    >
                        Rejoindre
                    </Link>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-12 border-y border-slate-100 dark:border-slate-800">
            <div class="max-w-7xl mx-auto px-6 lg:px-12">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div v-for="stat in ['15k+ Clients', '500+ Produits', '24h Livraison', '100% Secure']" :key="stat" class="text-center">
                        <span class="text-xs font-black uppercase tracking-[0.3em] text-slate-400">{{ stat }}</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Categories Horizontal Scroll -->
        <section class="py-32 overflow-hidden bg-slate-50/50 dark:bg-slate-900/30">
            <div class="max-w-7xl mx-auto px-6 lg:px-12 space-y-16">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-8">
                    <div class="space-y-4">
                        <div class="inline-flex items-center gap-2 text-indigo-600 font-black uppercase tracking-widest text-[10px]">
                            <Layers class="w-4 h-4" /> Collections
                        </div>
                        <h2 class="text-5xl font-black tracking-tight uppercase italic">Par Catégories</h2>
                    </div>
                </div>

                <div class="flex gap-6 overflow-x-auto pb-12 no-scrollbar -mx-6 px-6 sm:mx-0 sm:px-0">
                    <Link 
                        v-for="cat in categories" 
                        :key="cat.id"
                        :href="`/products?category=${cat.slug}`"
                        class="min-w-[300px] h-[400px] relative rounded-[3rem] overflow-hidden group flex-shrink-0"
                    >
                        <img 
                            v-if="cat.image"
                            :src="cat.image" 
                            :alt="cat.name" 
                            class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110"
                        />
                        <div v-else class="absolute inset-0 bg-slate-200 dark:bg-slate-800"></div>
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/20 to-transparent"></div>
                        <div class="absolute bottom-10 left-10 text-white space-y-2">
                            <h4 class="text-2xl font-black uppercase italic">{{ cat.name }}</h4>
                            <p class="text-[10px] font-bold uppercase tracking-widest opacity-60">{{ cat.products_count }} Articles</p>
                        </div>
                    </Link>
                </div>
            </div>
        </section>

        <!-- New Arrivals -->
        <section class="py-32">
            <div class="max-w-7xl mx-auto px-6 lg:px-12 space-y-16">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-8">
                    <div class="space-y-4">
                        <div class="inline-flex items-center gap-2 text-blue-600 font-black uppercase tracking-widest text-[10px]">
                            <Zap class="w-4 h-4" /> Just arrived
                        </div>
                        <h2 class="text-5xl font-black tracking-tight uppercase italic">Nouveautés</h2>
                    </div>
                    <Link :href="products.index().url" class="group flex items-center gap-3 font-black text-xs uppercase tracking-widest">
                        Tout voir <ArrowRight class="w-4 h-4 group-hover:translate-x-2 transition-transform" />
                    </Link>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <ProductCard v-for="product in newArrivals" :key="product.id" :product="product" />
                </div>
            </div>
        </section>

        <!-- Tech Focus Bento -->
        <section class="py-32 bg-slate-950 text-white rounded-[4rem] mx-6 lg:mx-12 overflow-hidden relative">
            <div class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(circle_at_30%_30%,#1e3a8a_0%,transparent_50%)] opacity-30"></div>
            
            <div class="max-w-7xl mx-auto px-12 relative z-10 space-y-20">
                <div class="max-w-2xl space-y-6">
                    <h2 class="text-6xl font-black uppercase italic leading-[0.9]">La Technologie <br/><span class="text-blue-500">Sans Compromis</span></h2>
                    <p class="text-slate-400 text-lg font-medium">Nous collaborons avec les plus grandes marques pour vous offrir le meilleur de l'innovation mondiale.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                    <div class="space-y-6 p-10 bg-white/5 backdrop-blur-xl rounded-[3rem] border border-white/10 hover:bg-white/10 transition-colors">
                        <Smartphone class="w-12 h-12 text-blue-500" />
                        <h3 class="text-2xl font-black uppercase italic">Smartphones</h3>
                        <p class="text-slate-400 text-sm font-medium">Dernières sorties des gammes iPhone, Samsung et Google Pixel.</p>
                    </div>
                    <div class="space-y-6 p-10 bg-white/5 backdrop-blur-xl rounded-[3rem] border border-white/10 hover:bg-white/10 transition-colors">
                        <Cpu class="w-12 h-12 text-purple-500" />
                        <h3 class="text-2xl font-black uppercase italic">Informatique</h3>
                        <p class="text-slate-400 text-sm font-medium">Stations de travail surpuissantes et laptops ultra-portables.</p>
                    </div>
                    <div class="space-y-6 p-10 bg-white/5 backdrop-blur-xl rounded-[3rem] border border-white/10 hover:bg-white/10 transition-colors">
                        <Headphones class="w-12 h-12 text-emerald-500" />
                        <h3 class="text-2xl font-black uppercase italic">Accessoires</h3>
                        <p class="text-slate-400 text-sm font-medium">Audio haute fidélité et périphériques gaming de précision.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Hot Deals -->
        <section class="py-32" v-if="discountedProducts.length > 0">
            <div class="max-w-7xl mx-auto px-6 lg:px-12 space-y-16">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-8">
                    <div class="space-y-4">
                        <div class="inline-flex items-center gap-2 text-red-500 font-black uppercase tracking-widest text-[10px]">
                            <Star class="w-4 h-4" /> Exclusive deals
                        </div>
                        <h2 class="text-5xl font-black tracking-tight uppercase italic">Offres Spéciales</h2>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <ProductCard v-for="product in discountedProducts" :key="product.id" :product="product" />
                </div>
            </div>
        </section>

        <!-- Features Bento -->
        <section class="py-32">
            <div class="max-w-7xl mx-auto px-6 lg:px-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="md:col-span-2 p-12 bg-blue-600 rounded-[3rem] text-white space-y-6 relative overflow-hidden group">
                        <div class="absolute -right-8 -bottom-8 w-48 h-48 bg-white/10 blur-3xl rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                        <Truck class="w-12 h-12 mb-4" />
                        <h3 class="text-3xl font-black tracking-tight uppercase italic">Livraison Partout</h3>
                        <p class="text-blue-100 font-medium leading-relaxed">
                            Peu importe où vous vous trouvez au Cameroun, nous vous livrons vos produits préférés en un temps record avec un suivi en temps réel.
                        </p>
                    </div>
                    <div class="p-12 bg-slate-50 dark:bg-slate-900 rounded-[3rem] space-y-6 border border-slate-100 dark:border-slate-800">
                        <ShieldCheck class="w-12 h-12 text-blue-600" />
                        <h3 class="text-xl font-black tracking-tight uppercase italic">Garantie</h3>
                        <p class="text-slate-500 text-sm font-medium leading-relaxed">Tous nos produits bénéficient d'une garantie constructeur officielle.</p>
                    </div>
                    <div class="p-12 bg-slate-900 dark:bg-white text-white dark:text-slate-950 rounded-[3rem] space-y-6">
                        <Zap class="w-12 h-12 text-blue-400 dark:text-blue-600" />
                        <h3 class="text-xl font-black tracking-tight uppercase italic">SAV Expert</h3>
                        <p class="text-slate-400 dark:text-slate-500 text-sm font-medium leading-relaxed">Une équipe de techniciens à votre écoute pour toute assistance.</p>
                    </div>
                </div>
            </div>
        </section>
    </ShopLayout>
</template>


<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
    animation: fade-in 1s ease-out forwards;
}
</style>
