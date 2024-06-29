import Diagnostics from "@/views/Diagnostics.vue";
import Gallery from "@/views/Gallery.vue";
import Jobs from "@/views/Jobs.vue";
import Landing from "@/views/Landing.vue";
import Maintenance from "@/views/Maintenance.vue";
import Profile from "@/views/Profile.vue";
import Settings from "@/views/Settings.vue";
import Sharing from "@/views/Sharing.vue";
import Users from "@/views/Users.vue";

export const routes = [
	{
		name: "landing",
		path: "/",
		component: Landing,
	},
	{
		name: "gallery",
		path: "/gallery",
		component: Gallery,
	},
	{
		name: "diagnostics",
		path: "/diagnostics",
		component: Diagnostics,
	},
	{
		name: "jobs",
		path: "/jobs",
		component: Jobs,
	},
	{
		name: "maintenance",
		path: "/maintenance",
		component: Maintenance,
	},
	{
		name: "profile",
		path: "/profile",
		component: Profile,
	},
	{
		name: "settings",
		path: "/settings",
		component: Settings,
	},
	{
		name: "sharing",
		path: "/sharing",
		component: Sharing,
	},
	{
		name: "users",
		path: "/users",
		component: Users,
	},
];
