<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { ChevronsUpDown, LogOut, Settings, User, Shield } from 'lucide-vue-next';
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import {
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    useSidebar,
} from '@/components/ui/sidebar';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { edit as profileEdit } from '@/routes/profile';
import { logout } from '@/routes';

const page = usePage();
const user = computed(() => page.props.auth.user);
const { isMobile, state } = useSidebar();
</script>

<template>
    <SidebarMenu>
        <SidebarMenuItem>
            <DropdownMenu>
                <DropdownMenuTrigger as-child>
                    <SidebarMenuButton
                        size="lg"
                        class="data-[state=open]:bg-primary/10 data-[state=open]:text-primary hover:bg-primary/10 hover:text-primary transition-all duration-200"
                        data-test="sidebar-menu-button"
                    >
                        <div class="flex items-center gap-3">
                            <Avatar class="h-8 w-8 rounded-lg">
                                <AvatarImage :src="user.avatar_url" :alt="user.name" />
                                <AvatarFallback class="rounded-lg bg-primary/10 text-primary font-semibold">
                                    {{ user.name?.charAt(0).toUpperCase() }}
                                </AvatarFallback>
                            </Avatar>
                            <div class="flex flex-col items-start text-left">
                                <span class="text-sm font-semibold text-foreground">{{ user.name }}</span>
                                <span class="text-[10px] font-medium text-muted-foreground">{{ user.email }}</span>
                            </div>
                        </div>
                        <ChevronsUpDown class="ml-auto size-4 text-muted-foreground" />
                    </SidebarMenuButton>
                </DropdownMenuTrigger>
                <DropdownMenuContent
                    class="w-56 rounded-xl border-border bg-card shadow-lg"
                    :side="
                        isMobile
                            ? 'bottom'
                            : state === 'collapsed'
                              ? 'left'
                              : 'bottom'
                    "
                    align="end"
                    :side-offset="4"
                >
                    <DropdownMenuLabel class="p-0 font-normal">
                        <div class="flex items-center gap-3 p-3">
                            <Avatar class="h-10 w-10 rounded-xl">
                                <AvatarImage :src="user.avatar_url" :alt="user.name" />
                                <AvatarFallback class="rounded-xl bg-primary/10 text-primary font-bold text-lg">
                                    {{ user.name?.charAt(0).toUpperCase() }}
                                </AvatarFallback>
                            </Avatar>
                            <div class="flex flex-col">
                                <p class="text-sm font-semibold text-foreground">{{ user.name }}</p>
                                <p class="text-xs text-muted-foreground">{{ user.email }}</p>
                            </div>
                        </div>
                    </DropdownMenuLabel>
                    <DropdownMenuSeparator class="bg-border" />
                    <DropdownMenuGroup>
                        <DropdownMenuItem as-child>
                            <Link
                                :href="profileEdit().url"
                                class="flex items-center gap-3 cursor-pointer px-3 py-2 text-sm text-foreground hover:bg-primary/10 hover:text-primary rounded-lg transition-all duration-200"
                            >
                                <User class="h-4 w-4" />
                                <span>Mon profil</span>
                            </Link>
                        </DropdownMenuItem>
                        <DropdownMenuItem v-if="user.role === 'admin'" as-child>
                            <Link
                                href="/admin"
                                class="flex items-center gap-3 cursor-pointer px-3 py-2 text-sm text-foreground hover:bg-primary/10 hover:text-primary rounded-lg transition-all duration-200"
                            >
                                <Shield class="h-4 w-4" />
                                <span>Administration</span>
                            </Link>
                        </DropdownMenuItem>
                        <DropdownMenuItem as-child>
                            <Link
                                href="/settings"
                                class="flex items-center gap-3 cursor-pointer px-3 py-2 text-sm text-foreground hover:bg-primary/10 hover:text-primary rounded-lg transition-all duration-200"
                            >
                                <Settings class="h-4 w-4" />
                                <span>Paramètres</span>
                            </Link>
                        </DropdownMenuItem>
                    </DropdownMenuGroup>
                    <DropdownMenuSeparator class="bg-border" />
                    <DropdownMenuItem as-child>
                        <Link
                            :href="logout()"
                            method="post"
                            as="button"
                            class="flex items-center gap-3 cursor-pointer px-3 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 rounded-lg transition-all duration-200 dark:hover:bg-red-950/20"
                        >
                            <LogOut class="h-4 w-4" />
                            <span>Déconnexion</span>
                        </Link>
                    </DropdownMenuItem>
                </DropdownMenuContent>
            </DropdownMenu>
        </SidebarMenuItem>
    </SidebarMenu>
</template>
