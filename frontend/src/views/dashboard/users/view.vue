<template>
    <div>
        <div class="space-y-5 profile-page">
            <div
            class="profiel-wrap px-[35px] pb-10 md:pt-[84px] pt-10 rounded-lg bg-white dark:bg-slate-800 lg:flex lg:space-y-0 space-y-6 justify-between items-end relative z-[1]"
            >
            <div
                class="bg-slate-900 dark:bg-slate-700 absolute left-0 top-0 md:h-1/2 h-[150px] w-full z-[-1] rounded-t-lg"
            ></div>
            <div class="profile-box flex-none md:text-start text-center">
                <div class="md:flex items-end md:space-x-6 rtl:space-x-reverse">
                <div class="flex-none">
                    <div
                    class="md:h-[186px] md:w-[186px] h-[140px] w-[140px] md:ml-0 md:mr-0 ml-auto mr-auto md:mb-0 mb-4 rounded-full ring-4 ring-slate-100 relative"
                    >
                    
                  <img v-if="this.$store.authStore.user.user.profile_picture"
                    :src="app_url + '/uploads/profile_photo/' + this.$store.authStore.user.user.profile_picture" alt=""
                    class="w-full h-full object-cover rounded-full" />
                  <img v-else src="@/assets/images/users/default.jpg" alt="" class="w-full h-full object-cover rounded-full" />

                    <!-- <router-link
                        to="/app/profile-setting"
                        class="absolute right-2 h-8 w-8 bg-slate-50 text-slate-600 rounded-full shadow-sm flex flex-col items-center justify-center md:top-[140px] top-[100px]"
                        ><Icon icon="heroicons:pencil-square" />
                    </router-link> -->
                    </div>
                </div>
                <div class="flex-1">
                    <div
                    class="text-2xl font-medium text-slate-900 dark:text-slate-200 mb-[3px]"
                    >
                    {{user?.name}}
                    </div>
                    <div class="text-sm font-light text-slate-600 dark:text-slate-400">
                    {{ user?.email }}
                    </div>
                </div>
                </div>
            </div>
            <!-- end profile box -->
            <div
                class="profile-info-500 md:flex md:text-start text-center flex-1 max-w-[516px] md:space-y-0 space-y-4"
            >
                <div class="flex-1">
                <div class="text-base text-slate-900 dark:text-slate-300 font-medium mb-1" >
                   {{  user?.account_details ? "$" + user?.account_details?.aud_balance.toLocaleString("en-US") : "0.00" }}
                </div>
                <div class="text-sm text-slate-600 font-light dark:text-slate-300">
                    AUD Balance
                </div>
                </div>
                <!-- end single -->
                <div class="flex-1">
                <div
                    class="text-base text-slate-900 dark:text-slate-300 font-medium mb-1"
                >
                    {{  user?.account_details ? "€" + user?.account_details?.eur_balance.toLocaleString("en-US") : "0.00" }}
                </div>
                <div class="text-sm text-slate-600 font-light dark:text-slate-300">
                    EUR Balance
                </div>
                </div>
                <!-- end single -->
                <div class="flex-1">
                <div
                    class="text-base text-slate-900 dark:text-slate-300 font-medium mb-1"
                >
                    {{  user?.account_details ? "$" + user?.account_details?.usd_balance.toLocaleString("en-US") : "0.00" }}
                </div>
                <div class="text-sm text-slate-600 font-light dark:text-slate-300">
                    USD Balance
                </div>
                </div>
                <!-- end single -->
            </div>
            <!-- profile info-500 -->
            </div>
                    
            <TabGroup>
                <div class="grid gap-5 grid-cols-12">
                    <div class="xl:col-span-3 lg:col-span-4 col-span-12 card-auto-height">
                    <Card>
                        <TabList class="flex flex-col space-y-1 text-start items-start">
                        <Tab v-for="(item, i) in tabItems" :key="i"
                            v-slot="{ selected }"
                            as="template"
                        >
                            <button
                            type="button"
                            class="focus:ring-0 focus:outline-none space-x-2 text-sm flex items-center w-full transition duration-150 px-3 py-4 rounded-[6px] rtl:space-x-reverse"
                            :class="selected
                                    ? 'bg-slate-100 dark:bg-slate-900 dark:text-white'
                                    : 'bg-white dark:bg-slate-800 dark:text-slate-300'
                                "
                            >
                            <Icon
                                icon="heroicons:chevron-double-right-solid"
                                class="text-lg"
                                :class="selected ? ' opacity-100' : 'opacity-50 dark:opacity-100'
                                    "
                            />
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
                                
                    <ul class="grid grid-cols-3">
                        <li class="flex space-x-3 rtl:space-x-reverse mb-10">
                            <div class="flex-none text-2xl text-slate-600 dark:text-slate-300" >
                              <Icon icon="heroicons:envelope" />
                            </div>
                            <div class="flex-1">
                              <div class="uppercase text-xs text-slate-500 dark:text-slate-300 mb-1 leading-[12px]" >
                                EMAIL
                              </div>
                              <a class="text-base text-slate-600 dark:text-slate-50">
                                    {{ user ? user.email : "" }}
                              </a>
                            </div>
                        </li>
                      <!-- end single list -->
                      <li class="flex space-x-3 rtl:space-x-reverse mb-10">
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
                            {{ user ? user.phone : "" }}
                          </a>
                        </div>
                      </li>
                          <!-- end single list -->
                          <li class="flex space-x-3 rtl:space-x-reverse mb-10">
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
                          <li class="flex space-x-3 rtl:space-x-reverse mb-10">
                            <div
                              class="flex-none text-2xl text-slate-600 dark:text-slate-300"
                            >
                              <Icon icon="heroicons:map" />
                            </div>
                            <div class="flex-1">
                              <div
                                class="uppercase text-xs text-slate-500 dark:text-slate-300 mb-1 leading-[12px]"
                              >
                                User Status
                              </div>
                              <div class="text-base text-slate-600 dark:text-slate-50">
                                    {{ user ? user?.status == "active" ? "Active" : "Not Active" : "" }}
                              </div>
                            </div>
                          </li>
                          <!-- end single list -->
                              <li class="flex space-x-3 rtl:space-x-reverse mb-10">
                                <div
                                  class="flex-none text-2xl text-slate-600 dark:text-slate-300"
                                >
                                  <Icon icon="heroicons:map" />
                                </div>
                                <div class="flex-1">
                                  <div
                                    class="uppercase text-xs text-slate-500 dark:text-slate-300 mb-1 leading-[12px]"
                                  >
                                    User Account Status
                                  </div>
                                  <div class="text-base text-slate-600 dark:text-slate-50">
                                        {{ user?.account_details ? user?.account_details?.status == "active" ? "Active" : "Not Active" : "" }}
                                  </div>
                                </div>
                              </li>
                              <!-- end single list -->
                              <li class="flex space-x-3 rtl:space-x-reverse mb-10">
                                <div
                                  class="flex-none text-2xl text-slate-600 dark:text-slate-300"
                                >
                                  <Icon icon="heroicons:map" />
                                </div>
                                <div class="flex-1">
                                  <div
                                    class="uppercase text-xs text-slate-500 dark:text-slate-300 mb-1 leading-[12px]"
                                  >
                                    Email Verified
                                  </div>
                                  <div class="text-base text-slate-600 dark:text-slate-50">
                                    {{ user ? user?.email_verified == "yes" ? "Done" : "Not Done" : "" }}
                                  </div>
                                </div>
                              </li>
                              <li class="flex space-x-3 rtl:space-x-reverse mb-10">
                                <div
                                  class="flex-none text-2xl text-slate-600 dark:text-slate-300"
                                >
                                  <Icon icon="heroicons:map" />
                                </div>
                                <div class="flex-1">
                                  <div
                                    class="uppercase text-xs text-slate-500 dark:text-slate-300 mb-1 leading-[12px]"
                                  >
                                    USD Status
                                  </div>
                                  <div class="text-base text-slate-600 dark:text-slate-50">
                                        {{ user?.account_details ? user?.account_details?.usd_status == "active" ? "Active" : "Not Active" : "" }}
                                  </div>
                                       <button class="btn btn-danger btn-sm float-left" v-if="user?.account_details?.usd_status == 'active'" @click="togglecurrency('USD')">Lock</button>
                                       <button class="btn btn-primary btn-sm float-left" v-if="user?.account_details?.usd_status == 'not_active'"  @click="togglecurrency('USD')">Unlock</button>
                                </div>
                              </li>
                              <li class="flex space-x-3 rtl:space-x-reverse mb-10">
                                <div
                                  class="flex-none text-2xl text-slate-600 dark:text-slate-300"
                                >
                                  <Icon icon="heroicons:map" />
                                </div>
                                <div class="flex-1">
                                  <div
                                    class="uppercase text-xs text-slate-500 dark:text-slate-300 mb-1 leading-[12px]"
                                  >
                                    EUR Status
                                  </div>
                                  <div class="text-base text-slate-600 dark:text-slate-50">
                                        {{ user?.account_details ? user?.account_details?.eur_status == "active" ? "Active" : "Not Active" : "" }}
                                  </div>
                                       <button class="btn btn-danger btn-sm float-left" v-if="user?.account_details?.eur_status == 'active'" @click="togglecurrency('EUR')">Lock</button>
                                       <button class="btn btn-primary btn-sm float-left" v-if="user?.account_details?.eur_status == 'not_active'"  @click="togglecurrency('EUR')">Unlock</button>
                                </div>
                              </li>
                              <li class="flex space-x-3 rtl:space-x-reverse mb-10">
                                <div
                                  class="flex-none text-2xl text-slate-600 dark:text-slate-300"
                                >
                                  <Icon icon="heroicons:map" />
                                </div>
                                <div class="flex-1">
                                  <div
                                    class="uppercase text-xs text-slate-500 dark:text-slate-300 mb-1 leading-[12px]"
                                  >
                                    AUD Status
                                  </div>
                                  <div class="text-base text-slate-600 dark:text-slate-50">
                                        {{ user?.account_details ? user?.account_details?.aud_status == "active" ? "Active" : "Not Active" : "" }}
                                  </div>
                                   <button class="btn btn-danger btn-sm float-left" v-if="user?.account_details?.aud_status == 'active'" @click="togglecurrency('AUD')">Lock</button>
                                   <button class="btn btn-primary btn-sm float-left" v-if="user?.account_details?.aud_status == 'not_active'"  @click="togglecurrency('AUD')">Unlock</button>
                                </div>
                              </li>
                          <!-- end single list -->
                          <li class="flex space-x-3 rtl:space-x-reverse mb-10">
                            <div
                              class="flex-none text-2xl text-slate-600 dark:text-slate-300"
                            >
                              <Icon icon="heroicons:map" />
                            </div>
                            <div class="flex-1">
                              <div
                                class="uppercase text-xs text-slate-500 dark:text-slate-300 mb-1 leading-[12px]"
                              >
                                KYC Status
                              </div>
                              <div class="text-base text-slate-600 dark:text-slate-50">
                                {{ user ?  user?.kyc_status == "yes" ? "Done" : "Not Done" : "" }}
                              </div>
                              <button class="btn btn-danger btn-sm float-left" v-if="user?.kyc_status == 'yes'" @click="toggleKYC()">Mark As Not Done</button>
                              <button class="btn btn-primary btn-sm float-left" v-if="user?.kyc_status == 'no'"  @click="toggleKYC()">Mark As Done</button>
                            </div>
                          </li>
                          <li class="flex space-x-3 rtl:space-x-reverse mb-10">
                            <div
                              class="flex-none text-2xl text-slate-600 dark:text-slate-300"
                            >
                              <Icon icon="heroicons:map" />
                            </div>
                            <div class="flex-1">
                              <div
                                class="uppercase text-xs text-slate-500 dark:text-slate-300 mb-1 leading-[12px]"
                              >
                                First Card Status
                              </div>
                              <div class="text-base text-slate-600 dark:text-slate-50">
                                {{ user ?  user?.account_details?.first_card_status == "active" ? "Active" : "Not Active" : "" }}
                              </div>
                              <button class="btn btn-danger btn-sm float-left" v-if="user?.account_details?.first_card_status == 'active'" @click="toggleCard('first')">Block</button>
                              <button class="btn btn-primary btn-sm float-left" v-if="user?.account_details?.first_card_status == 'not_active'"  @click="toggleCard('first')">Activate</button>
                            </div>
                          </li>
                            <li class="flex space-x-3 rtl:space-x-reverse mb-10">
                              <div
                                class="flex-none text-2xl text-slate-600 dark:text-slate-300"
                              >
                                <Icon icon="heroicons:map" />
                              </div>
                              <div class="flex-1">
                                <div
                                  class="uppercase text-xs text-slate-500 dark:text-slate-300 mb-1 leading-[12px]"
                                >
                                  First Card Limit
                                </div>
                                <div class="text-base text-slate-600 dark:text-slate-50">
                                  {{ user ? user?.account_details?.first_card_balance : "" }}
                                </div>
                                    <Modal v-if="user?.account_details?.first_card_status == 'active'"
                                        title="Edit First Card Limit"
                                        label="Edit Limit"
                                        labelClass="btn btn-success btn-sm float-left"
                                        ref="modal2"
                                        centered
                                        >
                                        <h4 class="font-medium text-lg mb-3 text-slate-900">
                                            
                                        </h4>
                                        <div class="text-base text-slate-600 dark:text-slate-300">
                                          
                                          <Textinput label="Limit" type="number" placeholder="Limit" name="limit" v-model="firstLimit" :error="firstLimitError"  classInput="h-[48px]" />
                                          
                                        </div>
                                        <template v-slot:footer>
                                            <Button
                                            text="Close"
                                            btnClass="btn-dark "
                                            @click="$refs.modal2.closeModal()" 
                                            />
                                            <button type="submit" class="btn btn-dark float-right text-center" @click="update_first_limit">
                                                {{ "Update" }}
                                            </button>
                                        </template>
                                    </Modal>
                              </div>
                            </li>
                            <li class="flex space-x-3 rtl:space-x-reverse mb-10">
                              <div
                                class="flex-none text-2xl text-slate-600 dark:text-slate-300"
                              >
                                <Icon icon="heroicons:map" />
                              </div>
                              <div class="flex-1">
                                <div
                                  class="uppercase text-xs text-slate-500 dark:text-slate-300 mb-1 leading-[12px]"
                                >
                                  Second Card Status
                                </div>
                                <div class="text-base text-slate-600 dark:text-slate-50">
                                  {{ user ? user?.account_details?.second_card_status == "active" ? "Active" : "Not Active" : "" }}
                                </div>
                              <button class="btn btn-danger btn-sm float-left" v-if="user?.account_details?.second_card_status == 'active'" @click="toggleCard('second')">Block</button>
                              <button class="btn btn-primary btn-sm float-left" v-if="user?.account_details?.second_card_status == 'not_active'"  @click="toggleCard('second')">Activate</button>
                              </div>
                            </li>
                            <li class="flex space-x-3 rtl:space-x-reverse mb-10">
                              <div
                                class="flex-none text-2xl text-slate-600 dark:text-slate-300"
                              >
                                <Icon icon="heroicons:map" />
                              </div>
                              <div class="flex-1">
                                <div
                                  class="uppercase text-xs text-slate-500 dark:text-slate-300 mb-1 leading-[12px]"
                                >
                                  Second Card Limit
                                </div>
                                <div class="text-base text-slate-600 dark:text-slate-50">
                                    {{ user ? user?.account_details?.second_card_balance : "" }}
                                </div>
                                
                                    <Modal v-if="user?.account_details?.second_card_status == 'active'"
                                        title="Edit Second Card Limit"
                                        label="Edit Limit"
                                        labelClass="btn btn-success btn-sm float-left"
                                        ref="modal3"
                                        centered
                                        >
                                        <h4 class="font-medium text-lg mb-3 text-slate-900">
                                            
                                        </h4>
                                        <div class="text-base text-slate-600 dark:text-slate-300">
                                          
                                          <Textinput label="Limit" type="number" placeholder="Limit" name="limit" v-model="secondLimit" :error="secondLimitError"  classInput="h-[48px]" />
                                          
                                        </div>
                                        <template v-slot:footer>
                                            <Button
                                            text="Close"
                                            btnClass="btn-dark "
                                            @click="$refs.modal3.closeModal()" 
                                            />
                                            <button type="submit" class="btn btn-dark float-right text-center" @click="update_second_limit">
                                                {{ "Update" }}
                                            </button>
                                        </template>
                                    </Modal>
                              </div>
                            </li>
                          <li class="flex space-x-3 rtl:space-x-reverse mb-10">
                            <div
                              class="flex-none text-2xl text-slate-600 dark:text-slate-300"
                            >
                              <Icon icon="heroicons:map" />
                            </div>
                            <div class="flex-1">
                              <div
                                class="uppercase text-xs text-slate-500 dark:text-slate-300 mb-1 leading-[12px]"
                              >
                                Can Withdraw Money
                              </div>
                              <div class="text-base text-slate-600 dark:text-slate-50">
                                {{ user?.account_details ?  user?.account_details?.can_withdraw == "active" ? "Allowed" : "Not Allowed" : "" }}
                              </div>
                            </div>
                          </li>
                          <li class="flex space-x-3 rtl:space-x-reverse mb-10">
                            <div
                              class="flex-none text-2xl text-slate-600 dark:text-slate-300"
                            >
                              <Icon icon="heroicons:map" />
                            </div>
                            <div class="flex-1">
                              <div
                                class="uppercase text-xs text-slate-500 dark:text-slate-300 mb-1 leading-[12px]"
                              >
                                Can Deposit Money
                              </div>
                              <div class="text-base text-slate-600 dark:text-slate-50">
                                {{ user?.account_details ?  user?.account_details?.can_deposit == "active" ? "Allowed" : "Not Allowed" : "" }}
                              </div>
                            </div>
                          </li>
                          <li class="flex space-x-3 rtl:space-x-reverse mb-10">
                            <div
                              class="flex-none text-2xl text-slate-600 dark:text-slate-300"
                            >
                              <Icon icon="heroicons:map" />
                            </div>
                            <div class="flex-1">
                              <div
                                class="uppercase text-xs text-slate-500 dark:text-slate-300 mb-1 leading-[12px]"
                              >
                                Can Transfer Money
                              </div>
                              <div class="text-base text-slate-600 dark:text-slate-50">
                                {{ user?.account_details ?  user?.account_details?.can_transfer == "active" ? "Allowed" : "Not Allowed" : "" }}
                              </div>
                            </div>
                          </li>
                          <!-- end single list -->
                          <li class="flex space-x-3 rtl:space-x-reverse mb-10">
                            <div
                              class="flex-none text-2xl text-slate-600 dark:text-slate-300"
                            >
                              <Icon icon="heroicons:map" />
                            </div>
                            <div class="flex-1">
                              <div
                                class="uppercase text-xs text-slate-500 dark:text-slate-300 mb-1 leading-[12px]"
                              >
                                Joined At
                              </div>
                              <div class="text-base text-slate-600 dark:text-slate-50">
                                    {{ user ? format_date(user?.created_at) : "" }}
                              </div>
                            </div>
                          </li>
                      <!-- end single list -->
                    </ul>
                            <button class="btn btn-primary float-left" v-if="user?.account_details?.status == 'not_active'" @click="toggleAccount">Unblock Account</button>
                            <button class="btn btn-danger float-right"  v-if="user?.account_details?.status == 'active'" @click="toggleAccount">Block Account</button>
                            </Card>
                        </TabPanel>
                        <TabPanel>
                            <Transaction/>
                        </TabPanel>
                        <TabPanel>
                            <AddMoney />
                        </TabPanel>
                        <TabPanel>
                            <DeductMoney />
                        </TabPanel>
                        <TabPanel>
                            <Loans />
                        </TabPanel>
                        <TabPanel>
                            <FixedDeposit />
                        </TabPanel>
                        <TabPanel>
                            <SupportTicket />
                        </TabPanel>
                        <TabPanel>
                            <SendEmail />
                        </TabPanel>
                        <TabPanel>
                            <KycTable />
                        </TabPanel>
                    </TabPanels>
                    </div>
                </div>
                
            </TabGroup>
        </div>

    </div>
</template>
<script>
 
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from "@headlessui/vue";
import Card from "@/components/Card";
import Icon from "@/components/Icon";
import Transaction from "@/views/dashboard/users/tabs/transaction";
import Loans from "@/views/dashboard/users/tabs/loans";
import AddMoney from "@/views/dashboard/users/tabs/add-money";
import DeductMoney from "@/views/dashboard/users/tabs/deduct-money";
import SendEmail from "@/views/dashboard/users/tabs/send-email";
import FixedDeposit from "@/views/dashboard/users/tabs/fixed-deposit";
import KycTable from "@/views/dashboard/users/tabs/kyc";
import SupportTicket from "@/views/dashboard/users/tabs/support-ticket";
import axios from 'axios';
import { useToast } from "vue-toastification";
import moment from 'moment';
import Modal from '@/components/Modal/Modal';
import Textinput from "@/components/Textinput";
import Button from "@/components/Button";

export default {
  components: {
     
    TabGroup,
        Textinput,
    TabList,
    Tab,
    TabPanels,
    TabPanel,
    Card,
        Button,
    Icon,
        Modal,
    Transaction,
    AddMoney,
    DeductMoney,
    SendEmail,
    Loans,
    FixedDeposit,
    SupportTicket,
    KycTable
  },
  data() {
      return {
            app_url: import.meta.env.VITE_APP_API_BASEURL,
              tabItems: [
                {
                    title: "Account Overview",
                },
                {
                    title: "Transaction",
                },
                {
                    title: "Add Money",
                },
                {
                    title: "Deduct Money",
                },
                {
                    title: "Loans",
                },
                {
                    title: "Fixed Deposits",
                },
                {
                    title: "Support Ticket",
                },
                {
                  title: "Send Email",
                },
                {
                  title: "KYC Verification",
                },
            ],
            user: "",
            firstLimit: "",
            firstLimitError: "",
            secondLimit: "",
            secondLimitError: "",
    }
    },
    mounted() {
        this.fetchuser()
    },
    methods: {
      update_first_limit() {
          const $this = this
          if (!$this.firstLimit) {
            $this.firstLimitError = "Limit can not be empty";
            return;
            } 

        const toast = useToast();
        const fromData = new FormData();
        fromData.append("user_id", $this.$route.params.user_id);
        fromData.append("card", 'first');
        fromData.append("limit", this.firstLimit);
        axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/update_card_limit`, fromData, {
          headers: {
            "Authorization": "Bearer " + this.$store.authStore.user.token
          }
        }).then(function (response) {
          if (response.data?.status) {
            toast.success("User Updated Successful", {
              timeout: 4000,
            });
            $this.user = response.data.user
            
          window.location.reload()
          } else {
            let message = response.data?.message[0];
            toast.error(message, {
              timeout: 4000,
            });
          }
        }).catch(function (error) {
          if (error.response?.data?.error == 'Unauthorized') {
            $this.$router.push({ name: 'Login' })
          }
        });
      },
      update_second_limit() {
          const $this = this
          if (!$this.secondLimit) {
            $this.secondLimitError = "Limit can not be empty";
            return;
            } 

        const toast = useToast();
        const fromData = new FormData();
        fromData.append("user_id", $this.$route.params.user_id);
        fromData.append("card", 'second');
        fromData.append("limit", this.secondLimit);
        axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/update_card_limit`, fromData, {
          headers: {
            "Authorization": "Bearer " + this.$store.authStore.user.token
          }
        }).then(function (response) {
          if (response.data?.status) {
            toast.success("User Updated Successful", {
              timeout: 4000,
            });
            $this.user = response.data.user
            
          window.location.reload()
          } else {
            let message = response.data?.message[0];
            toast.error(message, {
              timeout: 4000,
            });
          }
        }).catch(function (error) {
          if (error.response?.data?.error == 'Unauthorized') {
            $this.$router.push({ name: 'Login' })
          }
        });
      },
        format_date(value) {
            return moment(value).format("Do-MMM-YYYY hh:mm A");
        },
        togglecurrency(currency) {
            const $this = this

            const toast = useToast();
            const fromData = new FormData();
            fromData.append("user_id", $this.$route.params.user_id);
            fromData.append("currency", currency);
            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/toggle_currency`, fromData, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {
                    toast.success("User Updated Successfully", {
                        timeout: 4000,
                    });
                    $this.user = response.data.user
                } else {
                    let message = response.data?.message[0];
                    toast.error(message, {
                        timeout: 4000,
                    });
                }
            }).catch(function (error) {
                if (error.response?.data?.error == 'Unauthorized') {
                    toast.error("Session Expired", {
                        timeout: 3000,
                    });
                    $this.$router.push({ name: 'Login' })
                }
            });
        }, 
        toggleAccount() {
            const $this = this

            const toast = useToast();
            const fromData = new FormData();
            fromData.append("user_id", $this.$route.params.user_id);
            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/toggle_account`, fromData, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {
                    toast.success("User Updated Successfully", {
                        timeout: 4000,
                    });
                    $this.user = response.data.user
                } else {
                    let message = response.data?.message[0];
                    toast.error(message, {
                        timeout: 4000,
                    });
                }
            }).catch(function (error) {
                if (error.response?.data?.error == 'Unauthorized') {
                    toast.error("Session Expired", {
                        timeout: 3000,
                    });
                    $this.$router.push({ name: 'Login' })
                }
            });
        },
        toggleKYC() {
            const $this = this

            const toast = useToast();
            const fromData = new FormData();
            fromData.append("user_id", $this.$route.params.user_id);
            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/toggle_kyc`, fromData, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {
                if (response.data?.status) {
                    toast.success("User Updated Successful", {
                        timeout: 4000,
                    });
                    $this.user = response.data.user
                } else {
                    let message = response.data?.message[0];
                    toast.error(message, {
                        timeout: 4000,
                    });
                }
            }).catch(function (error) {
                if (error.response?.data?.error == 'Unauthorized') {
                    toast.error("Session Expired", {
                        timeout: 3000,
                    });
                    $this.$router.push({ name: 'Login' })
                }
            });
        }, 
        toggleCard(type) {
            const $this = this

            const toast = useToast();
            const fromData = new FormData();
            fromData.append("user_id", $this.$route.params.user_id);
            fromData.append("type", type);
            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/toggle_card`, fromData, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {
                if (response.data?.status) {
                    toast.success("User Updated Successful", {
                        timeout: 4000,
                    });
                  $this.user = response.data.user
                    window.location.reload()
                } else {
                    let message = response.data?.message[0];
                    toast.error(message, {
                        timeout: 4000,
                    });
                }
            }).catch(function (error) {
                if (error.response?.data?.error == 'Unauthorized') {
                    toast.error("Session Expired", {
                        timeout: 3000,
                    });
                    $this.$router.push({ name: 'Login' })
                }
            });
        }, 
        fetchuser() {
            const $this = this
             
            const toast = useToast();
            const fromData = new FormData();
            fromData.append("user_id", $this.$route.params.user_id);
            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/user`, fromData, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {
                    toast.success("User Updated Successfully", {
                        timeout: 4000,
                    });
                    $this.user = response.data.user 
                } else {
                    let message = response.data?.message[0];
                    toast.error(message, {
                        timeout: 4000,
                    });
                }
            }).catch(function (error) {
                if (error.response?.data?.error == 'Unauthorized') {
                    toast.error("Session Expired", {
                        timeout: 3000,
                    });
                    $this.$router.push({ name: 'Login' })
                }
            });
        },
    },
    setup() {

    },
}
</script>
<style lang="scss">
.card-height {
    .card {
        @apply h-[248px] overflow-auto;
    }
}

.card-auto-height {
    .card {
        @apply h-auto;
    }
}
</style>