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
        <section class="relative pt-36 pb-20 overflow-hidden">
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
        <section class="py-8 border-y border-slate-100 dark:border-slate-800">
            <div class="max-w-7xl mx-auto px-6 lg:px-12">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div v-for="stat in ['15k+ Clients', '500+ Produits', '24h Livraison', '100% Sécurisé']" :key="stat" class="text-center">
                        <span class="text-xs font-black uppercase tracking-[0.3em] text-slate-400">{{ stat }}</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Categories Horizontal Scroll -->
        <section class="py-16 overflow-hidden bg-slate-50/50 dark:bg-slate-900/30">
            <div class="max-w-7xl mx-auto px-6 lg:px-12 space-y-10">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                    <div class="space-y-3">
                        <div class="inline-flex items-center gap-2 text-indigo-600 font-black uppercase tracking-widest text-[10px]">
                            <Layers class="w-4 h-4" /> Collections
                        </div>
                        <h2 class="text-3xl font-black tracking-tight uppercase italic">Par Catégories</h2>
                    </div>
                </div>

                <div class="flex gap-4 overflow-x-auto pb-6 no-scrollbar -mx-6 px-6 sm:mx-0 sm:px-0">
                    <Link
                        v-for="cat in categories"
                        :key="cat.id"
                        :href="`/products?category=${cat.slug}`"
                        class="min-w-[220px] h-[280px] relative rounded-[2rem] overflow-hidden group flex-shrink-0"
                    >
                        <img
                            v-if="cat.image"
                            :src="cat.image"
                            :alt="cat.name"
                            class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                        />
                        <div v-else class="absolute inset-0 bg-gradient-to-br from-blue-100 to-indigo-200 dark:from-slate-800 dark:to-slate-700"></div>
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/20 to-transparent"></div>
                        <div class="absolute bottom-6 left-6 text-white space-y-1">
                            <h4 class="text-lg font-black uppercase italic">{{ cat.name }}</h4>
                            <p class="text-[10px] font-bold uppercase tracking-widest opacity-60">{{ cat.products_count }} Articles</p>
                        </div>
                    </Link>
                </div>
            </div>
        </section>

        <!-- New Arrivals -->
        <section class="py-16">
            <div class="max-w-7xl mx-auto px-6 lg:px-12 space-y-10">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                    <div class="space-y-3">
                        <div class="inline-flex items-center gap-2 text-blue-600 font-black uppercase tracking-widest text-[10px]">
                            <Zap class="w-4 h-4" /> Just arrived
                        </div>
                        <h2 class="text-3xl font-black tracking-tight uppercase italic">Nouveautés</h2>
                    </div>
                    <Link :href="products.index().url" class="group flex items-center gap-3 font-black text-xs uppercase tracking-widest">
                        Tout voir <ArrowRight class="w-4 h-4 group-hover:translate-x-2 transition-transform" />
                    </Link>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                    <ProductCard v-for="product in newArrivals" :key="product.id" :product="product" />
                </div>
            </div>
        </section>

        <!-- Tech Focus Bento -->
        <section class="py-20 bg-slate-950 text-white rounded-[3rem] mx-6 lg:mx-12 overflow-hidden relative">
            <div class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(circle_at_30%_30%,#1e3a8a_0%,transparent_50%)] opacity-30"></div>
            <div class="max-w-7xl mx-auto px-10 lg:px-12 relative z-10 space-y-14">
                <div class="max-w-2xl space-y-4">
                    <h2 class="text-4xl font-black uppercase italic leading-[0.9]">La Technologie <br/><span class="text-blue-500">Sans Compromis</span></h2>
                    <p class="text-slate-400 font-medium">Nous collaborons avec les plus grandes marques pour vous offrir le meilleur de l'innovation mondiale.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-4 p-8 bg-white/5 backdrop-blur-xl rounded-[2rem] border border-white/10 hover:bg-white/10 transition-colors">
                        <Smartphone class="w-10 h-10 text-blue-500" />
                        <h3 class="text-xl font-black uppercase italic">Smartphones</h3>
                        <p class="text-slate-400 text-sm font-medium">Dernières sorties des gammes iPhone, Samsung et Google Pixel.</p>
                    </div>
                    <div class="space-y-4 p-8 bg-white/5 backdrop-blur-xl rounded-[2rem] border border-white/10 hover:bg-white/10 transition-colors">
                        <Cpu class="w-10 h-10 text-purple-500" />
                        <h3 class="text-xl font-black uppercase italic">Informatique</h3>
                        <p class="text-slate-400 text-sm font-medium">Stations de travail surpuissantes et laptops ultra-portables.</p>
                    </div>
                    <div class="space-y-4 p-8 bg-white/5 backdrop-blur-xl rounded-[2rem] border border-white/10 hover:bg-white/10 transition-colors">
                        <Headphones class="w-10 h-10 text-emerald-500" />
                        <h3 class="text-xl font-black uppercase italic">Accessoires</h3>
                        <p class="text-slate-400 text-sm font-medium">Audio haute fidélité et périphériques gaming de précision.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Hot Deals -->
        <section class="py-16" v-if="discountedProducts.length > 0">
            <div class="max-w-7xl mx-auto px-6 lg:px-12 space-y-10">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                    <div class="space-y-3">
                        <div class="inline-flex items-center gap-2 text-red-500 font-black uppercase tracking-widest text-[10px]">
                            <Star class="w-4 h-4" /> Exclusive deals
                        </div>
                        <h2 class="text-3xl font-black tracking-tight uppercase italic">Offres Spéciales</h2>
                    </div>
                    <Link :href="products.index().url" class="group flex items-center gap-3 font-black text-xs uppercase tracking-widest">
                        Tout voir <ArrowRight class="w-4 h-4 group-hover:translate-x-2 transition-transform" />
                    </Link>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                    <ProductCard v-for="product in discountedProducts" :key="product.id" :product="product" />
                </div>
            </div>
        </section>

        <!-- Features Bento -->
        <section class="py-16">
            <div class="max-w-7xl mx-auto px-6 lg:px-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="md:col-span-2 p-10 bg-blue-600 rounded-[2.5rem] text-white space-y-5 relative overflow-hidden group">
                        <div class="absolute -right-8 -bottom-8 w-48 h-48 bg-white/10 blur-3xl rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                        <Truck class="w-10 h-10 mb-2" />
                        <h3 class="text-2xl font-black tracking-tight uppercase italic">Livraison Partout</h3>
                        <p class="text-blue-100 font-medium leading-relaxed text-sm">
                            Peu importe où vous vous trouvez au Cameroun, nous vous livrons vos produits préférés en un temps record avec un suivi en temps réel.
                        </p>
                    </div>
                    <div class="p-10 bg-slate-50 dark:bg-slate-900 rounded-[2.5rem] space-y-5 border border-slate-100 dark:border-slate-800">
                        <ShieldCheck class="w-10 h-10 text-blue-600" />
                        <h3 class="text-lg font-black tracking-tight uppercase italic">Garantie</h3>
                        <p class="text-slate-500 text-sm font-medium leading-relaxed">Tous nos produits bénéficient d'une garantie constructeur officielle.</p>
                    </div>
                    <div class="p-10 bg-slate-900 dark:bg-white text-white dark:text-slate-950 rounded-[2.5rem] space-y-5">
                        <Zap class="w-10 h-10 text-blue-400 dark:text-blue-600" />
                        <h3 class="text-lg font-black tracking-tight uppercase italic">SAV Expert</h3>
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
