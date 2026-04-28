<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import products from '@/routes/products';
import { home, contact, about, services } from '@/routes';
import { MapPin, Phone, Mail, Instagram, Facebook, Twitter, Clock, ArrowUp } from 'lucide-vue-next';
import { ref, onMounted, onUnmounted } from 'vue';

const showScrollTop = ref(false);

const handleScroll = () => { showScrollTop.value = window.scrollY > 300; };
const scrollToTop = () => window.scrollTo({ top: 0, behavior: 'smooth' });

onMounted(() => window.addEventListener('scroll', handleScroll));
onUnmounted(() => window.removeEventListener('scroll', handleScroll));
</script>

<template>
    <footer class="bg-white dark:bg-slate-950 border-t border-slate-100 dark:border-slate-800 pt-16 pb-8 overflow-hidden relative">
        <div class="absolute bottom-0 right-0 w-80 h-80 bg-blue-500/5 blur-[80px] rounded-full translate-x-1/3 translate-y-1/3"></div>
        <div class="absolute top-0 left-0 w-64 h-64 bg-indigo-500/5 blur-[80px] rounded-full -translate-x-1/3 -translate-y-1/3"></div>

        <div class="max-w-7xl mx-auto px-6 lg:px-12 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 mb-14">
                <!-- Brand col -->
                <div class="lg:col-span-2 space-y-5">
                    <Link :href="home()" class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center shadow-md shadow-blue-500/20">
                            <span class="text-white font-black text-base">S</span>
                        </div>
                        <span class="text-lg font-black tracking-tighter uppercase">Shop<span class="text-blue-600">Tech</span></span>
                    </Link>
                    <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed max-w-xs">
                        Votre destination ultime pour l'innovation technologique au Cameroun. Qualité, rapidité, confiance.
                    </p>
                    <!-- Contact Info -->
                    <div class="space-y-2.5 text-sm">
                        <div class="flex items-center gap-3 text-slate-500 dark:text-slate-400">
                            <MapPin class="w-4 h-4 text-blue-600 shrink-0" />
                            <span>Yaoundé, Cameroun – Rue de la Cathédrale</span>
                        </div>
                        <a href="tel:+237600000000" class="flex items-center gap-3 text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-colors">
                            <Phone class="w-4 h-4 text-blue-600 shrink-0" />
                            <span>+237 6 00 00 00 00</span>
                        </a>
                        <a href="mailto:contact@shoptech.cm" class="flex items-center gap-3 text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-colors">
                            <Mail class="w-4 h-4 text-blue-600 shrink-0" />
                            <span>contact@shoptech.cm</span>
                        </a>
                        <div class="flex items-center gap-3 text-slate-500 dark:text-slate-400">
                            <Clock class="w-4 h-4 text-blue-600 shrink-0" />
                            <span>Lun–Sam : 8h – 18h</span>
                        </div>
                    </div>
                    <!-- Social -->
                    <div class="flex gap-3 pt-1">
                        <a href="https://facebook.com" target="_blank" class="w-9 h-9 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center hover:bg-blue-600 hover:text-white text-slate-500 transition-all">
                            <Facebook class="w-4 h-4" />
                        </a>
                        <a href="https://instagram.com" target="_blank" class="w-9 h-9 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center hover:bg-pink-500 hover:text-white text-slate-500 transition-all">
                            <Instagram class="w-4 h-4" />
                        </a>
                        <a href="https://twitter.com" target="_blank" class="w-9 h-9 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center hover:bg-sky-500 hover:text-white text-slate-500 transition-all">
                            <Twitter class="w-4 h-4" />
                        </a>
                        <a href="https://wa.me/237600000000" target="_blank" class="w-9 h-9 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center hover:bg-green-500 hover:text-white text-slate-500 transition-all">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Boutique -->
                <div class="space-y-5">
                    <h4 class="text-[13px] font-bold text-slate-900 dark:text-slate-100">La Boutique</h4>
                    <ul class="space-y-3 text-sm font-semibold">
                        <li><Link :href="products.index().url" class="text-slate-600 dark:text-slate-400 hover:text-blue-600 transition-colors">Tous les produits</Link></li>
                        <li><Link :href="products.index({ query: { category: 'smartphones' } }).url" class="text-slate-600 dark:text-slate-400 hover:text-blue-600 transition-colors">Smartphones</Link></li>
                        <li><Link :href="products.index({ query: { category: 'ordinateurs' } }).url" class="text-slate-600 dark:text-slate-400 hover:text-blue-600 transition-colors">Ordinateurs</Link></li>
                        <li><Link :href="products.index({ query: { category: 'accessoires' } }).url" class="text-slate-600 dark:text-slate-400 hover:text-blue-600 transition-colors">Accessoires</Link></li>
                        <li><Link :href="products.index({ query: { sort: 'discount' } }).url" class="text-slate-600 dark:text-slate-400 hover:text-blue-600 transition-colors">Promotions</Link></li>
                    </ul>
                </div>

                <!-- Infos & Support -->
                <div class="space-y-5">
                    <h4 class="text-[13px] font-bold text-slate-900 dark:text-slate-100">Support</h4>
                    <ul class="space-y-3 text-sm font-semibold">
                        <li><Link :href="contact()" class="text-slate-600 dark:text-slate-400 hover:text-blue-600 transition-colors">Nous contacter</Link></li>
                        <li><Link :href="services()" class="text-slate-600 dark:text-slate-400 hover:text-blue-600 transition-colors">Nos services</Link></li>
                        <li><Link :href="about()" class="text-slate-600 dark:text-slate-400 hover:text-blue-600 transition-colors">À propos</Link></li>
                        <li><a href="#" class="text-slate-600 dark:text-slate-400 hover:text-blue-600 transition-colors">Livraison & Retours</a></li>
                        <li><a href="#" class="text-slate-600 dark:text-slate-400 hover:text-blue-600 transition-colors">FAQ</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div class="space-y-5">
                    <h4 class="text-[13px] font-bold text-slate-900 dark:text-slate-100">Newsletter</h4>
                    <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                        Recevez nos offres exclusives et nouveautés.
                    </p>
                    <div class="relative">
                        <input
                            type="email"
                            placeholder="votre@email.com"
                            class="w-full pl-4 pr-12 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl focus:ring-2 focus:ring-blue-600 transition-all text-sm font-medium outline-none"
                        />
                        <button class="absolute right-2 top-2 p-1.5 bg-blue-600 text-white rounded-xl shadow-md shadow-blue-500/20 hover:bg-blue-700 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                    <!-- WhatsApp CTA -->
                    <a
                        href="https://wa.me/237600000000?text=Bonjour%20ShopTech%2C%20j'ai%20besoin%20d'aide"
                        target="_blank"
                        class="flex items-center gap-2 px-4 py-2.5 bg-green-500 text-white rounded-2xl text-xs font-bold shadow-md shadow-green-500/20 hover:bg-green-600 transition-all w-full justify-center"
                    >
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        WhatsApp
                    </a>
                </div>
            </div>

            <!-- Bottom bar -->
            <div class="pt-8 border-t border-slate-100 dark:border-slate-800 flex flex-col md:flex-row justify-between items-center gap-4 text-[13px] font-bold text-slate-400">
                <p>&copy; {{ new Date().getFullYear() }} ShopTech. Tous droits réservés.</p>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-blue-600 transition-colors">Mentions Légales</a>
                    <a href="#" class="hover:text-blue-600 transition-colors">Confidentialité</a>
                    <a href="#" class="hover:text-blue-600 transition-colors">CGV</a>
                </div>
                <p>Made with ❤️ in Cameroun</p>
            </div>
        </div>

        <!-- Scroll to top FAB -->
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
                class="fixed bottom-28 right-6 z-50 w-12 h-12 bg-blue-600 text-white rounded-2xl shadow-xl shadow-blue-500/30 flex items-center justify-center hover:bg-blue-700 hover:-translate-y-1 transition-all"
                aria-label="Retour en haut"
            >
                <ArrowUp class="w-5 h-5" />
            </button>
        </transition>
    </footer>
</template>
