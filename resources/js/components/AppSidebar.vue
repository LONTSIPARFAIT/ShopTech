<script setup lang="ts">
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
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
import { dashboard as clientDashboard } from '@/routes';
import { dashboard as adminDashboard } from '@/routes/admin';
import { index as adminProducts } from '@/routes/admin/products';
import { index as adminOrders } from '@/routes/admin/orders';
import { index as adminUsers } from '@/routes/admin/users';
import { index as ordersIndex } from '@/routes/orders';
import { index as shopIndex } from '@/routes/products';
import { edit as profileEdit } from '@/routes/profile';
import type { NavItem } from '@/types';

const page = usePage();
const user = computed(() => page.props.auth.user);
const isAdmin = computed(() => user.value?.role === 'admin');

const mainNavItems = computed((): NavItem[] => {
    if (isAdmin.value) {
        return [
            {
                title: 'Dashboard',
                href: adminDashboard().url,
                icon: LayoutGrid,
            },
            {
                title: 'Produits',
                href: adminProducts().url,
                icon: ShoppingBag,
            },
            {
                title: 'Commandes',
                href: adminOrders().url,
                icon: Layers,
            },
            {
                title: 'Utilisateurs',
                href: adminUsers().url,
                icon: Users,
            },
        ];
    }

    return [
        {
            title: 'Dashboard',
            href: clientDashboard().url,
            icon: LayoutGrid,
        },
        {
            title: 'Mes Commandes',
            href: ordersIndex().url,
            icon: ShoppingBag,
        },
        {
            title: 'Boutique',
            href: shopIndex().url,
            icon: Layers,
        },
    ];
});

// const footerNavItems: NavItem[] = [
//     {
//         title: 'Paramètres',
//         href: profileEdit().url,
//         icon: Settings,
//     },
// ];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link href="/">
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
            <!-- <NavFooter :items="footerNavItems" /> -->
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
