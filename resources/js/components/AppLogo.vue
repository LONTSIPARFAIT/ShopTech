<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';
</script>

<template>
    <div
        class="flex aspect-square size-8 items-center justify-center rounded-md bg-sidebar-primary text-sidebar-primary-foreground"
    >
        <AppLogoIcon class="size-5 fill-current text-white dark:text-black" />
    </div>
    <div class="ml-2 grid flex-1 text-left text-sm">
        <span class="truncate leading-tight font-black uppercase tracking-tighter"
            >Shop<span class="text-blue-600">Tech</span></span
        >
    </div>
</template>
