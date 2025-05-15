<script lang="ts" setup>
import { Toaster } from '@/components/ui/sonner';
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';
import { onMounted } from 'vue';
import { toast } from 'vue-sonner';
import { router } from '@inertiajs/vue3';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

interface NewsEvent {
    id: number;
    title: string;
}

interface UserEvent {
    message: string;
}

declare global {
    interface Window {
        Echo: {
            channel(channel: string): {
                listen(event: string, callback: (data: any) => void): void;
            };
        };
    }
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

onMounted(() => {
    // News notifications
    window.Echo.channel('public').listen('.news.created', (e: NewsEvent) => {
        toast(e.title, {
            action: {
                label: 'Read more',
                onClick: () => router.get(route('news.show', e.id))
            },
        });
    });

    // User registration notifications
    window.Echo.channel('public').listen('.user.registered', (e: UserEvent) => {
        toast('New User Registration', {
            description: e.message,
        });
    });

    // User authorization notifications
    window.Echo.channel('public').listen('.user.authorized', (e: UserEvent) => {
        toast('User Login', {
            description: e.message,
        });
    });
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <slot />
        <Toaster closeButton :toastOptions="{ actionButtonStyle: { backgroundColor: 'rgb(219, 239, 255)' } }"/>
    </AppLayout>
</template>
