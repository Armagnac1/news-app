<template>
    <AppLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Search Bar -->
                <div class="mb-8">
                    <div class="max-w-xl mx-auto">
                        <div class="relative">
                            <input
                                v-model="search"
                                type="text"
                                placeholder="Search news..."
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                @input="debouncedSearch"
                            />
                            <div v-if="loading" class="absolute right-3 top-2">
                                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-500"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- News Grid -->
                <NewsSection :news="news" />
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, watch, onUnmounted } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import debounce from 'lodash/debounce';
import axios from 'axios';
import NewsSection from '@/components/Dashboard/NewsSection.vue';

const props = defineProps({
    news: {
        type: Object,
        required: true,
    },
});

const search = ref('');
const loading = ref(false);
const news = ref(props.news);
const currentPage = ref(1);

const performSearch = async (page = 1) => {
    if (search.value.length >= 3) {
        loading.value = true;
        try {
            const response = await axios.get(route('news.search'), {
                params: { 
                    query: search.value,
                    page: page
                }
            });
            news.value = response.data;
            currentPage.value = page;
        } catch (error) {
            console.error('Search failed:', error);
            // Optionally, show a user-friendly error message here
        } finally {
            loading.value = false;
        }
    } else if (search.value.length === 0) {
        news.value = props.news;
        currentPage.value = 1;
    }
};

const debouncedSearch = debounce(() => performSearch(1), 300);

watch(search, (newValue) => {
    if (newValue.length < 3) {
        news.value = props.news;
        currentPage.value = 1;
    }
});

onUnmounted(() => {
    debouncedSearch.cancel();
});
</script>
