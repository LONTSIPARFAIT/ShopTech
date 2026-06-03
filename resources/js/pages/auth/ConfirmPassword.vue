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
            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-primary to-primary-dark shadow-lg shadow-primary/30">
                <Shield class="h-8 w-8 text-white" />
            </div>
        </div>

        <Form v-bind="store.form()" reset-on-success v-slot="{ errors, processing }">
            <div class="space-y-6">
                <div class="space-y-2">
                    <Label for="password" class="text-sm font-semibold text-foreground">Mot de passe</Label>
                    <div class="relative">
                        <Lock class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground transition-colors peer-focus:text-primary" />
                        <PasswordInput
                            id="password"
                            name="password"
                            class="h-11 w-full rounded-xl bg-secondary border-border pl-9 transition-all duration-200 focus:border-primary focus:ring-2 focus:ring-primary/20"
                            required
                            autocomplete="current-password"
                            autofocus
                            placeholder="Votre mot de passe"
                        />
                    </div>
                    <InputError :message="errors.password" />
                </div>

                <Button
                    type="submit"
                    class="h-11 w-full rounded-xl bg-gradient-to-r from-primary to-primary-dark font-semibold text-white shadow-lg shadow-primary/20 transition-all duration-300 hover:shadow-xl hover:shadow-primary/30 hover:-translate-y-0.5 disabled:opacity-50"
                    :disabled="processing"
                >
                    <Spinner v-if="processing" class="mr-2 h-4 w-4 animate-spin" />
                    <Shield class="mr-2 h-4 w-4" />
                    Confirmer l'accès
                </Button>
            </div>
        </Form>
    </div>
</template>
