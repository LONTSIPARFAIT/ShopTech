<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { login, register, dashboard } from '@/routes';

defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
    laravelVersion: string;
    phpVersion: string;
}>();
</script>

<template>
    <Head title="Bienvenue chez ShopTech" />

    <div class="relative min-h-screen bg-white text-slate-900 dark:bg-slate-950 dark:text-slate-100 transition-colors duration-300 overflow-hidden">
        <!-- Background Orbs -->
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute top-1/2 -right-24 w-80 h-80 bg-purple-500/10 rounded-full blur-3xl"></div>

        <!-- Navbar -->
        <nav class="relative z-10 flex items-center justify-between px-6 py-8 mx-auto max-w-7xl lg:px-12">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <span class="text-2xl font-bold tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400">
                    ShopTech
                </span>
            </div>

            <div class="hidden md:flex items-center gap-8 text-sm font-medium">
                <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Catalogue</a>
                <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Promotions</a>
                <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">À propos</a>
            </div>

            <div class="flex items-center gap-4">
                <template v-if="$page.props.auth.user">
                    <Link :href="dashboard()" class="px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-full hover:bg-blue-700 shadow-md shadow-blue-500/20 transition-all hover:-translate-y-0.5">
                        Dashboard
                    </Link>
                </template>
                <template v-else>
                    <Link :href="login()" class="text-sm font-semibold hover:text-blue-600 transition-colors">
                        Connexion
                    </Link>
                    <Link :href="register()" class="px-5 py-2.5 text-sm font-semibold text-white bg-slate-900 dark:bg-white dark:text-slate-950 rounded-full hover:opacity-90 transition-all shadow-xl hover:-translate-y-0.5">
                        S'inscrire
                    </Link>
                </template>
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="relative z-10 px-6 pt-16 pb-24 mx-auto max-w-7xl lg:px-12 lg:pt-32">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="space-y-8 max-w-2xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 text-xs font-bold tracking-wider text-blue-600 uppercase bg-blue-100 rounded-full dark:bg-blue-900/30 dark:text-blue-400">
                        <span class="relative flex w-2 h-2">
                            <span class="absolute inline-flex w-full h-full bg-blue-400 rounded-full opacity-75 animate-ping"></span>
                            <span class="relative inline-flex w-2 h-2 bg-blue-500 rounded-full"></span>
                        </span>
                        Nouvelle Collection Disponible
                    </div>
                    
                    <h1 class="text-5xl font-black tracking-tight sm:text-7xl leading-[1.1]">
                        L'innovation <br />
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600">
                            À portée de main.
                        </span>
                    </h1>

                    <p class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed max-w-xl">
                        Découvrez les dernières technologies et gadgets premium chez ShopTech. 
                        Qualité garantie, livraison rapide au Cameroun et partout en Afrique.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        <button class="px-8 py-4 text-lg font-bold text-white bg-blue-600 rounded-2xl hover:bg-blue-700 shadow-xl shadow-blue-500/25 transition-all hover:-translate-y-1 active:scale-95 group">
                            Découvrir le Catalogue
                            <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-5 h-5 ml-2 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                        <button class="px-8 py-4 text-lg font-bold bg-white text-slate-900 border border-slate-200 dark:bg-slate-900 dark:text-white dark:border-slate-800 rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-all hover:-translate-y-1 active:scale-95 shadow-lg">
                            Nos Promotions
                        </button>
                    </div>

                    <!-- Stats -->
                    <div class="flex gap-12 pt-8 border-t border-slate-100 dark:border-slate-800/50">
                        <div>
                            <div class="text-3xl font-bold">10k+</div>
                            <div class="text-sm text-slate-500">Clients Satisfaits</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold">500+</div>
                            <div class="text-sm text-slate-500">Produits Tech</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold">24h</div>
                            <div class="text-sm text-slate-500">Livraison Moyenne</div>
                        </div>
                    </div>
                </div>

                <!-- Visual Element -->
                <div class="relative group lg:block">
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-purple-600 rounded-[2.5rem] blur opacity-25 group-hover:opacity-40 transition duration-1000 group-hover:duration-200"></div>
                    <div class="relative overflow-hidden rounded-[2.5rem] bg-slate-100 dark:bg-slate-900 border border-white/10 shadow-2xl aspect-[4/5] sm:aspect-[4/3] lg:aspect-square">
                        <!-- We'll use the generated image here in a real scenario -->
                        <img 
                            src="https://images.unsplash.com/photo-1550745165-9bc0b252726f?q=80&w=2070&auto=format&fit=crop" 
                            alt="Tech Banner"
                            class="object-cover w-full h-full transition-transform duration-700 group-hover:scale-105"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>
                        <div class="absolute bottom-8 left-8 right-8 p-6 bg-white/10 backdrop-blur-md rounded-2xl border border-white/20">
                            <div class="flex justify-between items-end">
                                <div>
                                    <h3 class="text-white font-bold text-xl">Nouveautés 2026</h3>
                                    <p class="text-white/70 text-sm">Préparez-vous pour le futur</p>
                                </div>
                                <div class="px-4 py-2 bg-blue-500 text-white rounded-lg font-bold text-xs">
                                    -20% OFF
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Features Grid -->
        <section class="relative z-10 px-6 py-24 mx-auto max-w-7xl lg:px-12 bg-slate-50/50 dark:bg-slate-900/30 rounded-[3rem] my-12">
            <div class="text-center mb-16 space-y-4">
                <h2 class="text-3xl font-black sm:text-4xl">Pourquoi choisir ShopTech ?</h2>
                <p class="text-slate-500 dark:text-slate-400 max-w-2xl mx-auto">
                    Nous nous engageons à fournir les meilleurs produits tech avec une expérience client exceptionnelle.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-8 bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700/50 shadow-sm hover:shadow-xl transition-all hover:-translate-y-2 group">
                    <div class="w-14 h-14 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Produits Authentiques</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed">
                        Tous nos articles proviennent directement des fabricants officiels avec garantie constructeur.
                    </p>
                </div>

                <div class="p-8 bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700/50 shadow-sm hover:shadow-xl transition-all hover:-translate-y-2 group">
                    <div class="w-14 h-14 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 012 2 2 2 0 01-2 2 2 2 0 01-2-2 2 2 0 012-2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Paiement Sécurisé</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed">
                        Payez en toute sécurité via Notch Pay (Mobile Money) ou à la livraison (COD).
                    </p>
                </div>

                <div class="p-8 bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700/50 shadow-sm hover:shadow-xl transition-all hover:-translate-y-2 group">
                    <div class="w-14 h-14 bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Service Client 24/7</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed">
                        Notre équipe est disponible à tout moment pour répondre à vos questions et vous assister.
                    </p>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="px-6 py-12 mx-auto max-w-7xl lg:px-12 border-t border-slate-100 dark:border-slate-800/50">
            <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-slate-900 dark:bg-white rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white dark:text-slate-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold tracking-tight">ShopTech</span>
                </div>
                
                <p class="text-sm text-slate-500">
                    &copy; 2026 ShopTech. Tous droits réservés. Propulsé par Laravel & Inertia.
                </p>

                <div class="flex gap-6">
                    <a href="#" class="text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">
                        <span class="sr-only">Facebook</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                    </a>
                    <a href="#" class="text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">
                        <span class="sr-only">Instagram</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                </div>
            </div>
        </footer>
    </div>
</template>

<style scoped>
@keyframes blob {
    0% { transform: translate(0px, 0px) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
    100% { transform: translate(0px, 0px) scale(1); }
}
</style>
