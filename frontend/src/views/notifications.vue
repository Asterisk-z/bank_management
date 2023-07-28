<template>
  <div>
    <Card bodyClass="px-6 ">
      <Menu as="div" class="-mx-6">
        <div
          class="flex justify-between px-4 py-4 border-b border-slate-100 dark:border-slate-600"
        >
          <div
            class="text-sm text-slate-800 dark:text-slate-200 font-medium leading-6"
          >
            All Notifications 
          </div>
        </div>
        <MenuItem
          v-slot="{ active }"
          v-for="(item, i) in notifications"
          :key="i"
        >
          <div
            :class="`${
              active
                ? 'bg-slate-100 dark:bg-slate-600 dark:bg-opacity-70 text-slate-800'
                : 'text-slate-600 dark:text-slate-300'
            } block w-full px-4 py-2 text-sm mb-2 last:mb-0 cursor-pointer`"
          >
            <div class="flex text-left">
              <div class="flex-none mr-3">
                <div
                  class="h-10 w-10 rounded-full text-sm bg-slate-100 text-slate-900 dark:bg-slate-600 dark:text-slate-200 flex flex-col items-center justify-center font-normal capitalize"
                >
                  {{ Object.keys(item.data)[0] }}
                </div>
              </div>
              <div class="flex-1">
                <div
                  :class="`${
                    active
                      ? 'text-slate-600 dark:text-slate-300'
                      : ' text-slate-600 dark:text-slate-300'
                  } text-sm`"
                >
                  <!-- {{ item.type }} -->
                   {{ Object.values(item.data)[0] }}
                </div>
                
                <div class="text-secondary-500 dark:text-slate-400 text-xs">
                  {{ format_date(item.created_at) }}
                </div>
              </div>
              <!-- <div class="flex-0" v-if="item.unread">
                <span
                  class="h-[10px] w-[10px] bg-danger-500 border border-white rounded-full inline-block"
                >
                </span>
              </div> -->
            </div>
          </div>
        </MenuItem>
      </Menu>
    </Card>
  </div>
</template>

<script>
import { MenuItem, Menu } from '@headlessui/vue';
import { notifications } from '@/constant/data';
import Card from '@/components/Card';
import axios from 'axios';
import moment from 'moment';

export default {
  components: {
    MenuItem,
    Menu,
    Card,
  },
  data() {
    return {
      notifications: ""

    };
  },
  
  mounted() {
    const $this = this
    axios.post(`${import.meta.env.VITE_APP_API_URL}/customer/all_notifications`, {}, {
      headers: {
        "Authorization": "Bearer " + this.$store.authStore.user.token
      }
    }).then(function (response) {

      if (response.data?.status) {
        $this.notifications = response.data?.notifications
      } else {
        let message = response.data?.message[0];
        toast.error(message, {
          timeout: 4000,
        });
      }
    });
  },
  methods: {

        format_date(value) {
            return moment(value).format("Do-MMM-YYYY hh:mm A");
        },
  }
};
</script>
<style lang=""></style>
