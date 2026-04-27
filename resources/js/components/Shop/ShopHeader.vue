<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref, onMounted, onUnmounted } from 'vue';
import products from '@/routes/products';
import { index as cartIndex } from '@/routes/cart';
import { login, register, dashboard } from '@/routes';
import { useAppearance } from '@/composables/useAppearance';
import { Sun, Moon, ShoppingBag, Menu, X, Search, User, Home, Sparkles } from 'lucide-vue-next';
import CartModal from './CartModal.vue';
import { DialogTrigger } from '@/components/ui/dialog';

const page = usePage();
const auth = computed(() => page.props.auth);
const cartCount = computed(() => (page.props as any).cartCount || 0);
const isScrolled = ref(false);
const isMobileOpen = ref(false);

const { appearance, updateAppearance } = useAppearance();

const toggleTheme = () => {
    // Force simple toggle between light and dark
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
        class="fixed top-0 w-full z-50 transition-all duration-500"
        :class="[
            isScrolled 
                ? 'bg-white/80 dark:bg-slate-950/80 backdrop-blur-2xl py-4 border-b border-slate-100 dark:border-slate-800 shadow-2xl shadow-black/[0.03]' 
                : 'bg-transparent py-8 border-b border-transparent'
        ]"
    >
        <div class="max-w-7xl mx-auto px-6 lg:px-12 flex items-center justify-between">
            <!-- Logo -->
            <Link href="/" class="flex items-center gap-4 group">
                <div class="w-12 h-12 bg-blue-600 rounded-[1.25rem] flex items-center justify-center shadow-2xl shadow-blue-500/40 group-hover:rotate-12 transition-all duration-500">
                    <Sparkles class="text-white w-6 h-6" />
                </div>
                <span class="text-2xl font-black tracking-tighter uppercase italic">Shop<span class="text-blue-600">Tech</span></span>
            </Link>
            
            <!-- Desktop Nav -->
            <div class="hidden lg:flex items-center gap-12">
                <Link 
                    href="/" 
                    class="text-[10px] font-black uppercase tracking-[0.2em] hover:text-blue-600 transition-all flex items-center gap-2 group"
                    :class="$page.url === '/' ? 'text-blue-600' : 'text-slate-500'"
                >
                    <Home class="w-3.5 h-3.5 group-hover:scale-110 transition-transform" />
                    Accueil
                </Link>
                <Link 
                    :href="products.index().url" 
                    class="text-[10px] font-black uppercase tracking-[0.2em] hover:text-blue-600 transition-all"
                    :class="$page.url.startsWith('/products') ? 'text-blue-600' : 'text-slate-500'"
                >
                    Boutique
                </Link>
                <Link 
                    :href="products.index({ query: { sort: 'latest' } }).url" 
                    class="text-[10px] font-black uppercase tracking-[0.2em] hover:text-blue-600 transition-all text-slate-500"
                >
                    Nouveautés
                </Link>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4">
                <!-- Theme Toggle -->
                <button 
                    @click="toggleTheme"
                    class="p-3 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-2xl transition-all relative group overflow-hidden"
                >
                    <div class="relative z-10 transition-transform duration-500 group-hover:rotate-12">
                        <Sun v-if="appearance === 'dark'" class="w-5 h-5 text-amber-400" />
                        <Moon v-else class="w-5 h-5 text-blue-600" />
                    </div>
                    <div class="absolute inset-0 bg-blue-500/0 group-hover:bg-blue-500/5 transition-colors"></div>
                </button>

                <!-- Search -->
                <button class="p-3 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-2xl transition-all hidden sm:flex text-slate-500 hover:text-blue-600">
                    <Search class="w-5 h-5" />
                </button>

                <!-- Cart Modal -->
                <CartModal>
                    <template #trigger>
                        <DialogTrigger as-child>
                            <button class="p-3 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-2xl transition-all relative group">
                                <ShoppingBag class="w-5 h-5 text-slate-500 group-hover:text-blue-600 transition-colors" />
                                <span 
                                    v-if="cartCount > 0" 
                                    class="absolute top-1.5 right-1.5 w-5 h-5 bg-blue-600 text-white text-[9px] font-black rounded-full flex items-center justify-center ring-4 ring-white dark:ring-slate-950 group-hover:scale-110 transition-transform"
                                >{{ cartCount }}</span>
                            </button>
                        </DialogTrigger>
                    </template>
                </CartModal>

                <div class="h-8 w-px bg-slate-200 dark:bg-slate-800 hidden sm:block mx-2"></div>

                <!-- Auth -->
                <div v-if="auth.user" class="hidden sm:flex items-center gap-4">
                    <Link 
                        :href="dashboard().url" 
                        class="px-6 py-3 bg-slate-900 dark:bg-white text-white dark:text-slate-950 rounded-[1.25rem] text-[10px] font-black uppercase tracking-[0.2em] hover:scale-105 transition-all shadow-2xl shadow-black/10 flex items-center gap-2 group"
                    >
                        <User class="w-3.5 h-3.5 group-hover:rotate-12 transition-transform" />
                        Espace
                    </Link>
                </div>
                <div v-else class="hidden sm:flex items-center gap-6">
                    <Link :href="login().url" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 hover:text-blue-600 transition-colors">Connexion</Link>
                    <Link 
                        :href="register().url" 
                        class="px-8 py-3 bg-blue-600 text-white rounded-[1.25rem] text-[10px] font-black uppercase tracking-[0.2em] shadow-xl shadow-blue-500/30 hover:bg-blue-700 transition-all"
                    >
                        S'inscrire
                    </Link>
                </div>

                <!-- Mobile Menu Toggle -->
                <button 
                    @click="isMobileOpen = !isMobileOpen"
                    class="lg:hidden p-3 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-2xl transition-all"
                >
                    <X v-if="isMobileOpen" class="w-6 h-6" />
                    <Menu v-else class="w-6 h-6" />
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <transition
            enter-active-class="transition-all duration-500 ease-out"
            enter-from-class="opacity-0 -translate-y-10"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition-all duration-300 ease-in"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 -translate-y-10"
        >
            <div 
                v-if="isMobileOpen" 
                class="lg:hidden bg-white/95 dark:bg-slate-950/95 backdrop-blur-xl border-t border-slate-100 dark:border-slate-800 px-8 pb-12 pt-6 space-y-6"
            >
                <Link 
                    href="/" 
                    class="flex items-center justify-between py-4 text-sm font-black uppercase tracking-[0.2em] border-b border-slate-50 dark:border-slate-900"
                    @click="isMobileOpen = false"
                >
                    <span>Accueil</span>
                    <Home class="w-4 h-4 opacity-40" />
                </Link>
                <Link 
                    :href="products.index().url" 
                    class="flex items-center justify-between py-4 text-sm font-black uppercase tracking-[0.2em] border-b border-slate-50 dark:border-slate-900"
                    @click="isMobileOpen = false"
                >
                    <span>Boutique</span>
                    <ShoppingBag class="w-4 h-4 opacity-40" />
                </Link>
                <Link 
                    :href="products.index({ query: { sort: 'latest' } }).url" 
                    class="flex items-center justify-between py-4 text-sm font-black uppercase tracking-[0.2em] border-b border-slate-50 dark:border-slate-900"
                    @click="isMobileOpen = false"
                >
                    <span>Nouveautés</span>
                    <Zap class="w-4 h-4 opacity-40" />
                </Link>

                <div class="pt-6 space-y-4">
                    <div v-if="auth.user">
                        <Link 
                            :href="dashboard().url" 
                            class="block w-full text-center py-5 bg-slate-900 dark:bg-white text-white dark:text-slate-950 rounded-[1.5rem] font-black text-xs uppercase tracking-widest shadow-2xl"
                            @click="isMobileOpen = false"
                        >
                            Mon Espace
                        </Link>
                    </div>
                    <div v-else class="space-y-4">
                        <Link 
                            :href="login().url" 
                            class="block w-full text-center py-5 bg-slate-100 dark:bg-slate-800 rounded-[1.5rem] font-black text-xs uppercase tracking-widest"
                            @click="isMobileOpen = false"
                        >
                            Connexion
                        </Link>
                        <Link 
                            :href="register().url" 
                            class="block w-full text-center py-5 bg-blue-600 text-white rounded-[1.5rem] font-black text-xs uppercase tracking-widest shadow-xl shadow-blue-500/30"
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

