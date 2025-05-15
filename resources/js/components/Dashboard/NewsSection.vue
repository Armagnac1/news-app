<template>
  <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
      <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">News Articles</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <NewsCard
          v-for="article in news.data"
          :key="article.id"
          :article="article"
        />
      </div>
      <!-- Pagination -->
      <div class="mt-4">
        <Pagination :links="news.links" />
      </div>
    </div>
  </div>
</template>

<script setup>
import NewsCard from '@/components/NewsCard.vue';
import Pagination from '@/components/Pagination.vue';

defineProps({
  news: {
    type: Object,
    required: true
  }
});
</script> 