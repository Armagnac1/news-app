<template>
  <AppLayout>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-8">
          <button
            @click="updateAllSources"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg transition-colors flex items-center"
            :class="{
              'hover:bg-blue-700': !isUpdating,
              'opacity-75 cursor-not-allowed': isUpdating
            }"
            :disabled="isUpdating"
          >
            <Loader2 v-if="isUpdating" class="w-4 h-4 mr-2 animate-spin" />
            {{ isUpdating ? 'Updating...' : 'Update All News Sources' }}
          </button>
        </div>

        <!-- Verified Users -->
        <UsersTable
          title="Verified Users"
          :users="verifiedUsers"
          date-column="Verified At"
          date-field="telegram_verified_at"
        />

        <!-- Incomplete Registrations -->
        <UsersTable
          title="Incomplete Registrations"
          :users="incompleteUsers"
          date-column="Registered At"
          date-field="created_at"
        />

        <!-- Verification Codes -->
        <VerificationCodesTable :codes="verificationCodes" />

        <!-- News Articles -->
        <NewsSection :news="news" />
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import StatsCard from '@/Components/Dashboard/StatsCard.vue';
import UsersTable from '@/Components/Dashboard/UsersTable.vue';
import VerificationCodesTable from '@/Components/Dashboard/VerificationCodesTable.vue';
import NewsSection from '@/Components/Dashboard/NewsSection.vue';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { Loader2 } from 'lucide-vue-next';

const isUpdating = ref(false);

const updateAllSources = async () => {
  isUpdating.value = true;
  try {
    await router.post(route('admin.news.update-all-sources'));
  } catch (error) {
    console.error('Failed to update all sources:', error);
  } finally {
    isUpdating.value = false;
  }
};

defineProps({
  verifiedUsers: {
    type: Array,
    required: true,
  },
  incompleteUsers: {
    type: Array,
    required: true,
  },
  verificationCodes: {
    type: Object,
    required: true,
  },
  news: {
    type: Object,
    required: true,
  }
});
</script>
