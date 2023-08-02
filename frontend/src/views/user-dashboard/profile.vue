<template>
  <div class="space-y-5 profile-page">
    <div
      class="profiel-wrap px-[35px] pb-10 md:pt-[84px] pt-10 rounded-lg bg-white dark:bg-slate-800 lg:flex lg:space-y-0 space-y-6 justify-between items-end relative z-[1]">
      <div class="bg-slate-900 dark:bg-slate-700 absolute left-0 top-0 md:h-1/2 h-[150px] w-full z-[-1] rounded-t-lg">
      </div>
      <div class="profile-box flex-none md:text-start text-center">
        <div class="md:flex items-end md:space-x-6 rtl:space-x-reverse">
          <div class="flex-none">
            <div
              class="md:h-[186px] md:w-[186px] h-[140px] w-[140px] md:ml-0 md:mr-0 ml-auto mr-auto md:mb-0 mb-4 rounded-full ring-4 ring-slate-100 relative">

              <img v-if="this.$store.authStore.user.user.profile_picture"
                :src="app_url + '/uploads/profile_photo/' + this.$store.authStore.user.user.profile_picture" alt=""
                class="w-full h-full object-cover rounded-full" />
              <img v-else src="@/assets/images/users/default.jpg" alt="" class="w-full h-full object-cover rounded-full" />

              <div>
                <div v-bind="getRootProps()">
                  <input v-bind="getInputProps()" />
                </div>
                <button
                  class="absolute right-2 h-8 w-8 bg-slate-50 text-slate-600 rounded-full shadow-sm flex flex-col items-center justify-center md:top-[140px] top-[100px] cursor-pointer"
                  @click="open">
                  <Icon icon="heroicons:pencil-square" />
                </button>
              </div>
            </div>

          </div>
          <div class="flex-1">
            <div class="text-2xl font-medium text-slate-900 dark:text-slate-200 mb-[3px]">
              {{ this.$store.authStore.user.user.name }}
            </div>
            <div class="text-sm font-light text-slate-600 dark:text-slate-400">
              {{ this.$store.authStore.user.user.email }}
            </div>
          </div>
        </div>
      </div>
      <!-- end profile box -->
      <div class="profile-info-500 md:flex md:text-start text-center flex-1 max-w-[156px] md:space-y-0 space-y-4">
        <div class="flex-1">
          <div class="text-base text-slate-900 dark:text-slate-300 font-medium mb-1">
            {{ account_number }}
          </div>
          <div class="text-sm text-slate-600 font-light dark:text-slate-300">
              Account Number
          </div>
        </div>
        
      </div>
      <!-- profile info-500 -->
    </div>

    <TabGroup>
      <div class="grid gap-5 grid-cols-12">
        <div class="xl:col-span-3 lg:col-span-4 col-span-12 card-auto-height">
          <Card>
            <TabList class="flex flex-col space-y-1 text-start items-start">
              <Tab v-for="(item, i) in tabItems" :key="i" v-slot="{ selected }" as="template">
                <button type="button"
                  class="focus:ring-0 focus:outline-none space-x-2 text-sm flex items-center w-full transition duration-150 px-3 py-4 rounded-[6px] rtl:space-x-reverse"
                  :class="selected
                    ? 'bg-slate-100 dark:bg-slate-900 dark:text-white'
                    : 'bg-white dark:bg-slate-800 dark:text-slate-300'
                    ">
                  <Icon icon="heroicons:chevron-double-right-solid" class="text-lg" :class="selected ? ' opacity-100' : 'opacity-50 dark:opacity-100'
                    " />
                  <span> {{ item.title }}</span>
                </button>
              </Tab>
            </TabList>
          </Card>
        </div>
        <div class="xl:col-span-9 lg:col-span-8 col-span-12">
          <TabPanels>
            <TabPanel>
              <Card title="User Details">
                  
                <ul class="grid md:grid-cols-3 grid-cols-1 gap-3">
                    <li class="flex space-x-3 rtl:space-x-reverse">
                        <div class="flex-none text-2xl text-slate-600 dark:text-slate-300" >
                          <Icon icon="heroicons:envelope" />
                        </div>
                        <div class="flex-1">
                          <div class="uppercase text-xs text-slate-500 dark:text-slate-300 mb-1 leading-[12px]" >
                            EMAIL
                          </div>
                          <a class="text-base text-slate-600 dark:text-slate-50">
                             {{ this.$store.authStore.user.user.email }}
                          </a>
                        </div>
                    </li>
                  <!-- end single list -->
                  <li class="flex space-x-3 rtl:space-x-reverse">
                    <div class="flex-none text-2xl text-slate-600 dark:text-slate-300">
                      <Icon icon="heroicons:phone-arrow-up-right" />
                    </div>
                    <div class="flex-1">
                      <div class="uppercase text-xs text-slate-500 dark:text-slate-300 mb-1 leading-[12px]">
                        PHONE
                      </div>
                      <a
                        href="#"
                        class="text-base text-slate-600 dark:text-slate-50"
                      >
                         {{ this.$store.authStore.user.user.phone }}
                      </a>
                    </div>
                  </li>
                  <!-- end single list -->
                  <li class="flex space-x-3 rtl:space-x-reverse">
                    <div
                      class="flex-none text-2xl text-slate-600 dark:text-slate-300"
                    >
                      <Icon icon="heroicons:map" />
                    </div>
                    <div class="flex-1">
                      <div
                        class="uppercase text-xs text-slate-500 dark:text-slate-300 mb-1 leading-[12px]"
                      >
                        Branch
                      </div>
                      <div class="text-base text-slate-600 dark:text-slate-50">
                        Melbourne
                      </div>
                    </div>
                  </li>
                  <!-- end single list -->
                </ul>
              </Card>
              <Card title="Account Overview">
                  
                <apexchart type="area" height="250" :options="this.$store.themeSettingsStore.isDark
                    ? basicAreaDark.chartOptions
                    : basicArea.chartOptions
                  " :series="basicArea.series" />
              </Card>
              <Card title="User Cards">
                  <div class="grid lg:grid-cols-2 grid-col-1">
                    <!-- <div> -->
                      <div class="w-100 h-56 m-auto bg-red-100 rounded-xl relative text-white shadow-2xl " :class="{ 'blur-md' : information.account_details?.first_card_status == 'not_active' }">
                          
                          <img class="object-cover w-[450px] h-full rounded-xl" src="@/assets/images/card/background.jpg">
            
                          <div class="w-full px-8 absolute top-8">
                              <div class="flex justify-between">
                                  <img class="w-8 h-8" src="@/assets/images/card/icon.svg"/>
                                  <!-- <img class="w-14 h-14 mt-[-10px]" src="https://i.imgur.com/bbPHJVe.png"/> -->
                              </div>
                          </div>
                          <div class="w-full px-8 absolute bottom-5">
                            
                              <div class="pt-0">
                                  <p class="font-light  text-xs">
                                      Card Number
                                  </p>
                                  <p class="font-medium tracking-more-wider tracking-[.25em]">
                                      <span class="mr-2">XXXX</span>   <span class="mr-2">XXXX</span>   <span class="mr-2">XXXX</span>   <span class="mr-2">XXXX</span>
                                  </p>
                              </div>
                              <div class="pt-2 pr-6">
                                  <div class="flex justify-start gap-10">
                                      <div class="">
                                          <p class="font-light text-xs">
                                              Name
                                          </p>
                                          <p class="font-medium tracking-wider text-sm">
                                              {{ this.$store.authStore.user.user.name }}
                                          </p>
                                      </div>
                                      <div class="">
                                          <p class="font-light text-xs">
                                              Exp. Date
                                          </p>
                                          <p class="font-medium tracking-wider text-sm">
                                              08/27
                                          </p>
                                      </div>
                                    
                                  </div>
                              </div>
                          </div>
                        
                          <div class=" absolute right-5 bottom-5">
                              <img class="w-20 h-20 " src="@/assets/images/card/chip1.png"/>
                          </div>
                      </div>
                    <!-- </div> -->
                    <!-- <div> -->
                      <div class="w-100 h-56 m-auto bg-red-100 rounded-xl relative text-white shadow-2xl "  :class="{ 'blur-md': information.account_details?.second_card_status == 'not_active' }">
            
                          <img class="object-cover w-[450px] h-full rounded-xl" src="@/assets/images/card/background.jpg">
            
                          <div class="w-full px-8 absolute top-8">
                              <div class="flex justify-between">
                                  <img class="w-8 h-8" src="@/assets/images/card/icon.svg"/>
                                  <!-- <img class="w-14 h-14 mt-[-10px]" src="https://i.imgur.com/bbPHJVe.png"/> -->
                              </div>
                          </div>
                          <div class="w-full px-8 absolute bottom-5">
                            
                              <div class="pt-0">
                                  <p class="font-light  text-xs">
                                      Card Number
                                  </p>
                                  <p class="font-medium tracking-more-wider tracking-[.25em]">
                                      <span class="mr-2">XXXX</span>   <span class="mr-2">XXXX</span>   <span class="mr-2">XXXX</span>   <span class="mr-2">XXXX</span>
                                  </p>
                              </div>
                              <div class="pt-2 pr-6">
                                  <div class="flex justify-start gap-10">
                                      <div class="">
                                          <p class="font-light text-xs">
                                              Name
                                          </p>
                                          <p class="font-medium tracking-wider text-sm">
                                              {{ this.$store.authStore.user.user.name }}
                                          </p>
                                      </div>
                                      <div class="">
                                          <p class="font-light text-xs">
                                              Exp. Date
                                          </p>
                                          <p class="font-medium tracking-wider text-sm">
                                              08/27
                                          </p>
                                      </div>
                                    
                                  </div>
                              </div>
                          </div>
                        
                          <div class=" absolute right-5 bottom-5">
                              <img class="w-20 h-20 " src="@/assets/images/card/chip1.png"/>
                          </div>
                      </div>

                    <!-- </div> -->
                  </div>
                  
                  <ul class="grid grid-cols-2 my-40 mx-20">
                      <li class="">
                          <div class="flex space-x-3 rtl:space-x-reverse mb-4">
                            <div class="flex-none text-2xl text-slate-600 dark:text-slate-300" >
                                  <Icon icon="fa6-solid:circle-dollar-to-slot" />
                              </div>
                              <div class="flex-1">
                                  <div class="uppercase text-xs text-slate-500 dark:text-slate-300 mb-1 leading-[12px]" >
                                    First Card Balance
                                  </div>
                                  <a class="text-base text-slate-600 dark:text-slate-50">
                                      {{ information.account_details?.first_card_balance }}
                                  </a>
                              </div>
                          </div>

                          <div class="flex space-x-3 rtl:space-x-reverse  mb-4">
                            <div class="flex-none text-2xl text-slate-600 dark:text-slate-300" >
                                  <Icon icon="solar:card-2-linear" />
                              </div>
                              <div class="flex-1">
                                  <div class="uppercase text-xs text-slate-500 dark:text-slate-300 mb-1 leading-[12px]" >
                                      First Card Number
                                  </div>
                                  <a class="text-base text-slate-600 dark:text-slate-50" @click="toggleview('first')" v-if="!view_first">
                                      {{ information.account_details?.first_card_number?.match(/.{1,4}/g)[0] }} <span>XXXX</span> <span>XXXX</span> <span>XXXX</span>
                                  </a>
                                  <a class="text-base text-slate-600 dark:text-slate-50" @click="toggleview('first')" v-else>
                                      {{ information.account_details?.first_card_number?.match(/.{1,4}/g)[0] }} <span>{{ information.account_details?.first_card_number?.match(/.{1,4}/g)[1] }}</span> <span>{{ information.account_details?.first_card_number?.match(/.{1,4}/g)[2] }}</span> <span>{{ information.account_details?.first_card_number?.match(/.{1,4}/g)[3] }}</span>
                                  </a>
                              </div>
                          </div>

                          <div class="flex space-x-3 flex-row-reverse mb-4 mx-20">
                              <Button text="offset" btnClass="btn-primary btn-sm" />
                          </div>
                      </li>
                      <li class="ml-20">
                          <div class="flex space-x-3 rtl:space-x-reverse mb-4"  v-if="information.account_details?.second_card_status == active">
                            <div class="flex-none text-2xl text-slate-600 dark:text-slate-300" >
                                  <Icon icon="fa6-solid:circle-dollar-to-slot" />
                              </div>
                              <div class="flex-1">
                                  <div class="uppercase text-xs text-slate-500 dark:text-slate-300 mb-1 leading-[12px]" >
                                    Second Card Balance
                                  </div>
                                  <a class="text-base text-slate-600 dark:text-slate-50">
                                      {{ information.account_details?.second_card_balance }}
                                  </a>
                              </div>
                          </div>

                          <div class="flex space-x-3 rtl:space-x-reverse  mb-4" v-if="information.account_details?.second_card_status == active">
                            <div class="flex-none text-2xl text-slate-600 dark:text-slate-300" >
                                  <Icon icon="solar:card-2-linear" />
                              </div>
                              <div class="flex-1">
                                  <div class="uppercase text-xs text-slate-500 dark:text-slate-300 mb-1 leading-[12px]" >
                                      Second Card Number
                                  </div>
                                  <a class="text-base text-slate-600 dark:text-slate-50" @click="toggleview('second')" v-if="!view_second">
                                      {{ information.account_details?.seconds_card_number?.match(/.{1,4}/g)[0] }} <span>XXXX</span> <span>XXXX</span> <span>XXXX</span>
                                  </a>
                                  <a class="text-base text-slate-600 dark:text-slate-50" @click="toggleview('second')" v-else>
                                      {{ information.account_details?.seconds_card_number?.match(/.{1,4}/g)[0] }} 
                                      <span>{{ information.account_details?.seconds_card_number?.match(/.{1,4}/g)[1] }}</span> 
                                      <span>{{ information.account_details?.seconds_card_number?.match(/.{1,4}/g)[2] }}</span> 
                                      <span>{{ information.account_details?.seconds_card_number?.match(/.{1,4}/g)[3] }}</span>
                                  </a>
                              </div>
                          </div>
                          

                          <div class="flex space-x-3 flex-row-reverse  mb-4 mx-20">
                              <Button text="request" btnClass="btn-primary btn-sm" />
                          </div>
                      </li>
                      
                  </ul>
                  
              </Card>
            </TabPanel>
            <TabPanel>
              <UpdatePassword />
            </TabPanel>
            <TabPanel>
              <RequestCard />
            </TabPanel>
          </TabPanels>
        </div>
      </div>

    </TabGroup>
  </div>
</template>
<script>
import Card from "@/components/Card";
import Icon from "@/components/Icon";
import { basicArea, basicAreaDark } from "@/constant/appex-chart.js";
import { ref, onMounted } from 'vue';
import { useDropzone } from "vue3-dropzone";
import axios from "axios";
import { useAuthStore } from '@/store/authUser';
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from "@headlessui/vue";
import UpdatePassword from "@/views/user-dashboard/tabs/form";
import RequestCard from "@/views/user-dashboard/tabs/form";
import Button from "@/components/Button";

export default {
  components: {
    TabGroup,
    TabList,
    Tab,
    TabPanels,
    Button,
    TabPanel,
    Card,
    Icon,
    UpdatePassword,
    RequestCard,
  },
  data() {
    return {
      basicArea,
      basicAreaDark,
      view_first: false,
      view_second: false, 
      app_url: import.meta.env.VITE_APP_API_BASEURL,
      account_number: "00000000000",
      information: "",
      tabItems: [
        {
          title: "Account Overview",
        },
        // {
        //   title: "Request Card",
        // },
        {
          title: "Change Password",
        },
      ]
    }

  },
  mounted() {
    this.get_account_details()
  },
  methods: {
    toggleview(card) {
      if (card == 'first') {
        this.view_first = !this.view_first
      }
      if (card == 'second') {
        this.view_second = !this.view_second
      }
    },
    uploadProfile(e) {
      let testing = ref('uploadProfile')
    },
    get_account_details() {
        let $this = this

        axios.post(`${import.meta.env.VITE_APP_API_URL}/customer/dashboard`, {}, {
          headers: {
            "Authorization": "Bearer " + this.$store.authStore.user.token
          }
        }).then(function (response) {

          if (response.data?.status) {
            $this.information = response.data?.data;
            $this.account_number = $this.information?.account_details?.account_number

            // $this.statistics1[0].count = $this.information.last_transaction ? parseFloat($this.information.total_balance).toLocaleString("en-US") : "0";
            // $this.transactions = $this.information.recent_transaction ? $this.information.recent_transaction : [];
            // $this.statistics1[0].stat = "";
            // $this.statistics1[1].count = parseFloat($this.information.account_details?.aud_balance).toLocaleString("en-US");
            // $this.statistics1[2].count = parseFloat($this.information.account_details?.usd_balance).toLocaleString("en-US");
            // $this.statistics1[3].count = parseFloat($this.information.account_details?.eur_balance).toLocaleString("en-US");
            // $this.statistics1[3].count = parseFloat($this.information.account_details?.eur_balance).toLocaleString("en-US");
            // $this.card_balance = $this.information.account_details?.first_card_balance
            // $this.card_number = $this.information.account_details.first_card_number.match(/.{1,4}/g);


          } else {
            
          }
        }).catch(function (error) {
          
        });
    
    }
  },
  setup() {

    const auth = useAuthStore();
    const saveFiles = (files) => {
      const formData = new FormData(); // pass data as a form
      formData.append("images", files[0]);

      axios.post(`${import.meta.env.VITE_APP_API_URL}/customer/upload_profile`, formData, {
        headers: {
          "Content-Type": "multipart/form-data",
          "Authorization": "Bearer " + auth.user.token
        },
      })
        .then((response) => {
          auth.refresh()
          console.info(response.data);
        })
        .catch((err) => {
          console.error(err);
        });
    };

    function onDrop(acceptFiles, rejectReasons) {
      saveFiles(acceptFiles); // saveFiles as callback
      console.log(rejectReasons);
    }

    const { getRootProps, getInputProps, ...rest } = useDropzone({ onDrop });

    return {
      getRootProps,
      getInputProps,
      ...rest,
    };
  },
};
</script>
<style lang="scss" scoped></style>
