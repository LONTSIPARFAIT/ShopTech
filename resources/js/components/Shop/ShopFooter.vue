<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import products from '@/routes/products';
import { home, contact, about, services, dashboard } from '@/routes';
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
    <footer class="shop-footer">
        <div class="shop-footer-bg-blur"></div>
        
        <div class="shop-footer-container">
            <div class="shop-footer-grid">
                <!-- Brand Column -->
                <div class="shop-footer-brand">
                    <div class="shop-footer-logo">
                        <div class="shop-logo-icon">
                            <span class="text-white font-bold text-sm">S</span>
                        </div>
                        <span class="shop-logo-text">Shop<span class="shop-logo-highlight">Tech</span></span>
                    </div>
                    <p class="shop-footer-description">
                        Votre destination ultime pour l'innovation technologique au Cameroun.
                    </p>
                    
                    <div class="shop-footer-contact">
                        <div class="shop-footer-contact-item">
                            <MapPin class="w-4 h-4 text-blue-600" />
                            <span>Yaoundé, Cameroun</span>
                        </div>
                        <a href="tel:+237600000000" class="shop-footer-contact-item">
                            <Phone class="w-4 h-4 text-blue-600" />
                            <span>+237 6 00 00 00 00</span>
                        </a>
                        <a href="mailto:contact@shoptech.cm" class="shop-footer-contact-item">
                            <Mail class="w-4 h-4 text-blue-600" />
                            <span>contact@shoptech.cm</span>
                        </a>
                        <div class="shop-footer-contact-item">
                            <Clock class="w-4 h-4 text-blue-600" />
                            <span>Lun–Sam : 8h – 18h</span>
                        </div>
                    </div>
                    
                    <div class="shop-footer-social">
                        <a href="https://facebook.com" target="_blank" class="shop-footer-social-link facebook">
                            <Facebook class="w-4 h-4" />
                        </a>
                        <a href="https://instagram.com" target="_blank" class="shop-footer-social-link instagram">
                            <Instagram class="w-4 h-4" />
                        </a>
                        <a href="https://twitter.com" target="_blank" class="shop-footer-social-link twitter">
                            <Twitter class="w-4 h-4" />
                        </a>
                        <a href="https://wa.me/237600000000" target="_blank" class="shop-footer-social-link whatsapp">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Boutique -->
                <div>
                    <h4 class="shop-footer-title">La Boutique</h4>
                    <ul class="shop-footer-links">
                        <li><Link :href="products.index().url">Tous les produits</Link></li>
                        <li><Link :href="products.index({ query: { category: 'smartphones' } }).url">Smartphones</Link></li>
                        <li><Link :href="products.index({ query: { category: 'ordinateurs' } }).url">Ordinateurs</Link></li>
                        <li><Link :href="products.index({ query: { category: 'accessoires' } }).url">Accessoires</Link></li>
                        <li><Link :href="products.index({ query: { sort: 'discount' } }).url">Promotions</Link></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h4 class="shop-footer-title">Support</h4>
                    <ul class="shop-footer-links">
                        <li><Link :href="contact()">Nous contacter</Link></li>
                        <li><Link :href="services()">Nos services</Link></li>
                        <li><Link :href="about()">À propos</Link></li>
                        <li><a href="#">Livraison & Retours</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div>
                    <h4 class="shop-footer-title">Newsletter</h4>
                    <p>Recevez nos offres exclusives et nouveautés.</p>
                    <div class="shop-footer-input-group p-2">
                        <input type="email" placeholder="votre@email.com" class="shop-footer-input" />
                        <button class="shop-footer-submit">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                    <a href="https://wa.me/237600000000" target="_blank" class="shop-footer-whatsapp">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        WhatsApp
                    </a>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="shop-footer-bottom">
                <p>&copy; {{ new Date().getFullYear() }} ShopTech. Tous droits réservés.</p>
                <div class="shop-footer-legal">
                    <a href="#">Mentions Légales</a>
                    <a href="#">Confidentialité</a>
                    <a href="#">CGV</a>
                </div>
                <p>Made with ❤️ in Cameroun</p>
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
            <button v-if="showScrollTop" @click="scrollToTop" class="shop-scroll-top">
                <ArrowUp class="w-5 h-5" />
            </button>
        </transition>
    </footer>
</template>