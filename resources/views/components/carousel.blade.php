<div x-data="carousel()" {{
    $attributes->class([
        'relative w-full' 
    ])
}}
{{-- class="relative w-full" --}}
>
    <!-- Carousel wrapper -->
    <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
        <!-- Carousel Slot -->
        <div x-ref="slides" class="flex" x-show="initialized" x-transition>
            {{ $slot }}
        </div>
    </div>

    <!-- Slider indicators -->
    <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 justify-between gap-4 rtl:space-x-reverse">
        <template x-for="(slide, index) in slidesCount" :key="index">
            <button
                @click="goToSlide(index)"
                :class="{'bg-primary-600/90 dark:bg-primary-400': current === index, 'bg-gray-300': current !== index}"
                class="w-3 h-3 rounded-full"
                :aria-label="'Slide ' + (index + 1)">
            </button>
        </template>
    </div>

    <!-- Slider controls -->
    <button @click="prev" type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-primary-600/90 dark:bg-primary-400 group-hover:bg-primary-700/90 dark:group-hover:bg-primary-500 group-focus:ring-4 group-focus:ring-primary-300 dark:group-focus:ring-primary-500">
            <x-heroicon-s-chevron-left class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" />
            <span class="sr-only">Previous</span>
        </span>
    </button>
    <button @click="next" type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-primary-600/90 dark:bg-primary-400 group-hover:bg-primary-700/90 dark:group-hover:bg-primary-500 group-focus:ring-4 group-focus:ring-primary-300 dark:group-focus:ring-primary-500">
            <x-heroicon-s-chevron-right class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" />
            <span class="sr-only">Next</span>
        </span>
    </button>
</div>

<script>
    function carousel() {
        return {
            current: 0,
            initialized: false,
            slidesCount: 0,
            init() {
                this.slidesCount = this.$refs.slides.children.length;
                this.initialized = true;
            },
            next() {
                this.current = (this.current + 1) % this.slidesCount;
            },
            prev() {
                this.current = (this.current - 1 + this.slidesCount) % this.slidesCount;
            },
            goToSlide(index) {
                this.current = index;
            }
        };
    }
</script>

