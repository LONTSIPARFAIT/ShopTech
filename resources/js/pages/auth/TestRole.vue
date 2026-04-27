<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import { dashboard } from '@/routes';
import AppLayout from '@/layouts/AppLayout.vue';

const page = usePage();
const user = page.props.auth.user;

defineOptions({
    layout: AppLayout,
});
</script>

<template>
    <Head title="Vérification des Accès" />

    <div class="max-w-4xl mx-auto p-6 lg:p-12 space-y-12">
        <div class="text-center space-y-4">
            <h1 class="text-4xl font-black tracking-tight">Test de Sécurité</h1>
            <p class="text-slate-500 font-medium">Vérifiez vos privilèges d'accès aux différentes sections de la plateforme.</p>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-2xl p-12 space-y-12">
            <div class="flex items-center gap-6 p-8 bg-slate-50 dark:bg-slate-800/50 rounded-3xl">
                <div class="w-20 h-20 bg-blue-600 text-white rounded-2xl flex items-center justify-center font-black text-3xl shadow-lg shadow-blue-500/20">
                    {{ user.name.charAt(0) }}
                </div>
                <div class="space-y-1">
                    <p class="text-xs font-black uppercase tracking-widest text-slate-400">Utilisateur Actuel</p>
                    <p class="text-2xl font-black">{{ user.name }}</p>
                    <div class="inline-flex px-3 py-1 bg-blue-500 text-white text-[10px] font-black uppercase tracking-widest rounded-full">
                        Rôle: {{ user.role }}
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-4">
                    <h3 class="font-black text-lg">Zone Admin</h3>
                    <p class="text-sm text-slate-500">Accès réservé aux administrateurs pour la gestion globale.</p>
                    <a 
                        href="/admin/dashboard"
                        class="block w-full text-center px-8 py-4 bg-red-600 text-white rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-red-700 transition-all shadow-lg shadow-red-500/20"
                    >
                        Accéder au Panel Admin
                    </a>
                </div>

                <div class="space-y-4">
                    <h3 class="font-black text-lg">Zone Client</h3>
                    <p class="text-sm text-slate-500">Accès pour les clients enregistrés (Commandes, Profil).</p>
                    <a 
                        href="/client/debug"
                        class="block w-full text-center px-8 py-4 bg-green-600 text-white rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-green-700 transition-all shadow-lg shadow-green-500/20"
                    >
                        Vérifier Espace Client
                    </a>
                </div>
            </div>

            <div class="p-6 bg-amber-50 dark:bg-amber-900/20 border border-amber-100 dark:border-amber-800 rounded-2xl flex gap-4 items-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-amber-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 15.667c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <p class="text-sm text-amber-700 dark:text-amber-400 font-medium leading-relaxed">
                    Si vous tentez d'accéder à une zone non autorisée par votre rôle, le système vous renverra automatiquement une erreur 403 (Accès Refusé) ou vous redirigera.
                </p>
            </div>
        </div>
    </div>
</template>
