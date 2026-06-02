<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import products from '@/routes/products';
import services from '@/routes/services';
import { home, contact, about } from '@/routes';
import { MapPin, Phone, Mail, Instagram, Facebook, Twitter, Clock, ArrowUp } from 'lucide-vue-next';
import { ref, onMounted, onUnmounted } from 'vue';

const showScrollTop = ref(false);

const handleScroll = () => {
    showScrollTop.value = window.scrollY > 300;
};

const scrollToTop = () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
};

onMounted(() => window.addEventListener('scroll', handleScroll));
onUnmounted(() => window.removeEventListener('scroll', handleScroll));
</script>

<template>
    <footer class="bg-card border-t border-border py-12 md:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Grille principale -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12 mb-10">
                <!-- Colonne 1 : Marque & Contact -->
                <div class="space-y-4">
                    <!-- Logo -->
                    <div class="flex items-center gap-2">
                        <div class="w-9 h-9 bg-primary rounded-xl flex items-center justify-center shadow-md shadow-primary/20">
                            <span class="text-white font-bold text-base">S</span>
                        </div>
                        <span class="text-lg font-black uppercase text-foreground">Shop<span class="text-primary">Tech</span></span>
                    </div>

                    <!-- Description -->
                    <p class="text-sm text-muted-foreground leading-relaxed max-w-sm">
                        Votre destination ultime pour l'innovation technologique au Cameroun.
                    </p>

                    <!-- Contact -->
                    <div class="space-y-2.5">
                        <div class="flex items-center gap-3 text-sm text-muted-foreground">
                            <MapPin class="w-4 h-4 text-primary" />
                            <span>Yaoundé, Cameroun</span>
                        </div>
                        <a href="tel:+237600000000" class="flex items-center gap-3 text-sm text-muted-foreground hover:text-primary transition-colors duration-300">
                            <Phone class="w-4 h-4 text-primary" />
                            <span>+237 6 00 00 00 00</span>
                        </a>
                        <a href="mailto:contact@shoptech.cm" class="flex items-center gap-3 text-sm text-muted-foreground hover:text-primary transition-colors duration-300">
                            <Mail class="w-4 h-4 text-primary" />
                            <span>contact@shoptech.cm</span>
                        </a>
                        <div class="flex items-center gap-3 text-sm text-muted-foreground">
                            <Clock class="w-4 h-4 text-primary" />
                            <span>Lun–Sam : 8h – 18h</span>
                        </div>
                    </div>

                    <!-- Réseaux sociaux -->
                    <div class="flex gap-3 pt-2">
                        <a href="https://facebook.com" target="_blank" class="w-9 h-9 bg-secondary rounded-xl flex items-center justify-center text-muted-foreground transition-all duration-300 hover:bg-[#1877f2] hover:text-white hover:-translate-y-0.5">
                            <Facebook class="w-4.5 h-4.5" />
                        </a>
                        <a href="https://instagram.com" target="_blank" class="w-9 h-9 bg-secondary rounded-xl flex items-center justify-center text-muted-foreground transition-all duration-300 hover:bg-[#e4405f] hover:text-white hover:-translate-y-0.5">
                            <Instagram class="w-4.5 h-4.5" />
                        </a>
                        <a href="https://twitter.com" target="_blank" class="w-9 h-9 bg-secondary rounded-xl flex items-center justify-center text-muted-foreground transition-all duration-300 hover:bg-[#1da1f2] hover:text-white hover:-translate-y-0.5">
                            <Twitter class="w-4.5 h-4.5" />
                        </a>
                        <a href="https://wa.me/237600000000" target="_blank" class="w-9 h-9 bg-secondary rounded-xl flex items-center justify-center text-muted-foreground transition-all duration-300 hover:bg-[#25d366] hover:text-white hover:-translate-y-0.5">
                            <svg class="w-4.5 h-4.5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Colonne 2 : Boutique -->
                <div>
                    <h4 class="text-sm font-bold uppercase tracking-wider text-foreground mb-5">La Boutique</h4>
                    <ul class="space-y-3">
                        <li><Link :href="products.index().url" class="text-sm text-muted-foreground hover:text-primary transition-colors duration-300">Tous les produits</Link></li>
                        <li><Link :href="products.index({ query: { category: 'smartphones' } }).url" class="text-sm text-muted-foreground hover:text-primary transition-colors duration-300">Smartphones</Link></li>
                        <li><Link :href="products.index({ query: { category: 'ordinateurs' } }).url" class="text-sm text-muted-foreground hover:text-primary transition-colors duration-300">Ordinateurs</Link></li>
                        <li><Link :href="products.index({ query: { category: 'accessoires' } }).url" class="text-sm text-muted-foreground hover:text-primary transition-colors duration-300">Accessoires</Link></li>
                        <li><Link :href="products.index({ query: { sort: 'discount' } }).url" class="text-sm text-muted-foreground hover:text-primary transition-colors duration-300">Promotions</Link></li>
                    </ul>
                </div>

                <!-- Colonne 3 : Support -->
                <div>
                    <h4 class="text-sm font-bold uppercase tracking-wider text-foreground mb-5">Support</h4>
                    <ul class="space-y-3">
                        <li><Link :href="contact()" class="text-sm text-muted-foreground hover:text-primary transition-colors duration-300">Nous contacter</Link></li>
                        <li><Link :href="services.index().url" class="text-sm text-muted-foreground hover:text-primary transition-colors duration-300">Nos services</Link></li>
                        <li><Link :href="about()" class="text-sm text-muted-foreground hover:text-primary transition-colors duration-300">À propos</Link></li>
                        <li><a href="#" class="text-sm text-muted-foreground hover:text-primary transition-colors duration-300">Livraison & Retours</a></li>
                        <li><a href="#" class="text-sm text-muted-foreground hover:text-primary transition-colors duration-300">FAQ</a></li>
                    </ul>
                </div>

                <!-- Colonne 4 : Newsletter -->
                <div>
                    <h4 class="text-sm font-bold uppercase tracking-wider text-foreground mb-5">Newsletter</h4>
                    <p class="text-sm text-muted-foreground mb-4 leading-relaxed">
                        Recevez nos offres exclusives et nouveautés.
                    </p>
                    <div class="relative">
                        <input
                            type="email"
                            placeholder="votre@email.com"
                            class="w-full px-4 py-2.5 pr-12 bg-secondary border border-border rounded-xl text-sm text-foreground placeholder:text-muted-foreground focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all duration-300"
                        />
                        <button class="absolute right-1.5 top-1/2 -translate-y-1/2 p-1.5 bg-primary rounded-lg text-white hover:bg-primary-dark transition-all duration-300 hover:scale-105">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                    <!-- WhatsApp Button -->
                    <a href="https://wa.me/237600000000" target="_blank" class="flex items-center justify-center gap-2.5 mt-5 py-2.5 bg-[#25d366] rounded-xl text-white text-sm font-bold transition-all duration-300 hover:bg-[#20bd59] hover:-translate-y-0.5 shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        WhatsApp
                    </a>
                </div>
            </div>

            <!-- Barre du bas -->
            <div class="pt-6 border-t border-border flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-muted-foreground">
                <p>&copy; {{ new Date().getFullYear() }} ShopTech. Tous droits réservés.</p>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-primary transition-colors duration-300">Mentions Légales</a>
                    <a href="#" class="hover:text-primary transition-colors duration-300">Confidentialité</a>
                    <a href="#" class="hover:text-primary transition-colors duration-300">CGV</a>
                </div>
                <p class="flex items-center gap-1">
                    Made with <span class="text-red-500">❤️</span> in Cameroun
                </p>
            </div>
        </div>

        <!-- Scroll to Top -->
        <transition
            enter-active-class="transition-all duration-300 ease-out"
            enter-from-class="opacity-0 scale-75 translate-y-4"
            enter-to-class="opacity-100 scale-100 translate-y-0"
            leave-active-class="transition-all duration-200 ease-in"
            leave-from-class="opacity-100 scale-100 translate-y-0"
            leave-to-class="opacity-0 scale-75 translate-y-4"
        >
            <button
                v-if="showScrollTop"
                @click="scrollToTop"
                class="fixed bottom-6 right-6 z-50 w-11 h-11 bg-primary text-white rounded-xl flex items-center justify-center shadow-lg shadow-primary/30 hover:bg-primary-dark hover:-translate-y-1 transition-all duration-300"
            >
                <ArrowUp class="w-5 h-5" />
            </button>
        </transition>
    </footer>
</template>
