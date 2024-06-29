<template>
	<ul class="space-y-0.5" v-if="loaded">
		<!-- <LeftBarLinkItem icon="chevron-left" text="lychee.CLOSE" /> -->
		<!-- <x-leftbar.leftbar-item x-on:click="leftMenuOpen = ! leftMenuOpen" icon="chevron-left">
			{{ __('lychee.CLOSE') }}
		</x-leftbar.leftbar-item> -->
		<LeftBarLinkItem icon="cog" text="lychee.SETTINGS" v-if="initData.rights.settings.can_edit" to="/settings" />
		<LeftBarLinkItem icon="person" text="lychee.PROFILE" v-if="initData.rights.user.can_edit" to="/profile" />
		<LeftBarLinkItem icon="people" text="lychee.USERS" v-if="initData.rights.user_management.can_edit" to="/users" />
		<LeftBarLinkItem icon="key" text="lychee.U2F" v-if="initData.rights.user.can_edit" to="/profile" />
		<LeftBarLinkItem icon="cloud" text="lychee.SHARING" v-if="initData.rights.root_album.can_upload" to="/sharing" />
		<template v-if="logsEnabled">
			<LeftBarRealLinkItem icon="excerpt" text="lychee.LOGS" v-if="initData.rights.settings.can_see_logs" to="/logs" />
		</template>
		<template v-if="!logsEnabled">
			<DisabledLeftBarLinkItem icon="excerpt" text="lychee.LOGS" v-if="initData.rights.settings.can_see_logs" />
		</template>
		<LeftBarLinkItem icon="project" text="lychee.JOBS" v-if="initData.rights.settings.can_see_logs" to="/jobs" />
		<LeftBarLinkItem icon="wrench" text="lychee.DIAGNOSTICS" v-if="initData.rights.settings.can_see_diagnostics" to="/diagnostics" />
		<LeftBarLinkItem icon="timer" text="lychee.DIAGNOSTICS" v-if="initData.rights.settings.can_edit" to="/maintenance" />
		<!-- <x-leftbar.leftbar-item wire:click="openAboutModal" icon="info">
			{{ __('lychee.ABOUT_LYCHEE') }}
		</x-leftbar.leftbar-item> -->
		<!-- <x-leftbar.leftbar-item wire:click="logout" icon="account-logout">
			{{ __('lychee.SIGN_OUT') }}
		</x-leftbar.leftbar-item> -->
		<template v-if="hasDevTools">
			<LeftBarHeader>Dev Tools</LeftBarHeader>
			<LeftBarRealLinkItem icon="telescope" text="Clockwork App" v-if="initData.rights.settings.can_edit" :to="clockwork_url" />
			<LeftBarRealLinkItem icon="document" text="Api Documentation" v-if="initData.rights.settings.can_edit" :to="doc_api_url" />
		</template>
	</ul>
</template>
<script setup lang="ts">
import DisabledLeftBarLinkItem from '@/components/menus/DisabledLeftBarLinkItem.vue';
import LeftBarHeader from '@/components/menus/LeftBarHeader.vue';
import LeftBarLinkItem from '@/components/menus/LeftBarLinkItem.vue';
import LeftBarRealLinkItem from '@/components/menus/LeftBarRealLinkItem.vue';
import { InitializationData } from '@/lycheeOrg/backend';
import InitService from '@/services/init-service';
import { Ref, ref } from 'vue';

const loaded = ref(false);
const initData = ref(undefined) as Ref<undefined | InitializationData>

const clockwork_url = ref('/clockwork/app');
const doc_api_url = ref('/api/documentation');
const hasDevTools = ref(true);
const logsEnabled = ref(true);

InitService.fetchInitData().then((data) => {
	initData.value = data.data;
	loaded.value = true;
}).catch((error) => {
	console.error(error);
});
</script>