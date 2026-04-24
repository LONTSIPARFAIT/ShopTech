<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

const isLoaded = ref(false);

onMounted(() => {
    isLoaded.value = true;
});

const features = [
    {
        title: 'Qualité Premium',
        description: 'Nous ne sélectionnons que le meilleur du hardware mondial pour votre setup.',
        icon: 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04M12 2.944a11.955 11.955 0 01-8.618 3.04M12 2.944V12m0 9.75c0-1.336-.754-2.55-1.925-3.14l-5.973-3.037a2.25 2.25 0 01-1.102-1.96V5.75M12 21.75c0-1.336.754-2.55 1.925-3.14l5.973-3.037a2.25 2.25 0 001.102-1.96V5.75'
    },
    {
        title: 'Livraison Express',
        description: 'Vos gadgets livrés à votre porte en un temps record partout au Cameroun.',
        icon: 'M13 10V3L4 14h7v7l9-11h-7z'
    },
    {
        title: 'Support Expert',
        description: 'Une équipe de passionnés pour vous conseiller sur vos choix technologiques.',
        icon: 'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z'
    }
];
</script>

<template>
    <Head title="Bienvenue chez ShopTech - L'excellence Technologique" />

    <div class="min-h-screen bg-white dark:bg-slate-950 text-slate-900 dark:text-slate-100 transition-colors duration-500 font-sans selection:bg-blue-500/30">
        
        <!-- Navigation -->
        <nav class="fixed top-0 w-full z-50 border-b border-slate-100 dark:border-slate-800/50 bg-white/70 dark:bg-slate-950/70 backdrop-blur-2xl px-6 py-4 lg:px-12">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                        <span class="text-white font-black text-xl">S</span>
                    </div>
                    <span class="text-xl font-black tracking-tighter uppercase">Shop<span class="text-blue-600">Tech</span></span>
                </div>
                
                <div class="hidden md:flex items-center gap-8 text-sm font-bold uppercase tracking-widest opacity-70">
                    <Link href="/products" class="hover:text-blue-600 transition-colors">Boutique</Link>
                    <Link href="#" class="hover:text-blue-600 transition-colors">Nouveautés</Link>
                    <Link href="#" class="hover:text-blue-600 transition-colors">Promotions</Link>
                </div>

                <div class="flex items-center gap-4">
                    <Link 
                        v-if="$page.props.auth.user" 
                        href="/dashboard" 
                        class="px-6 py-2.5 bg-slate-900 dark:bg-white text-white dark:text-slate-950 rounded-xl text-sm font-bold hover:opacity-90 transition-all"
                    >
                        Mon Compte
                    </Link>
                    <template v-else>
                        <Link href="/login" class="text-sm font-bold hover:text-blue-600 transition-colors">Connexion</Link>
                        <Link href="/register" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-500/20 hover:bg-blue-700 transition-all">S'inscrire</Link>
                    </template>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="relative pt-48 pb-32 overflow-hidden">
            <!-- Background Elements -->
            <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-[800px] h-[800px] bg-blue-500/10 blur-[120px] rounded-full pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/2 w-[600px] h-[600px] bg-purple-500/10 blur-[100px] rounded-full pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-6 lg:px-12 text-center space-y-12 relative">
                <div 
                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full text-xs font-bold tracking-widest uppercase mb-4 animate-fade-in"
                >
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                    </span>
                    La nouvelle ère tech est ici
                </div>

                <h1 class="text-6xl md:text-8xl font-black tracking-tighter leading-[0.9] max-w-4xl mx-auto">
                    Upgradez Votre <br/> <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-400">Expérience Digitale</span>
                </h1>

                <p class="text-xl text-slate-500 dark:text-slate-400 max-w-2xl mx-auto leading-relaxed">
                    Découvrez une sélection exclusive des meilleurs produits high-tech. Smartphones, laptops et accessoires premium pour les passionnés d'innovation.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-6 pt-8">
                    <Link 
                        href="/products" 
                        class="px-12 py-5 bg-slate-900 dark:bg-white text-white dark:text-slate-950 rounded-2xl font-black text-lg shadow-2xl hover:-translate-y-1 transition-all active:scale-[0.98]"
                    >
                        Explorer la Boutique
                    </Link>
                    <Link 
                        href="/register" 
                        class="px-12 py-5 bg-white dark:bg-slate-900 text-slate-900 dark:text-white border border-slate-200 dark:border-slate-800 rounded-2xl font-black text-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-all"
                    >
                        Devenir Membre
                    </Link>
                </div>
            </div>
        </section>

        <!-- Features -->
        <section class="py-32 bg-slate-50 dark:bg-slate-900/50">
            <div class="max-w-7xl mx-auto px-6 lg:px-12">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                    <div v-for="(feature, index) in features" :key="index" class="space-y-6 group">
                        <div class="w-16 h-16 bg-white dark:bg-slate-800 rounded-2xl flex items-center justify-center shadow-xl group-hover:bg-blue-600 group-hover:text-white transition-all duration-500 group-hover:-rotate-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" :d="feature.icon" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold">{{ feature.title }}</h3>
                        <p class="text-slate-500 dark:text-slate-400 leading-relaxed">{{ feature.description }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Categories Preview -->
        <section class="py-32 overflow-hidden">
            <div class="max-w-7xl mx-auto px-6 lg:px-12 space-y-16">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-8">
                    <div class="space-y-4">
                        <h2 class="text-5xl font-black tracking-tight">Nos Catégories</h2>
                        <p class="text-slate-500 max-w-md">L'essentiel de la technologie regroupé par univers pour faciliter vos recherches.</p>
                    </div>
                    <Link href="/products" class="group flex items-center gap-2 font-bold text-blue-600">
                        Voir tout le catalogue 
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 group-hover:translate-x-2 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </Link>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div 
                        v-for="cat in ['Smartphones', 'Laptops', 'Audio', 'Accessoires']" 
                        :key="cat"
                        class="h-80 relative rounded-[2.5rem] bg-slate-100 dark:bg-slate-800 overflow-hidden group cursor-pointer"
                    >
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 to-transparent z-10"></div>
                        <div class="absolute bottom-8 left-8 z-20 space-y-2">
                            <h4 class="text-2xl font-black text-white">{{ cat }}</h4>
                            <p class="text-sm text-white/60 font-bold tracking-widest uppercase">Découvrir</p>
                        </div>
                        <!-- Decorative element for image placeholder -->
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-10 group-hover:scale-110 transition-transform duration-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-48 h-48" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Newsletter / CTA -->
        <section class="px-6 lg:px-12 pb-32">
            <div class="max-w-7xl mx-auto bg-blue-600 rounded-[3rem] p-12 md:p-24 text-center text-white relative overflow-hidden shadow-2xl shadow-blue-500/40">
                <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 blur-[80px] rounded-full translate-x-1/3 -translate-y-1/3"></div>
                <div class="relative z-10 space-y-12">
                    <h2 class="text-4xl md:text-6xl font-black tracking-tight leading-tight">
                        Prêt pour le prochain <br/> niveau de Technologie ?
                    </h2>
                    <p class="text-xl text-blue-100 max-w-xl mx-auto">
                        Inscrivez-vous dès maintenant pour bénéficier d'offres exclusives et être informé des derniers arrivages.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <Link 
                            href="/register" 
                            class="px-12 py-5 bg-white text-blue-600 rounded-2xl font-black text-lg hover:scale-105 transition-all shadow-xl"
                        >
                            Créer mon Compte Gratuit
                        </Link>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="py-12 border-t border-slate-100 dark:border-slate-800 px-6 lg:px-12">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-8 opacity-50 text-sm font-bold uppercase tracking-widest">
                <div class="flex items-center gap-2">
                    <span class="text-slate-900 dark:text-white uppercase">ShopTech &copy; 2024</span>
                </div>
                <div class="flex gap-8">
                    <a href="#" class="hover:text-blue-600 transition-colors">Twitter</a>
                    <a href="#" class="hover:text-blue-600 transition-colors">Instagram</a>
                    <a href="#" class="hover:text-blue-600 transition-colors">LinkedIn</a>
                </div>
                <p>Cameroun, Douala - Yaoundé</p>
            </div>
        </footer>

    </div>
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
