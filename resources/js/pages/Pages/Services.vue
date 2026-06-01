<!--
  ⚠️ OBSOLÈTE - Cette page n'est plus utilisée

  La route /services a été modifiée pour pointer vers ServiceController@index
  qui rend la page Services/Index.vue (dynamique) à la place.

  Cette page statique est conservée pour archivage uniquement.

  Nouvelle page: resources/js/pages/Services/Index.vue

  Vous pouvez supprimer ce fichier en toute sécurité.
-->

<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import ShopLayout from '@/layouts/ShopLayout.vue';
import { ArrowRight } from 'lucide-vue-next';

defineOptions({ layout: ShopLayout });
</script>

<template>
    <Head title="Services – ProTech" />

    <div class="pt-20">
        <!-- Redirect Notice -->
        <section class="py-16 md:py-24 bg-blue-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl font-bold text-slate-800 mb-4">
                    Services Professionnels
                </h1>
                <p class="text-lg text-slate-600 mb-8">
                    Cette page a été remplacée par une nouvelle version dynamique.
                </p>
                <a href="/services" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                    Voir nos services
                    <ArrowRight class="w-4 h-4" />
                </a>
            </div>
        </section>
    </div>
</template>
