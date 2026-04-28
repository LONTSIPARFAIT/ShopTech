<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import { X, ArrowUp, MessageCircle, Phone } from 'lucide-vue-next';

const isOpen = ref(false);
const showScrollTop = ref(false);
const isVisible = ref(false); // for FAB entrance animation

const WHATSAPP_NUMBER = '237600000000';
const WHATSAPP_MSG = encodeURIComponent("Bonjour ShopTech, j'ai besoin d'aide.");

const handleScroll = () => {
    showScrollTop.value = window.scrollY > 300;
};

const scrollToTop = () => window.scrollTo({ top: 0, behavior: 'smooth' });

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
    // Delay entrance so it slides in after page load
    setTimeout(() => { isVisible.value = true; }, 800);
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});
</script>

<template>
    <!-- FAB Container -->
    <div class="fixed bottom-6 right-6 z-50 flex flex-col items-end gap-3"
        :class="isVisible ? 'translate-y-0 opacity-100' : 'translate-y-16 opacity-0'"
        style="transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.6s ease;">
        <!-- Scroll to Top -->
        <transition enter-active-class="transition-all duration-400 ease-[cubic-bezier(0.34,1.56,0.64,1)]"
            enter-from-class="opacity-0 scale-50 translate-y-4" enter-to-class="opacity-100 scale-100 translate-y-0"
            leave-active-class="transition-all duration-200 ease-in"
            leave-from-class="opacity-100 scale-100 translate-y-0" leave-to-class="opacity-0 scale-50 translate-y-4">
            <button v-if="showScrollTop" @click="scrollToTop"
                class="w-11 h-11 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 rounded-2xl shadow-lg shadow-black/10 dark:shadow-black/30 flex items-center justify-center border border-slate-100 dark:border-slate-700 hover:bg-blue-600 hover:text-white hover:border-blue-600 hover:-translate-y-1 transition-all group"
                aria-label="Retour en haut">
                <ArrowUp class="w-4 h-4 group-hover:-translate-y-0.5 transition-transform" />
            </button>
        </transition>

        <!-- Sub-Actions (WhatsApp, Form, Phone) -->
        <transition enter-active-class="transition-all duration-300 ease-out"
            enter-from-class="opacity-0 scale-75 translate-y-6" enter-to-class="opacity-100 scale-100 translate-y-0"
            leave-active-class="transition-all duration-200 ease-in"
            leave-from-class="opacity-100 scale-100 translate-y-0" leave-to-class="opacity-0 scale-75 translate-y-6">
            <div v-if="isOpen" class="flex flex-col items-end gap-2.5">
                <!-- WhatsApp -->
                <a :href="`https://wa.me/${WHATSAPP_NUMBER}?text=${WHATSAPP_MSG}`" target="_blank"
                    class="flex items-center gap-3 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-700 shadow-xl rounded-2xl pl-4 pr-3 py-2.5 hover:-translate-y-0.5 hover:shadow-2xl transition-all group">
                    <span
                        class="text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-300 group-hover:text-green-600 transition-colors whitespace-nowrap">WhatsApp</span>
                    <div
                        class="w-9 h-9 bg-green-500 rounded-xl flex items-center justify-center shadow-md shadow-green-500/30 group-hover:scale-110 transition-transform">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg>
                    </div>
                </a>

                <!-- Contact Form -->
                <a href="/contact"
                    class="flex items-center gap-3 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-700 shadow-xl rounded-2xl pl-4 pr-3 py-2.5 hover:-translate-y-0.5 hover:shadow-2xl transition-all group">
                    <span
                        class="text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-300 group-hover:text-blue-600 transition-colors whitespace-nowrap">Formulaire</span>
                    <div
                        class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center shadow-md shadow-blue-500/30 group-hover:scale-110 transition-transform">
                        <MessageCircle class="w-4 h-4 text-white" />
                    </div>
                </a>

                <!-- Phone -->
                <a href="tel:+237600000000"
                    class="flex items-center gap-3 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-700 shadow-xl rounded-2xl pl-4 pr-3 py-2.5 hover:-translate-y-0.5 hover:shadow-2xl transition-all group">
                    <span
                        class="text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-300 group-hover:text-indigo-600 transition-colors whitespace-nowrap">Appeler</span>
                    <div
                        class="w-9 h-9 bg-indigo-600 rounded-xl flex items-center justify-center shadow-md shadow-indigo-500/30 group-hover:scale-110 transition-transform">
                        <Phone class="w-4 h-4 text-white" />
                    </div>
                </a>
            </div>
        </transition>

        <!-- Main FAB -->
        <button @click="isOpen = !isOpen"
            class="relative w-14 h-14 bg-blue-600 text-white rounded-2xl shadow-2xl shadow-blue-500/40 flex items-center justify-center hover:scale-110 active:scale-95 transition-all"
            :class="isOpen ? 'rotate-0' : 'rotate-0'" :aria-label="isOpen ? 'Fermer' : 'Assistance'">
            <!-- Ping animation ring (only when closed) -->
            <span v-if="!isOpen" class="absolute inset-0 rounded-2xl bg-blue-400 opacity-0 animate-ping"
                style="animation-duration: 2.5s;"></span>

            <!-- Icon transition -->
            <transition enter-active-class="transition-all duration-200 ease-out"
                enter-from-class="rotate-90 opacity-0 scale-75" enter-to-class="rotate-0 opacity-100 scale-100"
                leave-active-class="transition-all duration-150 ease-in"
                leave-from-class="rotate-0 opacity-100 scale-100" leave-to-class="-rotate-90 opacity-0 scale-75"
                mode="out-in">
                <X v-if="isOpen" class="w-6 h-6" />
                <svg v-else class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                </svg>
            </transition>
        </button>
    </div>
</template>
