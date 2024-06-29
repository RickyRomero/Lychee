<template>
	<li class="px-4">
		<a class="p-2 py-1 cursor-pointer rounded-lg text-text-main-400 hover:text-text-main-100 whitespace-nowrap" :href="to">
			<MiniIcon :icon="props.icon" :class="'w-3 h-3'" />
			<span class="ml-3 whitespace-nowrap text-base">
				{{ trans(props.text) }}
			</span>
		</a>
	</li>
</template>
<script setup lang="ts">
import { trans } from 'laravel-vue-i18n';


type LeftBarItemProps = {
	icon: string;
	text: string;
	to: string;
};

const props = defineProps<LeftBarItemProps>()
</script>
