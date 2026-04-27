<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref, onMounted, onUnmounted } from 'vue';
import products from '@/routes/products';
import { index as cartIndex } from '@/routes/cart';
import { login, register, dashboard } from '@/routes';
import { useAppearance } from '@/composables/useAppearance';
import { Sun, Moon, ShoppingBag, Menu, X, Search, User, Home } from 'lucide-vue-next';
import CartSheet from './CartSheet.vue';
import { SheetTrigger } from '@/components/ui/sheet';

const page = usePage();
const auth = computed(() => page.props.auth);
const cartCount = computed(() => (page.props as any).cartCount || 0);
const isScrolled = ref(false);
const isMobileOpen = ref(false);

const { appearance, updateAppearance } = useAppearance();

const toggleTheme = () => {
    const nextTheme = appearance.value === 'dark' ? 'light' : 'dark';
    updateAppearance(nextTheme);
};

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
                ? 'bg-white/80 dark:bg-slate-950/80 backdrop-blur-2xl py-3 border-slate-100 dark:border-slate-800 shadow-lg shadow-black/[0.03]' 
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
            <div class="hidden lg:flex items-center gap-10">
                <Link 
                    href="/" 
                    class="text-xs font-black uppercase tracking-widest hover:text-blue-600 transition-colors flex items-center gap-2"
                >
                    <Home class="w-3.5 h-3.5" />
                    Accueil
                </Link>
                <Link 
                    :href="products.index().url" 
                    class="text-xs font-black uppercase tracking-widest hover:text-blue-600 transition-colors"
                >
                    Boutique
                </Link>
                <Link 
                    :href="products.index({ query: { sort: 'latest' } }).url" 
                    class="text-xs font-black uppercase tracking-widest hover:text-blue-600 transition-colors"
                >
                    Nouveautés
                </Link>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-3">
                <!-- Theme Toggle (Simplified to 2 options) -->
                <button 
                    @click="toggleTheme"
                    class="p-2.5 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-all"
                >
                    <Sun v-if="appearance === 'dark'" class="w-4.5 h-4.5" />
                    <Moon v-else class="w-4.5 h-4.5" />
                </button>

                <!-- Search -->
                <button class="p-2.5 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-all hidden sm:flex">
                    <Search class="w-4.5 h-4.5" />
                </button>

                <!-- Cart Sheet -->
                <CartSheet>
                    <template #trigger>
                        <SheetTrigger as-child>
                            <button class="p-2.5 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-all relative">
                                <ShoppingBag class="w-4.5 h-4.5" />
                                <span 
                                    v-if="cartCount > 0" 
                                    class="absolute -top-0.5 -right-0.5 w-5 h-5 bg-blue-600 text-white text-[10px] font-black rounded-full flex items-center justify-center ring-2 ring-white dark:ring-slate-950"
                                >{{ cartCount }}</span>
                            </button>
                        </SheetTrigger>
                    </template>
                </CartSheet>

                <div class="h-6 w-px bg-slate-200 dark:bg-slate-800 hidden sm:block"></div>

                <!-- Auth -->
                <div v-if="auth.user" class="hidden sm:flex items-center gap-3">
                    <Link 
                        :href="dashboard().url" 
                        class="px-5 py-2.5 bg-slate-900 dark:bg-white text-white dark:text-slate-950 rounded-xl text-xs font-black uppercase tracking-widest hover:opacity-90 transition-all shadow-lg shadow-slate-500/10 flex items-center gap-2"
                    >
                        <User class="w-3.5 h-3.5" />
                        Mon Espace
                    </Link>
                </div>
                <div v-else class="hidden sm:flex items-center gap-3">
                    <Link :href="login().url" class="text-xs font-black uppercase tracking-widest hover:text-blue-600 transition-colors">Connexion</Link>
                    <Link 
                        :href="register().url" 
                        class="px-6 py-2.5 bg-blue-600 text-white rounded-xl text-xs font-black uppercase tracking-widest shadow-lg shadow-blue-500/20 hover:bg-blue-700 transition-all"
                    >
                        S'inscrire
                    </Link>
                </div>

                <!-- Mobile Menu Toggle -->
                <button 
                    @click="isMobileOpen = !isMobileOpen"
                    class="lg:hidden p-2.5 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-all"
                >
                    <X v-if="isMobileOpen" class="w-5 h-5" />
                    <Menu v-else class="w-5 h-5" />
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <transition
            enter-active-class="transition-all duration-300 ease-out"
            enter-from-class="opacity-0 -translate-y-4"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition-all duration-200 ease-in"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 -translate-y-4"
        >
            <div 
                v-if="isMobileOpen" 
                class="lg:hidden bg-white dark:bg-slate-950 border-t border-slate-100 dark:border-slate-800 px-6 pb-8 pt-4 space-y-4"
            >
                <Link 
                    href="/" 
                    class="block py-3 text-sm font-bold hover:text-blue-600 transition-colors border-b border-slate-50 dark:border-slate-900"
                    @click="isMobileOpen = false"
                >
                    Accueil
                </Link>
                <Link 
                    :href="products.index().url" 
                    class="block py-3 text-sm font-bold hover:text-blue-600 transition-colors border-b border-slate-50 dark:border-slate-900"
                    @click="isMobileOpen = false"
                >
                    Boutique
                </Link>
                <Link 
                    :href="products.index({ query: { sort: 'latest' } }).url" 
                    class="block py-3 text-sm font-bold hover:text-blue-600 transition-colors border-b border-slate-50 dark:border-slate-900"
                    @click="isMobileOpen = false"
                >
                    Nouveautés
                </Link>

                <div class="pt-4 space-y-3">
                    <div v-if="auth.user">
                        <Link 
                            :href="dashboard().url" 
                            class="block w-full text-center py-3 bg-slate-900 dark:bg-white text-white dark:text-slate-950 rounded-xl font-bold text-sm"
                            @click="isMobileOpen = false"
                        >
                            Mon Espace
                        </Link>
                    </div>
                    <div v-else class="space-y-3">
                        <Link 
                            :href="login().url" 
                            class="block w-full text-center py-3 bg-slate-100 dark:bg-slate-800 rounded-xl font-bold text-sm"
                            @click="isMobileOpen = false"
                        >
                            Connexion
                        </Link>
                        <Link 
                            :href="register().url" 
                            class="block w-full text-center py-3 bg-blue-600 text-white rounded-xl font-bold text-sm"
                            @click="isMobileOpen = false"
                        >
                            S'inscrire
                        </Link>
                    </div>
                </div>
            </div>
        </transition>
    </nav>
</template>
