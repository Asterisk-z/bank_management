<template>
  <div class="h-full p-6" data-simplebar v-if="ticket">
    <h4 class="text-xl text-slate-900 font-medium mb-8">Ticket Details</h4>
    <div class="h-[100px] w-[100px] rounded-full mx-auto mb-4">
      <img :src="ticket.user.profile_picture" v-if="ticket.user.profile_picture" alt=""  class="block w-full h-full object-cover rounded-full" />
      <img :src="auth.defaultImage" alt=""  class="block w-full h-full object-cover rounded-full" />
    </div>
    <div class="text-center">
      <h5 class="text-base text-slate-600 dark:text-slate-300 font-medium mb-1">
        {{ ticket.user.name }}
      </h5>
      <h6 class="text-xs text-slate-600 dark:text-slate-300 font-normal">
        {{ ticket.user.email }}
      </h6>
    </div>
    <ul
      class="list-item mt-5 space-y-4 border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6"
    >
      <li
        class="flex justify-between text-sm text-slate-600 dark:text-slate-300 leading-[1]"
      >
        <div class="flex space-x-2 items-start rtl:space-x-reverse">
          <span>Subject</span>
        </div>
        <div class="font-medium">{{ ticket.subject }}</div>
      </li>
      <li
        class="flex justify-between text-sm text-slate-600 dark:text-slate-300 leading-[1]"
      >
        <div class="flex space-x-2 items-start rtl:space-x-reverse">
          <span>Description</span>
        </div>
        <div class="font-medium">{{ ticket.description }}</div>
      </li>
    </ul>
    <h4 class="py-4 text-sm text-secondary-500 dark:text-slate-300 font-normal">
      Attachment
    </h4>
    <ul class="grid grid-cols-3 gap-2" v-if="ticket.attachment">
      <li class="h-[100px">
        <img
          :src="app_url + '/uploads/support_ticket/'+ticket.attachment"
          alt=""
          class="w-full h-full object-cover rounded-[3px]"
        />
      </li>
    </ul>
    
    <button class="btn btn-danger float-right" v-if="ticket.status != 'closed'" @click="closeticket">Close ticket</button>
  </div>
</template>
<script setup>
import Icon from "@/components/Icon";
import { computed, ref, onMounted } from "vue";

import axios from 'axios'
import { useRouter, useRoute } from 'vue-router'
import { useToast } from "vue-toastification";
import { useAuthStore } from '@/store/authUser';

const toast = useToast();
const router = useRouter()
const route = useRoute()
const auth = useAuthStore()
const app_url = import.meta.env.VITE_APP_API_BASEURL;

const user = computed(() => store.user);

onMounted(() => {
  getTicket()
});

const ticket = ref()



const getTicket = async () => {
  let id = route.params.ticket_id;
  ticket.value = await axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/single_chat_ticket_detail`, {
    id: id,
  }, {
    headers: {
      "Authorization": "Bearer " + auth.user.token
    }
  }).then(function (response) {

    if (response.data?.status) {

      return response.data?.ticket

    } else {

    }
  }).catch(function (error) {
    console.log(error)
    if (error.response?.data?.error == 'Unauthorized') {
      toast.error("Session Expired", {
        timeout: 3000,
      });
      router.push({ name: 'Login' })
    }
    toast.error(error, {
      timeout: 4000,
    });
  });
};

const closeticket = async () => {
   toast.info("Closing", {
    timeout: 4000,
  });
  let id = route.params.ticket_id;
  ticket.value = await axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/close_ticket`, {
    ticket_id: id,
  }, {
    headers: {
      "Authorization": "Bearer " + auth.user.token
    }
  }).then(function (response) {

    if (response.data?.status) {
      router.push({name: 'admin-all-tickets'})
    } else {

    }
  }).catch(function (error) {
    if (error.response?.data?.error == 'Unauthorized') {
      toast.error("Session Expired", {
        timeout: 3000,
      });
      router.push({ name: 'Login' })
    }

    toast.error(error, {
      timeout: 4000,
    });
  });
};
</script>
<style lang=""></style>
