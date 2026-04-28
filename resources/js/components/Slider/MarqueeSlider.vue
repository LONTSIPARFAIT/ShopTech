<template>
    <div class="relative overflow-hidden w-full group py-4">
        <div class="flex whitespace-nowrap animate-marquee group-hover:pause" :style="{ animationDuration: duration }">
            <!-- First set of items -->
            <div class="flex gap-6 pr-6">
                <div v-for="(item, index) in items" :key="index" :style="{ width: itemWidth }" class="flex-shrink-0">
                    <slot :item="item" />
                </div>
            </div>
            <!-- Duplicate set for infinite effect -->
            <div class="flex gap-6 pr-6">
                <div v-for="(item, index) in items" :key="'dup-'+index" :style="{ width: itemWidth }" class="flex-shrink-0">
                    <slot :item="item" />
                </div>
            </div>
            <!-- Third set to ensure no gaps -->
            <div class="flex gap-6 pr-6">
                <div v-for="(item, index) in items" :key="'dup2-'+index" :style="{ width: itemWidth }" class="flex-shrink-0">
                    <slot :item="item" />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
defineProps<{
    items: any[];
    duration?: string;
    itemWidth?: string;
}>();
</script>

<style scoped>
.animate-marquee {
    display: flex;
    animation: marquee linear infinite;
}

.pause {
    animation-play-state: paused;
}

@keyframes marquee {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-33.333%);
    }
}
</style>
