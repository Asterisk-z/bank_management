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
            <!-- <TransactionsTable class="-mx-6 -mb-6" /> -->
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
            <!-- <ActivityTable class="-mx-6 -mb-6" /> -->
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
    }
  }
}
</script>
<style lang=""></style>
