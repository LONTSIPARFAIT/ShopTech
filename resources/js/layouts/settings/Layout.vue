<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { useCurrentUrl } from '@/composables/useCurrentUrl';
import { toUrl } from '@/lib/utils';
import { edit as editAppearance } from '@/routes/appearance';
import { edit as editProfile } from '@/routes/profile';
import { edit as editSecurity } from '@/routes/security';
import { User, Shield, Palette } from 'lucide-vue-next';
import type { NavItem } from '@/types';

const sidebarNavItems: NavItem[] = [
    {
        title: 'Profil',
        href: editProfile(),
        icon: User,
    },
    {
        title: 'Sécurité',
        href: editSecurity(),
        icon: Shield,
    },
    {
        title: 'Apparence',
        href: editAppearance(),
        icon: Palette,
    },
];

const { isCurrentOrParentUrl } = useCurrentUrl();
</script>

<template>
    <div class="max-w-6xl px-4 py-1 md:px-6 md:py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-foreground md:text-3xl">Paramètres</h1>
            <p class="mt-1 text-sm text-muted-foreground">
                Gérez votre profil, la sécurité et l'apparence de votre compt
            </p>
        </div>

        <div class="flex flex-col gap-8 lg:flex-row lg:gap-12">
            <!-- Sidebar Navigation -->
            <aside class="w-full lg:w-64">
               <nav class="flex flex-row gap-1 lg:flex-col lg:space-y-1" aria-label="Paramètres">
    <Link
        v-for="item in sidebarNavItems"
        :key="toUrl(item.href)"
        :href="item.href"
        :class="[
            'inline-flex items-center justify-start gap-2 w-full h-10 px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 whitespace-nowrap focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50',
            isCurrentOrParentUrl(item.href)
                ? 'bg-primary/10 text-primary hover:bg-primary/15'
                : 'text-muted-foreground hover:bg-secondary hover:text-foreground'
        ]"
    >
        <component :is="item.icon" class="h-4 w-4" />
        {{ item.title }}
    </Link>
</nav>
            </aside>

            <Separator class="lg:hidden bg-border" />

            <!-- Content -->
            <div class="flex-1">
                <slot />
            </div>
        </div>
    </div>
</template>
