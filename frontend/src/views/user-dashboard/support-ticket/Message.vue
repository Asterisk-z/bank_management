<template>
  <div class="h-full">
    <header class="border-b border-slate-100 dark:border-slate-700">
      <div class="flex py-6 md:px-6 px-3 items-center">
        <div class="flex-1">
          <div class="flex space-x-3 rtl:space-x-reverse">
            
            <div class="flex-1 text-start">
              <span class="block text-slate-800 dark:text-slate-300 text-lg font-medium mb-[2px] truncate">{{ "Chat User" }}</span>
            </div>
          </div>
        </div>
      </div>
    </header>
    <div class="chat-content parent-height">
      <div class="msgs overflow-y-auto msg-height pt-6 space-y-6" ref="chatheight">
        <div class="block md:px-6 px-4" v-for="(item, i) in userData" :key="i">

          <div class="flex space-x-2 items-start group rtl:space-x-reverse" v-if="item.sender_id !== auth.user.user.id">
            <div class="flex-none">
              <div class="h-8 w-8 rounded-full">
                <img :src="item.profile_picture" alt="" class="block w-full h-full object-cover rounded-full" v-if="item.profile_picture"/>
                <img :src="auth.defaultImage" alt="" class="block w-full h-full object-cover rounded-full" v-else/>
              </div>

            </div>
            <div class="flex-1 flex space-x-4 rtl:space-x-reverse">
              <div>
                
                <!-- <span class="font-normal text-xs text-slate-400 dark:text-slate-400">{{ item.name }}</span> -->
                <div class="text-contrent p-3 bg-slate-100 dark:bg-slate-600 dark:text-slate-300 text-slate-600 text-sm font-normal mb-1 rounded-md flex-1 whitespace-pre-wrap break-all">
                  {{ item.message }}
                </div>
                <span class="font-normal text-xs text-slate-400 dark:text-slate-400">{{ time(item.created_at) }}</span>
              </div>
            </div>
          </div>
          <!-- sender -->
          <div class="flex space-x-2 items-start justify-end group w-full rtl:space-x-reverse" v-if="item.sender_id === auth.user.user.id">
            <div class="no flex space-x-4 rtl:space-x-reverse">
              
              <div class="whitespace-pre-wrap break-all">
                <div class="text-contrent p-3 bg-slate-300 dark:bg-slate-900 dark:text-slate-300 text-slate-800 text-sm font-normal rounded-md flex-1 mb-1">
                  {{ item.message }}
                </div>
                <span class="font-normal text-xs text-slate-400">{{ time(item.created_at) }}</span>
              </div>
            </div>
            <div class="flex-none">
              <div class="h-8 w-8 rounded-full">
                <img :src="auth.user.user.profile_picture" alt="" class="block w-full h-full object-cover rounded-full" v-if="auth.user.user.profile_picture"/>
                <img :src="auth.defaultImage" alt="" class="block w-full h-full object-cover rounded-full" v-else/>
              </div>
            </div>
          </div>
          <!-- me  -->
        </div>
      </div>
    </div>
    <footer  class="md:px-6 px-4 sm:flex md:space-x-4 sm:space-x-2 rtl:space-x-reverse border-t md:pt-6 pt-4 border-slate-100 dark:border-slate-700">
      
      <div class="flex-1 relative flex space-x-3 rtl:space-x-reverse"  v-if="ticket?.status != 'closed'">
        <div class="flex-1">
          <textarea
            type="text"
            placeholder="Type your message..."
            class="focus:ring-0 focus:outline-0 block w-full bg-transparent dark:text-white resize-none"
            v-model.trim="newMessage"
            @keydown.enter.exact.prevent="sendMessage"
            @keydown.enter.shift.exact.prevent="newMessage += '\n'"
          />
        </div>
        <div class="flex-none md:pr-0 pr-3">
          <button
            type="button"
            @click="sendMessage"
            class="h-12 w-52 bg-slate-900 text-white flex flex-row gap-3 justify-center items-center text-md rounded-full" 
          > Send Message
            <Icon
              icon="heroicons-outline:paper-airplane"
              class="transform rotate-[60deg]"
            />
          </button>
        </div>
      </div>
    </footer>
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
const width = ref(0);

const handleResize = () => {
  width.value = window.innerWidth;
};
onMounted(() => {
  window.addEventListener("resize", handleResize);
  handleResize();
  getMessages()
  getTicket()
});


const ticket = ref()



const getTicket = async () => {
  let id = route.params.ticket_id;
  ticket.value = await axios.post(`${import.meta.env.VITE_APP_API_URL}/customer/single_chat_ticket_detail`, {
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

    toast.error("Ticket Not Found", {
      timeout: 4000,
    });

    router.push({ name: 'support-tickets' })
  });
};


const userData = ref()
const newMessage = ref("");
const auth = useAuthStore();



const getMessages = async () => {
  let id = route.params.ticket_id;
  userData.value = await axios.post(`${import.meta.env.VITE_APP_API_URL}/customer/get_message`, {
    id: id,
  }, {
    headers: {
      "Authorization": "Bearer " + auth.user.token
    }
  }).then(function (response) {

    if (response.data?.status) {

      toast.success('Message Updated', {
        timeout: 4000,
      });
      
      scrollToBottom();
      return response.data?.messages

    } else {

    }
  }).catch(function (error) {
    console.log('catch')
    // router.push({ name: 'admin-all-tickets' });
    toast.error(error, {
      timeout: 4000,
    });
  });
};
const chatheight = ref(null);
const scrollToBottom = () => {
  setTimeout(() => {
    const scrollEl = chatheight.value;
    scrollEl.scrollTop = scrollEl.scrollHeight - scrollEl.clientHeight;
  }, 50);
};
const sendMessage = () => {
  
  if (!newMessage.value) {
    toast.error("Please Type your messages", {
      timeout: 4000,
    });
    return;
  }
  let id = route.params.ticket_id;
  let message = newMessage.value
  axios.post(`${import.meta.env.VITE_APP_API_URL}/customer/send_message`, {
    id: id,
    message: newMessage.value
  }, {
    headers: {
      "Authorization": "Bearer " + auth.user.token
    }
  }).then(function (response) {

    if (response.data?.status) {
      
      getMessages()
       toast.success('Message sent', {
        timeout: 4000,
       });
       
      
    } else {
      
    }
  }).catch(function (error) {
    console.log('catch')
    
         toast.error(error, {
          timeout: 4000,
        });
  });

  newMessage.value = "";
  scrollToBottom();

};

const time = (timeSting) => {
  const date = new Date(timeSting);
  const hours = date.getHours();
  const minutes = date.getMinutes();
  const ampm = hours >= 12 ? "pm" : "am";
  const hours12 = hours % 12 || 12;
  const minutesStr = minutes < 10 ? "0" + minutes : minutes;
  return hours12 + ":" + minutesStr + " " + ampm;
};


</script>
<style lang="scss" scoped>
.msg-height {
  height: calc(100% - 0px);
}
.parent-height {
  height: calc(100% - 200px);
}
.msg-action-btn {
  @apply md:h-8 md:w-8 h-6 w-6 cursor-pointer bg-slate-100 dark:bg-slate-900 dark:text-slate-400 text-slate-900 flex flex-col justify-center items-center md:text-xl text-sm rounded-full;
}
</style>
