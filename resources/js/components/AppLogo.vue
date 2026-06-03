<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';
</script>

<template>
    <div class="flex items-center gap-2">
        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-primary to-primary-dark shadow-md shadow-primary/20">
            <AppLogoIcon class="h-5 w-5 text-white" />
        </div>
        <div class="flex flex-col">
            <span class="text-sm font-black uppercase tracking-tight text-foreground">
                Shop<span class="text-primary">Tech</span>
            </span>
            <span class="text-[9px] font-semibold uppercase tracking-wider text-muted-foreground">
                {{ $page.props.auth.user?.role === 'admin' ? 'Administration' : 'Espace client' }}
            </span>
        </div>
    </div>
</template>
