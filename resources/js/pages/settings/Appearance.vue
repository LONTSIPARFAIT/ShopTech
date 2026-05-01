<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppearanceTabs from '@/components/AppearanceTabs.vue';
import { edit } from '@/routes/appearance';
import { ArrowLeft, Palette } from 'lucide-vue-next';
</script>

<template>

    <Head title="Apparence" />
    <div class="space-y-6 max-w-2xl ">
        <!-- Appearance Card -->
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900/50">
            <div class="mb-6 flex items-center gap-3 border-b border-gray-100 pb-4 dark:border-gray-800">
                <div
                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-purple-50 to-indigo-50 text-purple-600 dark:from-purple-950/50 dark:to-indigo-950/50 dark:text-purple-400">
                    <Palette class="h-5 w-5" />
                </div>
                <div>
                    <h2 class="font-semibold text-gray-900 dark:text-white">Thème</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Choisissez entre le mode clair, sombre ou automatique
                    </p>
                </div>
            </div>
            <AppearanceTabs />
        </div>
    </div>
</template>