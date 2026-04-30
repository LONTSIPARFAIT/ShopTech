<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Spinner } from '@/components/ui/spinner';
import { logout } from '@/routes';
import { send } from '@/routes/verification';
import { MailCheck, LogOut, Sparkles } from 'lucide-vue-next';

defineOptions({
    layout: {
        title: 'Vérifiez votre email',
        description: 'Activez votre compte pour profiter de tous nos services',
    },
});

defineProps<{
    status?: string;
}>();
</script>

<template>
    <Head title="Vérification email" />

    <div class="space-y-6 text-center">
        <!-- Success Message -->
        <div v-if="status === 'verification-link-sent'" class="flex items-center justify-center gap-2 rounded-xl bg-green-50 p-3 text-sm font-medium text-green-700 dark:bg-green-950/20 dark:text-green-400 border border-green-200 dark:border-green-800/30">
            <Sparkles class="h-4 w-4" />
            ✅ Un nouveau lien de vérification a été envoyé à votre adresse email
        </div>

        <!-- Icon -->
        <div class="flex justify-center">
            <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 shadow-lg shadow-blue-500/30">
                <MailCheck class="h-10 w-10 text-white" />
            </div>
        </div>

        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Vérifiez votre boîte de réception</h3>
        
        <p class="text-gray-500 dark:text-gray-400">
            Un email de vérification a été envoyé à votre adresse.<br>
            Cliquez sur le lien dans l'email pour activer votre compte.
        </p>

        <Form v-bind="send.form()" class="space-y-4" v-slot="{ processing }">
            <Button :disabled="processing" variant="outline" class="w-full rounded-xl border-gray-200 bg-white font-medium transition-all hover:border-blue-300 hover:bg-blue-50 dark:border-gray-700 dark:bg-gray-900 dark:hover:border-blue-700 dark:hover:bg-blue-950/30">
                <Spinner v-if="processing" class="mr-2 h-4 w-4 animate-spin" />
                Renvoyer l'email de vérification
            </Button>

            <TextLink :href="logout()" as="button" class="flex items-center justify-center gap-2 text-sm text-gray-500 transition-colors hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400">
                <LogOut class="h-4 w-4" />
                Se déconnecter
            </TextLink>
        </Form>
    </div>
</template>