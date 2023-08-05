<template>
  <div>
      <Breadcrumb />
      
      <div class="grid grid-cols-12 gap-5 mb-5">
        <div class="2xl:col-span-12 lg:col-span-12 col-span-12">
          <Card bodyClass="p-4">
            <div class="grid md:grid-cols-4 grid-cols-1 gap-4">
              <div v-for="(item, i) in statistics" :key="i">
                <Card :bodyClass="`pt-4 pb-3 px-4 ${item.bg}`">
                  <div class="flex space-x-3 rtl:space-x-reverse" >
                    <div class="flex-none">
                      <div
                        class="h-12 w-12 rounded-full flex flex-col items-center justify-center text-2xl"
                        :class="`${item.bg} ${item.text}`"
                      >
                        <Icon :icon="item.icon" />
                      </div>
                    </div>
                    <div class="flex-1">
                      <div
                        class="text-slate-600 dark:text-slate-300 text-sm mb-1 font-medium"
                      >
                        {{ item.title }}
                      </div>
                      <div class="text-slate-900 dark:text-white text-lg font-medium" >
                        {{ item.count }}
                      </div>
                    </div>
                  </div>
                </Card>
              </div>
            </div>
          </Card>

        </div>
      </div>

      
      <div class="grid grid-cols-12 gap-5">
        <div class="xl:col-span-6 col-span-12">
          <Card title="Recent Transactions" noborder>
            <template #header>
              <Button
                icon="heroicons-outline:plus"
                text="Add card"
                btnClass="btn-dark btn-sm "
              />
            </template>
            <TransactionsTable class="-mx-6 -mb-6" />
          </Card>
        </div>
        
        <div class="xl:col-span-6 col-span-12">
          <Card title="Recent Activity" noborder>
            <template #header>
              <Button
                icon="heroicons-outline:plus"
                text="Add card"
                btnClass="btn-dark btn-sm "
              />
            </template>
            <ActivityTable  class="-mx-6 -mb-6" />
          </Card>
        </div>

      </div>


  </div>
</template>
<script>
import Breadcrumb from "@/views/components/Breadcrumbs";
import Card from "@/components/Card";
import Icon from "@/components/Icon";
import window from "@/mixins/window";
import TransactionsTable from "@/components/TableTransaction";
import ActivityTable from "@/components/TableActivity";
import axios from 'axios';
import { useToast } from "vue-toastification";
export default {
  mixins: [window],
  components: {
    Breadcrumb,
    Card,
    Icon,
    TransactionsTable,
    ActivityTable
  },
  data() {
    return {
      information: "",
      statistics: [
        {
          title: "Active User",
          count: "0",
          bg: "bg-[#E5F9FF] dark:bg-slate-900	",
          text: "text-info-500",
          icon: "heroicons:users",
        },
        {
          title: "Pending KYC",
          count: "0",
          bg: "bg-[#E5F9FF] dark:bg-slate-900	",
          text: "text-info-500",
          icon: "heroicons:cube",
        },
        {
          title: "Pending Tickets",
          count: "0",
          bg: "bg-[#E5F9FF] dark:bg-slate-900	",
          text: "text-info-500",
          icon: "heroicons:cube",
        },
        {
          title: "Deposit Requests",
          count: "0",
          bg: "bg-[#E5F9FF] dark:bg-slate-900	",
          text: "text-info-500",
          icon: "heroicons:cube",
        },
        {
          title: "Withdraw Requests",
          count: "0",
          bg: "bg-[#FFEDE6] dark:bg-slate-900	",
          text: "text-warning-500",
          icon: "heroicons:arrow-trending-up-solid",
        },
        {
          title: "Loan Requests",
          count: "0",
          bg: "bg-[#FFEDE6] dark:bg-slate-900	",
          text: "text-warning-500",
          icon: "heroicons:arrow-trending-up-solid",
        },
        {
          title: "FDR Requests",
          count: "0",
          bg: "bg-[#FFEDE6] dark:bg-slate-900	",
          text: "text-warning-500",
          icon: "heroicons:arrow-trending-up-solid",
        },
        {
          title: "Wire Transfer Requests",
          count: "0",
          bg: "bg-[#FFEDE6] dark:bg-slate-900	",
          text: "text-warning-500",
          icon: "heroicons:arrow-trending-up-solid",
        },
        {
          title: "Total Deposit",
          count: "0",
          bg: "bg-[#EAE6FF] dark:bg-slate-900	",
          text: "text-[#5743BE]",
          icon: "ph:currency-dollar-bold",
        },
        {
          title: "Total Withdrawal",
          count: "0",
          bg: "bg-[#EAE6FF] dark:bg-slate-900	",
          text: "text-[#5743BE]",
          icon: "ph:currency-dollar-bold",
        },
        {
          title: "Total Loan",
          count: "0",
          bg: "bg-[#EAE6FF] dark:bg-slate-900	",
          text: "text-[#5743BE]",
          icon: "ph:currency-dollar-bold",
        },
        {
          title: "Total Exchange",
          count: "0",
          bg: "bg-[#EAE6FF] dark:bg-slate-900	",
          text: "text-[#5743BE]",
          icon: "ph:currency-dollar-bold",
        },
      ],
      transactions:"",
      notifications: ""
    }
  },
  mounted() {
    this.dashboard();
  },
  methods: {
    format_date(value) {
      return moment(value).format("Do-MMM-YYYY hh:mm A");
    },
    dashboard() {

      let $this = this
      const toast = useToast();

      axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/dashboard`, {}, {
        headers: {
          "Authorization": "Bearer " + this.$store.authStore.user.token
        }
      }).then(function (response) {

        if (response.data?.status) {
          $this.information = response.data?.data;

          $this.statistics[0].count = parseFloat($this.information.active_users).toLocaleString("en-US");
          $this.statistics[1].count = parseFloat($this.information.pending_kyc).toLocaleString("en-US");
          $this.statistics[2].count = parseFloat($this.information.pending_ticket).toLocaleString("en-US");
          $this.statistics[3].count = parseFloat($this.information.deposit_request).toLocaleString("en-US");
          $this.statistics[4].count = parseFloat($this.information.pending_withdraw).toLocaleString("en-US");
          $this.statistics[5].count = parseFloat($this.information.pending_loan).toLocaleString("en-US");
          $this.statistics[6].count = parseFloat($this.information.total_fixed).toLocaleString("en-US");
          $this.statistics[7].count = parseFloat($this.information.wire_amount).toLocaleString("en-US");
          $this.statistics[8].count = parseFloat($this.information.deposit_amount).toLocaleString("en-US");
          $this.statistics[9].count = parseFloat($this.information.withdraw_amount).toLocaleString("en-US");
          $this.statistics[10].count = parseFloat($this.information.loan_amount).toLocaleString("en-US");
          $this.statistics[11].count = parseFloat($this.information.exchange_amount).toLocaleString("en-US");
          $this.transactions = $this.information.transactions;
          $this.notifications = $this.information.notifications;


        } else {
          // let message = response.data?.message[0];
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
        toast.error("Error  ", {
          timeout: 5000,
        });
      });
    }
  }
}
</script>
<style lang=""></style>
