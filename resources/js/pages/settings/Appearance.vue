<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppearanceTabs from '@/components/AppearanceTabs.vue';
import { edit } from '@/routes/appearance';
import { ArrowLeft, Palette } from 'lucide-vue-next';
</script>

<template>
    <Head title="Apparence" />

    <div class="space-y-6 max-w-2xl">
        <!-- Appearance Card -->
        <div class="rounded-xl border border-border bg-card p-6 shadow-sm">
            <div class="mb-6 flex items-center gap-3 border-b border-border pb-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <Palette class="h-5 w-5" />
                </div>
                <div>
                    <h2 class="font-semibold text-foreground">Thème</h2>
                    <p class="text-xs text-muted-foreground">
                        Choisissez entre le mode clair, sombre ou automatique
                    </p>
                </div>
            </div>
            <AppearanceTabs />
        </div>
    </div>
</template>
