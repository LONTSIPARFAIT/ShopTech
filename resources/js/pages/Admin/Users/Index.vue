<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { Users, Shield, ShoppingBag, Calendar, Search, Mail } from 'lucide-vue-next';

const props = defineProps<{
    users: Array<{
        id: number;
        name: string;
        email: string;
        role: string;
        created_at: string;
        orders_count: number;
    }>;
}>();

const search = ref('');

const filteredUsers = computed(() => {
    if (!search.value) return props.users;
    const q = search.value.toLowerCase();
    return props.users.filter(u => 
        u.name.toLowerCase().includes(q) || u.email.toLowerCase().includes(q)
    );
});

const roleLabel = (role: string) => {
    return role === 'admin' ? 'Administrateur' : 'Client';
};
</script>

<template>
    <Head title="Gestion des Utilisateurs - Admin" />

    <div class="p-6 lg:p-12 space-y-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-1">
                <h1 class="text-3xl font-black tracking-tight">Utilisateurs</h1>
                <p class="text-slate-500">Gérez les comptes utilisateurs de la plateforme.</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="relative">
                    <Search class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" />
                    <input 
                        v-model="search"
                        type="text" 
                        placeholder="Rechercher un utilisateur..."
                        class="pl-11 pr-6 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all w-72"
                    />
                </div>
                <div class="flex items-center gap-2 px-4 py-3 bg-blue-50 dark:bg-blue-900/20 text-blue-600 rounded-2xl text-sm font-bold">
                    <Users class="w-4 h-4" />
                    {{ users.length }} utilisateurs
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50">
                            <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-slate-400">Utilisateur</th>
                            <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-slate-400">Email</th>
                            <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-slate-400">Rôle</th>
                            <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-slate-400">Commandes</th>
                            <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-slate-400">Inscription</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        <tr v-for="user in filteredUsers" :key="user.id" class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors group">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div 
                                        class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-bold text-sm flex-shrink-0"
                                        :class="user.role === 'admin' ? 'bg-purple-600' : 'bg-blue-600'"
                                    >
                                        {{ user.name.charAt(0).toUpperCase() }}
                                    </div>
                                    <div class="font-bold">{{ user.name }}</div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-2 text-sm text-slate-500">
                                    <Mail class="w-3.5 h-3.5" />
                                    {{ user.email }}
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <span 
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest"
                                    :class="user.role === 'admin' 
                                        ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400' 
                                        : 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400'"
                                >
                                    <Shield class="w-3 h-3" />
                                    {{ roleLabel(user.role) }}
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-2 text-sm font-bold">
                                    <ShoppingBag class="w-4 h-4 text-slate-400" />
                                    {{ user.orders_count }}
                                </div>
                            </td>
                            <td class="px-8 py-5 text-sm text-slate-400">
                                <div class="flex items-center gap-2">
                                    <Calendar class="w-3.5 h-3.5" />
                                    {{ new Date(user.created_at).toLocaleDateString('fr-FR', { day: 'numeric', month: 'short', year: 'numeric' }) }}
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-if="filteredUsers.length === 0" class="p-24 text-center space-y-4">
                <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto text-slate-300">
                    <Users class="w-10 h-10" />
                </div>
                <h3 class="text-xl font-bold">Aucun utilisateur trouvé</h3>
                <p class="text-slate-500">Aucun résultat pour cette recherche.</p>
            </div>
        </div>
    </div>
</template>
