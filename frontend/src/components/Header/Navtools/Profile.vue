<template>
  <Dropdown classMenuItems=" w-[180px] top-[58px] ">
    <div class="flex items-center">
      <div class="flex-1 ltr:mr-[10px] rtl:ml-[10px]">
        <div class="lg:h-8 lg:w-8 h-7 w-7 rounded-full">
            <img v-if="this.$store.authStore.user.user.profile_picture"
              :src="app_url + '/uploads/profile_photo/' + this.$store.authStore.user.user.profile_picture" alt=""
              class="block w-full h-full object-cover rounded-full" />
            <img v-else src="@/assets/images/users/default.jpg" alt="" class="block w-full h-full object-cover rounded-full" />
        </div>
      </div>
      <div
        class="flex-none text-slate-600 dark:text-white text-sm font-normal items-center lg:flex hidden overflow-hidden text-ellipsis whitespace-nowrap"
      >
        <span class="overflow-hidden text-ellipsis whitespace-nowrap w-[85px] block">{{ this.$store.authStore.user.user.name }}</span>
        <span class="text-base inline-block ltr:ml-[10px] rtl:mr-[10px]"
          ><Icon icon="heroicons-outline:chevron-down"></Icon
        ></span>
      </div>
    </div>
    
    <template #menus>

        <MenuItem v-if="this.$store.authStore.user.user.user_type == 'customer'">
          <div
            type="button"
            :class="`${ 'text-slate-600 dark:text-slate-300' } `"
            class="inline-flex items-center space-x-2 rtl:space-x-reverse w-full px-4 py-2 first:rounded-t last:rounded-b font-normal cursor-pointer"
            @click="profile"
          >
            <div class="flex-none text-lg">
              <Icon :icon="'heroicons-outline:user'" />
            </div>
            <div class="flex-1 text-sm">
              {{'Profile' }}
            </div>
          </div>
        </MenuItem>
      <MenuItem v-slot="{ active }" v-for="(item, i) in ProfileMenu" :key="i">
        <div
          type="button"
          :class="`${
            active
              ? 'bg-slate-100 dark:bg-slate-700 dark:bg-opacity-70 text-slate-900 dark:text-slate-300'
              : 'text-slate-600 dark:text-slate-300'
          } `"
          class="inline-flex items-center space-x-2 rtl:space-x-reverse w-full px-4 py-2 first:rounded-t last:rounded-b font-normal cursor-pointer"
          @click="item.link()"
        >
          <div class="flex-none text-lg">
            <Icon :icon="item.icon" />
          </div>
          <div class="flex-1 text-sm">
            {{ item.label }}
          </div>
        </div>
      </MenuItem>
    </template>
  </Dropdown>
</template>
<script>
import { MenuItem } from "@headlessui/vue";
import Dropdown from "@/components/Dropdown";
import Icon from "@/components/Icon";
import profileImg from "@/assets/images/users/default.jpg"
export default {
  components: {
    Icon,
    Dropdown,
    MenuItem,
  },
  data() {
    return {
      profileImg,
      app_url: import.meta.env.VITE_APP_API_BASEURL,
      ProfileMenu: [
        // {
        //   label: "Profile",
        //   icon: "heroicons-outline:user",
        //   link: () => {
        //     this.$router.push({ name: "user-profile" });
        //   },
        // },
        {
          label: "Logout",
          icon: "heroicons-outline:login",
          link: () => {
            localStorage.removeItem("activeUser");
            this.$router.push("/");
          },
        },
      ],
    };
  },
  methods: {
    profile() {
        this.$router.push({ name: "user-profile" });
    }
  }
};
</script>
<style lang=""></style>
