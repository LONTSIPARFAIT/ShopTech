<template>
    <div class="group p-6 bg-white/5 backdrop-blur-sm rounded-2xl transition-all duration-300 hover:bg-white/10 hover:-translate-y-1 border border-white/10 hover:border-orange-500/30">
        <!-- Icône -->
        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center mb-4 transition-transform group-hover:scale-110">
            <component :is="icon" class="w-6 h-6 text-white" />
        </div>

        <!-- Titre -->
        <h3 class="text-lg font-bold text-white mb-2 transition-colors group-hover:text-orange-400">
            {{ title }}
        </h3>

        <!-- Description -->
        <p class="text-sm text-slate-300 leading-relaxed">
            {{ description }}
        </p>
    </div>
</template>

<script setup lang="ts">
defineProps<{
    icon: any;
    title: string;
    description: string;
}>();
</script>
