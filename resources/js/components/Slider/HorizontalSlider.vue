<template>
    <div class="relative group">
        <!-- Navigation Buttons -->
        <button
            @click="scrollLeft"
            class="absolute left-0 top-1/2 -translate-y-1/2 z-10 w-10 h-10 rounded-full bg-white dark:bg-gray-800 shadow-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 hover:scale-110 disabled:opacity-30 disabled:cursor-not-allowed"
            :disabled="scrollPosition <= 0"
        >
            <ChevronLeft class="w-5 h-5" />
        </button>

        <button
            @click="scrollRight"
            class="absolute right-0 top-1/2 -translate-y-1/2 z-10 w-10 h-10 rounded-full bg-white dark:bg-gray-800 shadow-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 hover:scale-110 disabled:opacity-30 disabled:cursor-not-allowed"
            :disabled="scrollPosition >= maxScroll"
        >
            <ChevronRight class="w-5 h-5" />
        </button>

        <!-- Slider Track -->
        <div
            ref="sliderRef"
            class="flex gap-5 overflow-x-auto scroll-smooth snap-x snap-mandatory scrollbar-hide"
            @scroll="handleScroll"
        >
            <div
                v-for="(item, index) in items"
                :key="item.id"
                class="flex-shrink-0 snap-start"
                :style="{ width: cardWidth }"
            >
                <slot :item="item" :index="index" />
            </div>
        </div>

        <!-- Scroll Progress Indicator -->
        <div v-if="showProgress" class="mt-4 h-1 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
            <div
                class="h-full bg-blue-600 rounded-full transition-all duration-300"
                :style="{ width: `${scrollProgress}%` }"
            ></div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted, computed } from 'vue';
import { ChevronLeft, ChevronRight } from 'lucide-vue-next';

const props = defineProps<{
    items: any[];
    cardWidth?: string;
    showProgress?: boolean;
}>();

const sliderRef = ref<HTMLDivElement | null>(null);
const scrollPosition = ref(0);
const maxScroll = ref(0);

const handleScroll = () => {
    if (sliderRef.value) {
        scrollPosition.value = sliderRef.value.scrollLeft;
        maxScroll.value = sliderRef.value.scrollWidth - sliderRef.value.clientWidth;
    }
};

const scrollLeft = () => {
    if (sliderRef.value) {
        sliderRef.value.scrollBy({ left: -300, behavior: 'smooth' });
    }
};

const scrollRight = () => {
    if (sliderRef.value) {
        sliderRef.value.scrollBy({ left: 300, behavior: 'smooth' });
    }
};

const scrollProgress = computed(() => {
    if (maxScroll.value === 0) return 0;
    return (scrollPosition.value / maxScroll.value) * 100;
});

let resizeObserver: ResizeObserver | null = null;

onMounted(() => {
    if (sliderRef.value) {
        handleScroll();
        resizeObserver = new ResizeObserver(() => handleScroll());
        resizeObserver.observe(sliderRef.value);
    }
});

onUnmounted(() => {
    if (resizeObserver && sliderRef.value) {
        resizeObserver.unobserve(sliderRef.value);
    }
});
</script>

<style scoped>
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
.snap-x {
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
}
.snap-start {
    scroll-snap-align: start;
}
</style>