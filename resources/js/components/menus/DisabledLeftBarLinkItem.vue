<template>
	<li class="px-4">
		<a class="p-2 py-1 cursor-not-allowed rounded-lg text-text-main-400 whitespace-nowrap">
			<MiniIcon :icon="props.icon" :class="'w-3 h-3'" />
			<span class="ml-3 whitespace-nowrap text-base italic line-through">
				{{ trans(props.text) }}
			</span>
		</a>
	</li>
</template>
<script setup lang="ts">
import { trans } from "laravel-vue-i18n";

type LeftBarItemProps = {
	icon: string;
	text: string;
};

const props = defineProps<LeftBarItemProps>();
</script>
