<script setup lang="ts">
import ShopHeader from '@/components/Shop/ShopHeader.vue';
import ShopFooter from '@/components/Shop/ShopFooter.vue';
import AssistanceFab from '@/components/Shop/AssistanceFab.vue';
import { Toaster } from '@/components/ui/sonner';
</script>

<template>
    <div class="shop-layout">
        <ShopHeader />
        <main>
            <slot />
        </main>
        <ShopFooter />
        <AssistanceFab />
        <Toaster />
    </div>
</template>