<template>
  <AppLayout>
    <div class="py-12">
      <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-neutral-700 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6">
            <!-- Article Header -->
            <div class="mb-8">
              <div class="flex items-center justify-between mb-4">
                <span class="text-sm text-gray-500">{{ article.source.name }}</span>
                <span class="text-sm text-gray-500">
                  {{ new Date(article.published_at).toLocaleDateString() }}
                </span>
              </div>
              <h1 class="text-3xl font-bold mb-4">{{ article.title }}</h1>
              <p class="text-gray-500 dark:text-gray-400 text-lg mb-6">{{ article.summary }}</p>
            </div>

            <!-- Article Image -->
            <div v-if="article.image_url" class="mb-8">
              <img
                :src="article.image_url"
                :alt="article.title"
                class="w-full h-auto rounded-lg"
              />
            </div>

            <!-- Article Content -->
            <div class="prose max-w-none mb-8">
              {{ article.content }}
            </div>

            <!-- Article Footer -->
            <div class="border-t pt-6">
              <div class="flex justify-between items-center">
                <Link
                  :href="route('news.index')"
                  class="text-blue-500 hover:text-blue-700"
                >
                  Back to News
                </Link>
                <a
                  v-if="article.url"
                  :href="article.url"
                  target="_blank"
                  class="text-gray-500 hover:text-gray-700"
                >
                  Read original article
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';

defineProps({
  article: {
    type: Object,
    required: true,
  },
});
</script>
