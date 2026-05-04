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

<style>
.marge {
    margin: 0 0 auto;
}
</style>

<template>
    <div class="marge max-w-6xl p-4 md:p-6">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white md:text-3xl">Paramètres</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Gérez votre profil, la sécurité et l'apparence de votre compt
            </p>
        </div>

        <div class="flex flex-col gap-8 lg:flex-row lg:gap-12">
            <!-- Sidebar Navigation -->
            <aside class="w-full lg:w-64">
                <nav class="flex flex-row gap-1 lg:flex-col lg:space-y-1" aria-label="Paramètres">
                    <Button
                        v-for="item in sidebarNavItems"
                        :key="toUrl(item.href)"
                        variant="ghost"
                        :class="[
                            'justify-start gap-2',
                            isCurrentOrParentUrl(item.href) 
                                ? 'bg-gray-100 text-gray-900 dark:bg-gray-800 dark:text-white' 
                                : 'text-gray-600 dark:text-gray-400'
                        ]"
                        as-child
                    >
                        <Link :href="item.href">
                            <component :is="item.icon" class="h-4 w-4" />
                            {{ item.title }}
                        </Link>
                    </Button>
                </nav>
            </aside>

            <Separator class="lg:hidden" />

            <!-- Content -->
            <div class="flex-1">
                <slot />
            </div>
        </div>
    </div>
</template>