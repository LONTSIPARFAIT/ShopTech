<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { Users, Search, Mail, Calendar, Shield, Trash2 } from 'lucide-vue-next';
import { updateRole as admin_users_updateRole, destroy as admin_users_destroy } from '@/routes/admin/users';

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

const updateRole = (id: number, role: string) => {
    router.put(admin_users_updateRole(id).url, { role }, { preserveScroll: true });
};

const deleteUser = (id: number) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
        router.delete(admin_users_destroy(id).url, { preserveScroll: true });
    }
};
</script>

<template>
    <Head title="Utilisateurs - Admin" />

    <div class="admin-users">
        <div class="admin-header">
            <div>
                <h1 class="admin-title">Utilisateurs</h1>
                <p class="admin-subtitle">Gérez les comptes utilisateurs de la plateforme</p>
            </div>
            <div class="admin-stats-badge">
                <Users class="w-4 h-4" />
                <span>{{ users.length }} utilisateurs</span>
            </div>
        </div>

        <!-- Search -->
        <div class="admin-search-bar">
            <Search class="admin-search-icon" />
            <input 
                v-model="search"
                type="text" 
                placeholder="Rechercher un utilisateur..."
                class="admin-search-input"
            />
        </div>

        <!-- Users Grid -->
        <div v-if="filteredUsers.length === 0" class="admin-empty">
            <Users class="w-12 h-12" />
            <h3>Aucun utilisateur trouvé</h3>
            <p>Aucun résultat pour cette recherche</p>
        </div>

        <div v-else class="admin-users-grid">
            <div v-for="user in filteredUsers" :key="user.id" class="admin-user-card">
                <div class="admin-user-header">
                    <div class="admin-user-avatar" :class="{ 'admin-user-avatar-admin': user.role === 'admin' }">
                        {{ user.name.charAt(0).toUpperCase() }}
                    </div>
                    <div class="admin-user-role">
                        <select 
                            :value="user.role"
                            @change="updateRole(user.id, ($event.target as HTMLSelectElement).value)"
                            class="admin-role-select"
                            :class="user.role === 'admin' ? 'admin-role-admin' : 'admin-role-client'"
                        >
                            <option value="client">Client</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                
                <div class="admin-user-info">
                    <div class="admin-user-name">{{ user.name }}</div>
                    <div class="admin-user-email">
                        <Mail class="w-3.5 h-3.5" />
                        {{ user.email }}
                    </div>
                </div>
                
                <div class="admin-user-footer">
                    <div class="admin-user-orders">
                        <span class="admin-user-orders-count">{{ user.orders_count }}</span>
                        <span>commandes</span>
                    </div>
                    <div class="admin-user-date">
                        <Calendar class="w-3.5 h-3.5" />
                        {{ new Date(user.created_at).toLocaleDateString() }}
                    </div>
                    <button @click="deleteUser(user.id)" class="admin-user-delete">
                        <Trash2 class="w-4 h-4" />
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>