<script setup lang="ts">
import ShopHeader from '@/components/Shop/ShopHeader.vue';
import ShopFooter from '@/components/Shop/ShopFooter.vue';
import AssistanceFab from '@/components/Shop/AssistanceFab.vue';
import { Toaster } from '@/components/ui/sonner';
</script>

<template>
    <div class="min-h-screen bg-white dark:bg-slate-950 text-slate-900 dark:text-slate-100 transition-colors duration-500 font-sans selection:bg-blue-500/30">
        <ShopHeader />

        <main>
            <slot />
        </main>

        <ShopFooter />
        <AssistanceFab />
        <Toaster />
    </div>
</template>
