<template>
    <div class="space-y-4 p-8 bg-white/5 backdrop-blur-xl rounded-[2rem] border border-white/10 hover:bg-white/10 transition-colors">
        <component :is="icon" :class="`w-10 h-10 text-${iconColor}-500`" />
        <h3 class="text-xl font-black uppercase italic">{{ title }}</h3>
        <p class="text-slate-400 text-sm font-medium">{{ description }}</p>
    </div>
</template>

<script setup lang="ts">
defineProps<{
    icon: any;
    iconColor: string;
    title: string;
    description: string;
}>();
</script>