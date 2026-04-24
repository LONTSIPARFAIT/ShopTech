<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import { admin_debug } from '@/routes';

const page = usePage();
const user = page.props.auth.user;
</script>

<template>
    <Head title="Test Role" />

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold mb-4">Test des Rôles</h1>
                    
                    <div class="mb-6 p-4 bg-gray-100 rounded dark:bg-gray-700">
                        <p class="text-lg">
                            Bonjour, <strong>{{ user.name }}</strong>
                        </p>
                        <p class="mt-2">
                            Votre rôle actuel est : <span class="px-2 py-1 bg-blue-500 text-white rounded text-sm">{{ user.role }}</span>
                        </p>
                    </div>

                    <div class="flex gap-4">
                        <a 
                            :href="admin_debug()"
                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition"
                        >
                            Tester l'accès Admin
                        </a>
                        
                        <a 
                            href="/client/debug"
                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition"
                        >
                            Tester l'accès Client
                        </a>
                    </div>

                    <p class="mt-4 text-sm text-gray-500 italic">
                        Note: Si vous n'avez pas le rôle requis, vous recevrez une erreur 403.
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
