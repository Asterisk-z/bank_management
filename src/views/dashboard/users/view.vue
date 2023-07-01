<template>
    <div>
        <Breadcrumb />
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
                    <img
                        src="@/assets/images/users/user-1.jpg"
                        alt=""
                        class="w-full h-full object-cover rounded-full"
                    />
                    <router-link
                        to="/app/profile-setting"
                        class="absolute right-2 h-8 w-8 bg-slate-50 text-slate-600 rounded-full shadow-sm flex flex-col items-center justify-center md:top-[140px] top-[100px]"
                        ><Icon icon="heroicons:pencil-square" />
                    </router-link>
                    </div>
                </div>
                <div class="flex-1">
                    <div
                    class="text-2xl font-medium text-slate-900 dark:text-slate-200 mb-[3px]"
                    >
                    Albert ref
                    </div>
                    <div class="text-sm font-light text-slate-600 dark:text-slate-400">
                    Front End Developer
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
                    $32,400
                </div>
                <div class="text-sm text-slate-600 font-light dark:text-slate-300">
                    Total Balance
                </div>
                </div>
                <!-- end single -->
                <div class="flex-1">
                <div
                    class="text-base text-slate-900 dark:text-slate-300 font-medium mb-1"
                >
                    200
                </div>
                <div class="text-sm text-slate-600 font-light dark:text-slate-300">
                    Board Card
                </div>
                </div>
                <!-- end single -->
                <div class="flex-1">
                <div
                    class="text-base text-slate-900 dark:text-slate-300 font-medium mb-1"
                >
                    3200
                </div>
                <div class="text-sm text-slate-600 font-light dark:text-slate-300">
                    Calender Events
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
                            <h1>Account Detail</h1>
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
                            <SendSms />
                        </TabPanel>
                    </TabPanels>
                    </div>
                </div>
                
            </TabGroup>
        </div>

    </div>
</template>
<script>
import Breadcrumb from "@/views/components/Breadcrumbs";
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from "@headlessui/vue";
import Card from "@/components/Card";
import Icon from "@/components/Icon";
import Transaction from "@/views/dashboard/users/tabs/transaction";
import Loans from "@/views/dashboard/users/tabs/loans";
import AddMoney from "@/views/dashboard/users/tabs/add-money";
import DeductMoney from "@/views/dashboard/users/tabs/deduct-money";
import SendEmail from "@/views/dashboard/users/tabs/send-email";
import SendSms from "@/views/dashboard/users/tabs/send-sms";
import FixedDeposit from "@/views/dashboard/users/tabs/fixed-deposit";
import SupportTicket from "@/views/dashboard/users/tabs/support-ticket";

export default {
  components: {
    Breadcrumb,
    TabGroup,
    TabList,
    Tab,
    TabPanels,
    TabPanel,
    Card,
    Icon,
    Transaction,
    AddMoney,
    DeductMoney,
    SendEmail,
    Loans,
    SendSms,
    FixedDeposit,
    SupportTicket
  },
  data() {
    return {
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
                    title: "Send SMS",
                },
            ],
    }
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