<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref, onMounted, onUnmounted } from 'vue';
import products from '@/routes/products';
import { home, login, register, dashboard, services, about, contact } from '@/routes';
import { useAppearance } from '@/composables/useAppearance';
import { Sun, Moon, ShoppingBag, Menu, X, User, Sparkles, Info, Phone, Wrench } from 'lucide-vue-next';
import CartModal from './CartModal.vue';
import { DialogTrigger } from '@/components/ui/dialog';

const page = usePage();
const auth = computed(() => page.props.auth);
const cartCount = computed(() => (page.props as any).cartCount || 0);
const isScrolled = ref(false);
const isMobileOpen = ref(false);

const { appearance, updateAppearance } = useAppearance();
const toggleTheme = () => {
    updateAppearance(appearance.value === 'dark' ? 'light' : 'dark');
};
const handleScroll = () => { isScrolled.value = window.scrollY > 20; };
onMounted(() => window.addEventListener('scroll', handleScroll));
onUnmounted(() => window.removeEventListener('scroll', handleScroll));
</script>

<template>
    <nav
        class="fixed top-0 w-full z-50 transition-all duration-500"
        :class="isScrolled
            ? 'bg-white/80 dark:bg-slate-950/80 backdrop-blur-2xl py-3 border-b border-slate-100 dark:border-slate-800 shadow-lg shadow-black/[0.03]'
            : 'bg-transparent py-5 border-b border-transparent'"
    >
        <div class="max-w-7xl mx-auto px-6 lg:px-12 flex items-center justify-between">
            <!-- Logo -->
            <Link :href="home()" class="flex items-center gap-3 group">
                <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/40 group-hover:rotate-12 transition-all duration-500">
                    <Sparkles class="text-white w-4 h-4" />
                </div>
                <span class="text-lg font-black tracking-tighter uppercase italic">Shop<span class="text-blue-600">Tech</span></span>
            </Link>

            <!-- Desktop Nav -->
            <div class="hidden lg:flex items-center gap-7">
                <Link :href="home()" class="shop-nav-link" :class="$page.url === '/' ? 'text-blue-600' : 'text-slate-500'">Accueil</Link>
                <Link :href="products.index()" class="shop-nav-link" :class="$page.url.startsWith('/products') ? 'text-blue-600' : 'text-slate-500'">Boutique</Link>
                <Link :href="services()" class="shop-nav-link" :class="$page.url === '/services' ? 'text-blue-600' : 'text-slate-500'">Services</Link>
                <Link :href="about()" class="shop-nav-link" :class="$page.url === '/about' ? 'text-blue-600' : 'text-slate-500'">À propos</Link>
                <Link :href="contact()" class="shop-nav-link" :class="$page.url === '/contact' ? 'text-blue-600' : 'text-slate-500'">Contact</Link>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-2">
                <button @click="toggleTheme" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-all group">
                    <Sun v-if="appearance === 'dark'" class="w-4 h-4 text-amber-400 group-hover:rotate-12 transition-transform duration-500" />
                    <Moon v-else class="w-4 h-4 text-blue-600 group-hover:rotate-12 transition-transform duration-500" />
                </button>

                <CartModal>
                    <template #trigger>
                        <DialogTrigger as-child>
                            <button class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-all relative group">
                                <ShoppingBag class="w-4 h-4 text-slate-500 group-hover:text-blue-600 transition-colors" />
                                <span v-if="cartCount > 0" class="absolute top-1 right-1 w-4 h-4 bg-blue-600 text-white text-[8px] font-black rounded-full flex items-center justify-center ring-2 ring-white dark:ring-slate-950">{{ cartCount }}</span>
                            </button>
                        </DialogTrigger>
                    </template>
                </CartModal>

                <div class="h-6 w-px bg-slate-200 dark:bg-slate-800 hidden sm:block mx-1"></div>

                <div v-if="auth.user" class="hidden sm:flex">
                    <Link :href="dashboard().url" class="shop-btn-secondary flex items-center gap-2 py-2 px-4 text-[9px]">
                        <User class="w-3 h-3" /> Espace
                    </Link>
                </div>
                <div v-else class="hidden sm:flex items-center gap-3">
                    <Link :href="login().url" class="shop-nav-link text-slate-500">Connexion</Link>
                    <Link :href="register().url" class="shop-btn-primary py-2 px-5 text-[9px]">S'inscrire</Link>
                </div>

                <button @click="isMobileOpen = !isMobileOpen" class="lg:hidden p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-all">
                    <X v-if="isMobileOpen" class="w-5 h-5" />
                    <Menu v-else class="w-5 h-5" />
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <transition
            enter-active-class="transition-all duration-400 ease-out"
            enter-from-class="opacity-0 -translate-y-6"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition-all duration-250 ease-in"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 -translate-y-6"
        >
            <div v-if="isMobileOpen" class="lg:hidden bg-white/95 dark:bg-slate-950/95 backdrop-blur-xl border-t border-slate-100 dark:border-slate-800 px-6 pb-8 pt-3 space-y-0.5">
                <Link href="/" class="flex items-center justify-between py-3 text-xs font-black uppercase tracking-[0.2em] border-b border-slate-50 dark:border-slate-900" @click="isMobileOpen = false">
                    <span>Accueil</span>
                </Link>
                <Link :href="products.index().url" class="flex items-center justify-between py-3 text-xs font-black uppercase tracking-[0.2em] border-b border-slate-50 dark:border-slate-900" @click="isMobileOpen = false">
                    <span>Boutique</span><ShoppingBag class="w-3.5 h-3.5 opacity-30" />
                </Link>
                <Link href="/services" class="flex items-center justify-between py-3 text-xs font-black uppercase tracking-[0.2em] border-b border-slate-50 dark:border-slate-900" @click="isMobileOpen = false">
                    <span>Services</span><Wrench class="w-3.5 h-3.5 opacity-30" />
                </Link>
                <Link href="/about" class="flex items-center justify-between py-3 text-xs font-black uppercase tracking-[0.2em] border-b border-slate-50 dark:border-slate-900" @click="isMobileOpen = false">
                    <span>À propos</span><Info class="w-3.5 h-3.5 opacity-30" />
                </Link>
                <Link href="/contact" class="flex items-center justify-between py-3 text-xs font-black uppercase tracking-[0.2em] border-b border-slate-50 dark:border-slate-900" @click="isMobileOpen = false">
                    <span>Contact</span><Phone class="w-3.5 h-3.5 opacity-30" />
                </Link>
                <div class="pt-4 space-y-2">
                    <div v-if="auth.user">
                        <Link :href="dashboard().url" class="block w-full text-center py-3.5 bg-slate-900 dark:bg-white text-white dark:text-slate-950 rounded-2xl font-black text-xs uppercase tracking-widest" @click="isMobileOpen = false">Mon Espace</Link>
                    </div>
                    <div v-else class="space-y-2">
                        <Link :href="login().url" class="block w-full text-center py-3.5 bg-slate-100 dark:bg-slate-800 rounded-2xl font-black text-xs uppercase tracking-widest" @click="isMobileOpen = false">Connexion</Link>
                        <Link :href="register().url" class="block w-full text-center py-3.5 bg-blue-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg shadow-blue-500/30" @click="isMobileOpen = false">S'inscrire</Link>
                    </div>
                </div>
            </div>
        </transition>
    </nav>
</template>
