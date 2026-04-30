<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { store } from '@/routes/password/confirm';
import { Lock, Shield } from 'lucide-vue-next';

defineOptions({
    layout: {
        title: 'Confirmation requise',
        description: 'Zone sécurisée. Veuillez confirmer votre identité.',
    },
});
</script>

<template>
    <Head title="Confirmer le mot de passe" />

    <div class="space-y-6">
        <!-- Icon -->
        <div class="flex justify-center">
            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-amber-500 to-orange-500 shadow-lg shadow-amber-500/30">
                <Shield class="h-8 w-8 text-white" />
            </div>
        </div>

        <Form v-bind="store.form()" reset-on-success v-slot="{ errors, processing }">
            <div class="space-y-6">
                <div class="space-y-2">
                    <Label for="password" class="text-sm font-semibold text-gray-700 dark:text-gray-300">Mot de passe</Label>
                    <div class="relative">
                        <Lock class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400 transition-colors peer-focus:text-amber-600 dark:peer-focus:text-amber-400" />
                        <PasswordInput
                            id="password"
                            name="password"
                            class="h-11 w-full rounded-xl border-gray-200 bg-white pl-9 transition-all duration-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 dark:border-gray-700 dark:bg-gray-900 dark:focus:border-amber-400"
                            required
                            autocomplete="current-password"
                            autofocus
                            placeholder="Votre mot de passe"
                        />
                    </div>
                    <InputError :message="errors.password" class="text-sm text-red-500 dark:text-red-400" />
                </div>

                <Button
                    type="submit"
                    class="h-11 w-full rounded-xl bg-gradient-to-r from-amber-500 to-orange-500 font-semibold text-white shadow-lg shadow-amber-500/20 transition-all duration-300 hover:shadow-xl hover:shadow-amber-500/30 hover:-translate-y-0.5 disabled:opacity-50"
                    :disabled="processing"
                    data-test="confirm-password-button"
                >
                    <Spinner v-if="processing" class="mr-2 h-4 w-4 animate-spin" />
                    <Shield class="mr-2 h-4 w-4" />
                    Confirmer l'accès
                </Button>
            </div>
        </Form>
    </div>
</template>