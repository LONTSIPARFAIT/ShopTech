<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref, onMounted, onUnmounted } from 'vue';
import products from '@/routes/products';

const page = usePage();
const auth = computed(() => page.props.auth);
const isScrolled = ref(false);

const handleScroll = () => {
    isScrolled.value = window.scrollY > 20;
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});
</script>

<template>
    <nav 
        class="fixed top-0 w-full z-50 transition-all duration-500 border-b"
        :class="[
            isScrolled 
                ? 'bg-white/80 dark:bg-slate-950/80 backdrop-blur-2xl py-3 border-slate-100 dark:border-slate-800' 
                : 'bg-transparent py-5 border-transparent'
        ]"
    >
        <div class="max-w-7xl mx-auto px-6 lg:px-12 flex items-center justify-between">
            <!-- Logo -->
            <Link href="/" class="flex items-center gap-3 group">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20 group-hover:rotate-6 transition-transform">
                    <span class="text-white font-black text-xl">S</span>
                </div>
                <span class="text-xl font-black tracking-tighter uppercase">Shop<span class="text-blue-600">Tech</span></span>
            </Link>
            
            <!-- Desktop Nav -->
            <div class="hidden md:flex items-center gap-10">
                <Link 
                    :href="route('products.index')" 
                    class="text-xs font-black uppercase tracking-widest hover:text-blue-600 transition-colors"
                >
                    Boutique
                </Link>
                <Link 
                    :href="route('products.index', { sort: 'latest' })" 
                    class="text-xs font-black uppercase tracking-widest hover:text-blue-600 transition-colors"
                >
                    Nouveautés
                </Link>
                <Link 
                    :href="route('products.index', { on_sale: 1 })" 
                    class="text-xs font-black uppercase tracking-widest hover:text-blue-600 transition-colors"
                >
                    Promotions
                </Link>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-6">
                <!-- Search -->
                <button class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>

                <!-- Cart -->
                <Link :href="route('cart.index')" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-all relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span v-if="$page.props.cartCount > 0" class="absolute top-0 right-0 w-4 h-4 bg-blue-600 text-white text-[10px] font-black rounded-full flex items-center justify-center">{{ $page.props.cartCount }}</span>
                </Link>

                <div class="h-6 w-px bg-slate-200 dark:bg-slate-800 hidden sm:block"></div>

                <!-- Auth -->
                <div v-if="auth.user" class="flex items-center gap-4">
                    <Link 
                        href="/dashboard" 
                        class="px-5 py-2.5 bg-slate-900 dark:bg-white text-white dark:text-slate-950 rounded-xl text-xs font-black uppercase tracking-widest hover:opacity-90 transition-all shadow-lg shadow-slate-500/10"
                    >
                        Mon Compte
                    </Link>
                </div>
                <div v-else class="hidden sm:flex items-center gap-4">
                    <Link href="/login" class="text-xs font-black uppercase tracking-widest hover:text-blue-600 transition-colors">Connexion</Link>
                    <Link 
                        href="/register" 
                        class="px-6 py-2.5 bg-blue-600 text-white rounded-xl text-xs font-black uppercase tracking-widest shadow-lg shadow-blue-500/20 hover:bg-blue-700 transition-all"
                    >
                        S'inscrire
                    </Link>
                </div>
            </div>
        </div>
    </nav>
</template>
