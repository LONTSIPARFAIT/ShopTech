<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref, onMounted, onUnmounted } from 'vue';
import products from '@/routes/products';
import { home, login, register, dashboard, services, about, contact } from '@/routes';
import { useAppearance } from '@/composables/useAppearance';
import { Sun, Moon, ShoppingBag, Menu, X, User } from 'lucide-vue-next';
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

const handleScroll = () => {
    isScrolled.value = window.scrollY > 20;
};

onMounted(() => window.addEventListener('scroll', handleScroll));
onUnmounted(() => window.removeEventListener('scroll', handleScroll));
</script>

<template>
    <nav class="shop-header" :class="isScrolled ? 'shop-header-scrolled' : 'shop-header-transparent'">
        <div class="shop-header-container">
            <!-- Logo -->
            <Link :href="home()" class="shop-logo">
                <div class="shop-logo-icon">
                    <span class="text-white font-bold text-sm">S</span>
                </div>
                <span class="shop-logo-text">Shop<span class="shop-logo-highlight">Tech</span></span>
            </Link>

            <!-- Desktop Navigation -->
            <div class="shop-nav-desktop">
                <Link :href="home()" class="shop-nav-link" :class="$page.url === '/' && 'shop-nav-link-active'">Accueil</Link>
                <Link :href="products.index().url" class="shop-nav-link" :class="$page.url.startsWith('/products') && 'shop-nav-link-active'">Boutique</Link>
                <Link :href="services()" class="shop-nav-link" :class="$page.url === '/services' && 'shop-nav-link-active'">Services</Link>
                <Link :href="about()" class="shop-nav-link" :class="$page.url === '/about' && 'shop-nav-link-active'">À propos</Link>
                <Link :href="contact()" class="shop-nav-link" :class="$page.url === '/contact' && 'shop-nav-link-active'">Contact</Link>
            </div>

            <!-- Actions -->
            <div class="shop-header-actions">
                <button @click="toggleTheme" class="shop-icon-btn">
                    <Sun v-if="appearance === 'dark'" class="w-4 h-4 text-amber-400" />
                    <Moon v-else class="w-4 h-4" />
                </button>

                <CartModal>
                    <template #trigger>
                        <DialogTrigger as-child>
                            <button class="shop-icon-btn shop-cart-btn">
                                <ShoppingBag class="w-4 h-4" />
                                <span v-if="cartCount > 0" class="shop-cart-badge">{{ cartCount }}</span>
                            </button>
                        </DialogTrigger>
                    </template>
                </CartModal>

                <div class="shop-auth-divider"></div>

                <div v-if="auth.user" class="shop-auth-desktop flex items-center gap-4">
                    <Link :href="dashboard().url" class="flex items-center gap-3 group">
                        <div class="flex flex-col items-end hidden lg:flex">
                            <span class="text-xs font-bold text-foreground group-hover:text-primary transition-colors">{{ auth.user.name }}</span>
                            <span class="text-[9px] text-muted-foreground font-black ">Dashboard</span>
                        </div>
                        <div class="w-10 h-10 rounded-full border-2 border-primary/20 p-0.5 group-hover:border-primary/50 transition-all">
                            <img 
                                :src="auth.user.avatar_url" 
                                :alt="auth.user.name"
                                class="w-full h-full object-cover rounded-full"
                            />
                        </div>
                    </Link>
                </div>
                <div v-else class="shop-auth-desktop">
                    <Link :href="login().url" class="shop-login-btn">Connexion</Link>
                    <Link :href="register().url" class="shop-register-btn">S'inscrire</Link>
                </div>

                <button @click="isMobileOpen = !isMobileOpen" class="shop-mobile-menu-btn">
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
            <div v-if="isMobileOpen" class="shop-mobile-menu">
                <Link :href="home()" class="shop-mobile-link" @click="isMobileOpen = false">
                    <span>Accueil</span>
                </Link>
                <Link :href="products.index().url" class="shop-mobile-link" @click="isMobileOpen = false">
                    <span>Boutique</span>
                    <ShoppingBag class="w-3.5 h-3.5 opacity-30" />
                </Link>
                <Link :href="services()" class="shop-mobile-link" @click="isMobileOpen = false">
                    <span>Services</span>
                </Link>
                <Link :href="about()" class="shop-mobile-link" @click="isMobileOpen = false">
                    <span>À propos</span>
                </Link>
                <Link :href="contact()" class="shop-mobile-link" @click="isMobileOpen = false">
                    <span>Contact</span>
                </Link>
                
                <div class="shop-mobile-auth">
                    <div v-if="auth.user">
                        <Link :href="dashboard().url" class="flex items-center gap-3 p-3 bg-secondary rounded-xl" @click="isMobileOpen = false">
                            <div class="w-10 h-10 rounded-full overflow-hidden border border-border">
                                <img :src="auth.user.avatar_url" :alt="auth.user.name" class="w-full h-full object-cover" />
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm font-bold">{{ auth.user.name }}</span>
                                <span class="text-[10px] text-muted-foreground">Accéder au dashboard</span>
                            </div>
                        </Link>
                    </div>
                    <div v-else>
                        <Link :href="login().url" class="shop-mobile-login" @click="isMobileOpen = false">Connexion</Link>
                        <Link :href="register().url" class="shop-mobile-register" @click="isMobileOpen = false">S'inscrire</Link>
                    </div>
                </div>
            </div>
        </transition>
    </nav>
</template>