<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { home } from '@/routes';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div class="flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10 auth-bg">
        <div class="flex w-full max-w-md flex-col gap-6">
            <Link :href="home()" class="flex items-center gap-2 self-center font-medium">
                <div class="flex h-9 w-9 items-center justify-center">
                    <AppLogoIcon class="size-9 fill-current text-black dark:text-white" />
                </div>
            </Link>

            <div class="flex flex-col gap-6">
                <div class="auth-card">
                    <div class="text-center px-10 pt-8 pb-0">
                        <h2 class="text-xl font-semibold tracking-tight" v-if="title">{{ title }}</h2>
                        <p class="text-sm text-muted-foreground mt-1" v-if="description">{{ description }}</p>
                    </div>
                    <div class="px-10 py-8">
                        <slot />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.auth-bg {
    background-color: hsl(0 0% 96.1%);
}

.dark .auth-bg {
    background-color: hsl(0 0% 3.9%);
}

.auth-card {
    background-color: white;
    border-radius: 0.75rem;
    box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
}

.dark .auth-card {
    background-color: hsl(0 0% 3.9%);
    border: 1px solid hsl(0 0% 14.9%);
}
</style>