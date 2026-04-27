<script setup lang="ts">
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { BookOpen, FolderGit2, LayoutGrid, ShoppingBag, Users, Layers, Settings } from 'lucide-vue-next';
import AppLogo from '@/components/AppLogo.vue';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import type { NavItem } from '@/types';

const page = usePage();
const user = computed(() => page.props.auth.user);
const isAdmin = computed(() => user.value?.role === 'admin');

const mainNavItems = computed((): NavItem[] => {
    if (isAdmin.value) {
        return [
            {
                title: 'Dashboard',
                href: route('admin.dashboard'),
                icon: LayoutGrid,
            },
            {
                title: 'Produits',
                href: route('admin.products.index'),
                icon: ShoppingBag,
            },
            {
                title: 'Commandes',
                href: route('admin.orders.index'),
                icon: Layers,
            },
            {
                title: 'Utilisateurs',
                href: '#',
                icon: Users,
            },
        ];
    }

    return [
        {
            title: 'Dashboard',
            href: dashboard(),
            icon: LayoutGrid,
        },
        {
            title: 'Mes Commandes',
            href: route('orders.index'),
            icon: ShoppingBag,
        },
        {
            title: 'Boutique',
            href: route('products.index'),
            icon: Layers,
        },
    ];
});

const footerNavItems: NavItem[] = [
    {
        title: 'Paramètres',
        href: route('profile.edit'),
        icon: Settings,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="isAdmin ? route('admin.dashboard') : dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
