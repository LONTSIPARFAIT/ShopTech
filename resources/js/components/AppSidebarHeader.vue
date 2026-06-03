<script setup lang="ts">
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import { SidebarTrigger } from '@/components/ui/sidebar';
import type { BreadcrumbItem } from '@/types';
import { usePage, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useAppearance } from '@/composables/useAppearance';
import { Sun, Moon, User, Shield } from 'lucide-vue-next';
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
        class="fixed top-0 right-0 left-0 z-30 flex h-16 shrink-0 items-center justify-between border-b border-border bg-background/80 px-4 backdrop-blur-md transition-[width,height] ease-linear md:px-6 lg:left-[var(--sidebar-width)]"
    >
        <div class="flex items-center gap-2">
            <SidebarTrigger class="-ml-1 text-muted-foreground hover:text-primary transition-colors" />
            <template v-if="breadcrumbs && breadcrumbs.length > 0">
                <Breadcrumbs :breadcrumbs="breadcrumbs" />
            </template>
        </div>

        <div class="flex items-center gap-3">
            <!-- Theme Toggle -->
            <button
                @click="toggleTheme"
                class="flex h-9 w-9 items-center justify-center rounded-lg text-muted-foreground transition-all duration-200 hover:bg-primary/10 hover:text-primary"
                aria-label="Toggle theme"
            >
                <Sun v-if="appearance === 'dark'" class="h-5 w-5 text-amber-400" />
                <Moon v-else class="h-5 w-5" />
            </button>

            <!-- User Profile -->
            <Link
                v-if="auth.user"
                :href="profileEdit().url"
                class="group flex items-center gap-3 rounded-lg pl-3 transition-all duration-200 hover:bg-primary/5"
            >
                <div class="flex flex-col items-end">
                    <span class="max-w-[150px] truncate text-sm font-semibold text-foreground group-hover:text-primary transition-colors">
                        {{ auth.user.name }}
                    </span>
                    <div class="flex items-center gap-1">
                        <Shield v-if="auth.user.role === 'admin'" class="h-3 w-3 text-primary" />
                        <span class="text-[10px] font-bold uppercase tracking-wider text-muted-foreground">
                            {{ auth.user.role === 'admin' ? 'Administrateur' : 'Client' }}
                        </span>
                    </div>
                </div>
                <div class="h-9 w-9 flex-shrink-0 overflow-hidden rounded-lg border-2 border-primary/20 bg-secondary transition-all duration-200 group-hover:border-primary">
                    <img
                        :src="auth.user.avatar_url"
                        :alt="auth.user.name"
                        class="h-full w-full object-cover"
                    />
                </div>
            </Link>
        </div>
    </header>
</template>
