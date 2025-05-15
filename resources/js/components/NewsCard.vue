<template>
  <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
      <div class="flex items-center justify-between mb-4">
        <span class="text-sm text-gray-500 dark:text-gray-400">{{ article.source.label }}</span>
        <span class="text-sm text-gray-500 dark:text-gray-400">
          {{ new Date(article.published_at).toLocaleDateString() }}
        </span>
      </div>
      <h3 class="text-xl font-semibold mb-2">
        <Link :href="route('news.show', article.id)" class="text-gray-900 dark:text-gray-100 hover:text-blue-600 dark:hover:text-blue-400">
          {{ article.title }}
        </Link>
      </h3>
      <p class="text-gray-600 dark:text-gray-300 mb-4">{{ article.summary }}</p>
      <div class="flex justify-between items-center">
        <Link
          :href="route('news.show', article.id)"
          class="text-blue-500 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300"
        >
          Read more
        </Link>
        <a
          v-if="article.url"
          :href="article.url"
          target="_blank"
          class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300"
        >
          Original source
        </a>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
  article: {
    type: Object,
    required: true
  }
});
</script> 