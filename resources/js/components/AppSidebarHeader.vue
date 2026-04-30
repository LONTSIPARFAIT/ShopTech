<script setup lang="ts">
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import { SidebarTrigger } from '@/components/ui/sidebar';
import type { BreadcrumbItem } from '@/types';
import { usePage, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useAppearance } from '@/composables/useAppearance';
import { Sun, Moon } from 'lucide-vue-next';

import { edit as profileEdit } from '@/routes/profile';

withDefaults(
    defineProps<{
        breadcrumbs?: BreadcrumbItem[];
    }>(),
    {
        breadcrumbs: () => [],
    },
);

const page = usePage();
const auth = computed(() => page.props.auth);

const { appearance, updateAppearance } = useAppearance();
const toggleTheme = () => {
    updateAppearance(appearance.value === 'dark' ? 'light' : 'dark');
};
</script>

<template>
    <header
        class="flex h-16 shrink-0 items-center justify-between border-b border-sidebar-border/70 px-6 transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-12 md:px-4 fixed top-0 right-0 left-0 lg:left-[var(--sidebar-width)] bg-background/80 backdrop-blur-md z-30"
    >
        <div class="flex items-center gap-2">
            <SidebarTrigger class="-ml-1" />
            <template v-if="breadcrumbs && breadcrumbs.length > 0">
                <Breadcrumbs :breadcrumbs="breadcrumbs" />
            </template>
        </div>

        <div class="flex items-center gap-4">
            <!-- Theme Toggle -->
            <button 
                @click="toggleTheme" 
                class="p-2 rounded-lg hover:bg-secondary transition-colors text-muted-foreground"
                aria-label="Toggle theme"
            >
                <Sun v-if="appearance === 'dark'" class="w-5 h-5 text-amber-400" />
                <Moon v-else class="w-5 h-5" />
            </button>

            <!-- User Profile -->
            <Link v-if="auth.user" :href="profileEdit().url" class="flex items-center gap-3 pl-2 border-l border-border hover:opacity-80 transition-opacity">
                <div class="flex flex-col items-end hidden sm:flex">
                    <span class="text-sm font-semibold truncate max-w-[150px]">{{ auth.user.name }}</span>
                    <span class="text-[10px] text-muted-foreground uppercase tracking-wider font-bold">{{ auth.user.role }}</span>
                </div>
                <div class="w-9 h-9 rounded-full overflow-hidden border-2 border-primary/20 bg-secondary flex-shrink-0">
                    <img 
                        :src="auth.user.avatar_url" 
                        :alt="auth.user.name"
                        class="w-full h-full object-cover"
                    />
                </div>
            </Link>
        </div>
    </header>
</template>
