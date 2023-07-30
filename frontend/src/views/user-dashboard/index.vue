<template>
    <div>
        <div class="grid grid-cols-12 gap-5 mb-5">
            <div class="2xl:col-span-8 lg:col-span-12 md:col-span-12 col-span-12">
                <Card bodyClass="p-4">
                    <div class="grid lg:grid-cols-2 md:grid-cols-1 grid-cols-1 gap-4 mb-5">
                        <div v-for="(item, i) in statistics1" :key="i">
                            <Card :bodyClass="`pt-4 pb-3 px-4 ${item.bg} rounded-lg h-[180px]` ">
                                <div class="flex space-x-3 rtl:space-x-reverse">
                                    <div class="flex-1">
                                        <div class="text-slate-600 dark:text-slate-300 text-[15px] font-medium ml-6 mb-3 mt-2">
                                            {{ item.title }}
                                        </div>
                                        <div class="text-slate-900 dark:text-white text-[25px] font-medium ml-6 mb-3">
                                            {{ item.sign+ " " +item.count }}
                                        </div>
                                        <div class="flex text-yellow-600 dark:text-yellow-600 text-[16px] font-medium  ml-6 mb-3">
                                            <!-- <Icon :icon="item.iconr"/>  -->
                                            <!-- <span class="text-[12px] ml-2">{{ item.stat }}</span> -->
                                        </div>
                                    </div>
                                    <div class="flex-none">
                                        <Chart :type="item.chartType" :option="item.chart.chartOptions" :series="item.chart.series" :height="item.chartHeight" :width="item.chartWeight"/>
                                    </div>
                                </div>
                            </Card>
                        </div>
                    </div>
                    
                    <!-- <Card title="Loan Transactions" noborder>
                        <LoanTable class="-mx-2 -mb-6" />
                    </Card> -->
                    <Card title="Recent Transactions" noborder>
                        <!-- <TransactionTable class="-mx-2 -mb-6" :table_data="information.recent_transaction" /> -->
                        <template v-if="transactions">
                            <vue-good-table :columns="columns" styleClass=" vgt-table  lesspadding2   v-middle" :rows="transactions" :sort-options="{
                                enabled: false,
                            }">
                                <template v-slot:table-row="props">
                                    <div v-if="props.column.field == 'amount'" class="flex items-center">
                                        <div class="flex-1 text-start">
                                            <h4 class="text-sm font-medium text-slate-600">
                                                {{ props.row.currency + " " + parseFloat(props.row.amount).toLocaleString("en-US") }}
                                            </h4>
                                        </div>
                                    </div>
                                
                                    <span v-if="props.column.field == 'created_at'">
                                        <template v-if="props.row.created_at">
                                            {{ format_date(props.row.created_at) }}
                                        </template>
                                    </span>
                                    <span v-if="props.column.field == 'status'" class="block w-full">
                                        <span class="inline-block px-3 min-w-[90px] text-center mx-auto py-1 rounded-[999px] bg-opacity-25"
                                            :class="`${props.row.status === 'approved'
                                                ? 'text-success-500 bg-success-500'
                                                : ''
                                                } ${props.row.status === 'due' || props.row.status === 'awaiting_otp'
                                                    ? 'text-warning-500 bg-warning-500'
                                                    : ''
                                                }${props.row.status === 'pending' 
                                                    ? 'text-danger-500 bg-danger-500'
                                                    : ''
                                                }${props.row.status === 'canceled'
                                                    ? 'text-danger-500 bg-danger-500'
                                                    : ''
                                                }${props.row.status === 'shipped'
                                                    ? 'text-primary-500 bg-primary-500'
                                                    : ''
                                                }

                                                `">
                                            {{ props.row.status.replace('_', ' ')  }}
                                        </span>
                                    </span>
                                    <span v-if="props.column.field == 'process'" class="block w-full">
                                        <span class="inline-block px-3 min-w-[90px] text-center mx-auto py-1 rounded-[999px] bg-opacity-25"
                                            :class="`${props.row.process === 'credit'
                                                ? 'text-success-500 bg-success-500'
                                                : ''
                                                } ${props.row.process === 'debit'
                                                    ? 'text-danger-500 bg-danger-500'
                                                    : ''
                                                }

                                                `">
                                            {{ props.row.process }}
                                        </span>
                                    </span>
                                </template>
                            </vue-good-table>
                        </template>
                    </Card>
                </Card> 
                

            </div>
            <div class="2xl:col-span-4 lg:col-span-12 md:col-span-12 col-span-12 ">
                <div class=" flex justify-center items-center">
                    <div class="space-y-5">

                        <div class=" rounded-md bg-white dark:bg-slate-800 lg:h-full px-5 py-8  flex items-center" >
                            <div class="flex-1">
                                <div class="max-w-[180px]">
                                    <h4 class="text-2xl font-medium text-white mb-2">
                                        <span class="block text-sm text-slate-600 dark:text-slate-300">Card Limit</span>
                                        <span class="block text-slate-600 dark:text-slate-300">{{ '$' + card_balance }}</span>
                                    </h4>
                                </div>
                            </div>
                            <div class="flex-none">
                                <Button icon="heroicons-outline:eye" text="View" btnClass="btn-primary bg-primary btn-sm " v-if="card_balance != 0"/>
                            </div>
                        </div>
                        
                        <div class="w-[450px] h-56 m-auto bg-red-100 rounded-xl relative text-white shadow-2xl">
                
                            <img class="object-cover w-[450px] h-full rounded-xl" src="@/assets/images/card/green-slate.jpg">
                
                            <div class="w-full px-8 absolute top-8">
                                <div class="flex justify-between">
                                    <img class="w-8 h-8" src="@/assets/images/card/small_white.png"/>
                                    <!-- <img class="w-14 h-14 mt-[-10px]" src="https://i.imgur.com/bbPHJVe.png"/> -->
                                </div>
                            </div>
                            <div class="w-full px-8 absolute bottom-5">
                                
                                <div class="pt-0">
                                    <p class="font-light  text-xs">
                                        Card Number
                                    </p>
                                    <p class="font-medium tracking-more-wider tracking-[.25em]">
                                        <span class="mr-2">{{ card_number[0] }}</span>   <span class="mr-2">XXXX</span>   <span class="mr-2">XXXX</span>   <span class="mr-2">XXXX</span>
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
                        
                    </div>
                </div>
                
                <div class="xl:col-span-12 col-span-12 mt-10 ">
                    <Card title="Activities" noborder bodyClass="bg-transparent p-6">
                        <ReminderTable class="-mx-2 -mb-6" :table_data="information.recent_notification"/>
                    </Card>
                </div>
            </div>

        </div>

        

    </div>
</template>
<script>
import Breadcrumb from "@/views/components/Breadcrumbs";
import Card from "@/components/Card";
import Icon from "@/components/Icon";
import window from "@/mixins/window";
import LoanTable from "@/views/user-dashboard/components/dashboard-loan-table.vue";
import ReminderTable from "@/views/user-dashboard/components/reminder-table.vue";
import TransactionTable from "@/views/user-dashboard/components/dashboard-transaction-table.vue";
import Button from "@/components/Button";
import Chart from "@/views/user-dashboard/components/chart.vue";
import { useToast } from "vue-toastification";
import axios from 'axios';
import moment from 'moment';

export default {
    mixins: [window],
    components: {
        Breadcrumb,
        Card,
        Icon,
        LoanTable,
        ReminderTable,
        TransactionTable,
        Button,
        Chart
    },
    data() {
        return {
            statistics1: [
                {
                    title: "Total Balance",
                    count: "0",
                    bg: "bg-[#E5F9FF] dark:bg-slate-900	",
                    text: "text-info-500",
                    icon: "heroicons:users",
                    iconr: "",
                    stat: '',
                    sign: '$',
                    chart: {

                        series: [44, 55],
                        chartOptions: {
                            chart: {
                                height: 500,
                                type: 'radialBar',
                            },
                            plotOptions: {
                                radialBar: {
                                    dataLabels: {
                                        name: {
                                            fontSize: '0px',
                                        },
                                        value: {
                                            fontSize: '0px',
                                        },
                                        total: {
                                            show: false,
                                            label: "+15%",
                                            formatter: function (w) {
                                                // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                                                return "ff"
                                            }
                                        }
                                    }
                                }
                            },
                            labels: ['', ''],
                            colors: ['#CA8A0A', '#CA0000'],
                        },


                    },
                    chartType: 'radialBar',
                    chartHeight: '150',
                    chartWeight: '114',
                },
                {
                    title: "AUD Balance",
                    count: "0.00",
                    bg: "bg-[#E5F9FF] dark:bg-slate-900	",
                    text: "text-info-500",
                    icon: "heroicons:users",
                    sign: 'A$',
                    iconr: "",
                    stat: '',
                    chart: {
                        series: [
                            {
                                name: "",
                                data: [40, 70, 45, 100, 75, 40, 80, 90],
                            },
                        ],
                        chartOptions: {
                            chart: {
                                toolbar: {
                                    show: false,
                                },
                                offsetX: 0,
                                offsetY: 0,
                                zoom: {
                                    enabled: false,
                                },
                                sparkline: {
                                    enabled: true,
                                },
                            },
                            plotOptions: {
                                bar: {
                                    columnWidth: "60px",
                                    barHeight: "100%",
                                },
                            },
                            legend: {
                                show: false,
                            },

                            dataLabels: {
                                enabled: false,
                            },
                            stroke: {
                                curve: "smooth",
                                width: 2,
                            },

                            fill: {
                                opacity: 1,
                            },
                            tooltip: {
                                y: {
                                    formatter: function (val) {
                                        return  "$ " + val + "k";
                                    },
                                },
                            },
                            yaxis: {
                                show: false,
                            },
                            xaxis: {
                                show: false,
                                labels: {
                                    show: false,
                                },
                                axisBorder: {
                                    show: false,
                                },
                                axisTicks: {
                                    show: false,
                                },
                            },
                            colors: "#CA8A0A",
                            grid: {
                                show: false,
                            },
                        },
                    },
                    chartType: 'bar',
                    chartHeight: '110',
                    chartWeight: '114',
                },
                {
                    title: "USD Balance",
                    count: "0.00",
                    bg: "bg-[#E5F9FF] dark:bg-slate-900	",
                    text: "text-info-500",
                    icon: "heroicons:users",
                    iconr: "",
                    stat: '',
                    sign: '$',
                    chart: {
                        series: [
                            {
                                name: "",
                                data: [40, 70, 45, 100, 75, 40, 80, 90],
                            },
                        ],
                        chartOptions: {
                            chart: {
                                toolbar: {
                                    show: false,
                                },
                                offsetX: 0,
                                offsetY: 0,
                                zoom: {
                                    enabled: false,
                                },
                                sparkline: {
                                    enabled: true,
                                },
                            },
                            plotOptions: {
                                bar: {
                                    columnWidth: "60px",
                                    barHeight: "100%",
                                },
                            },
                            legend: {
                                show: false,
                            },

                            dataLabels: {
                                enabled: false,
                            },
                            stroke: {
                                curve: "smooth",
                                width: 2,
                            },

                            fill: {
                                opacity: 1,
                            },
                            tooltip: {
                                y: {
                                    formatter: function (val) {
                                        return "$ " + val + "k";
                                    },
                                },
                            },
                            yaxis: {
                                show: false,
                            },
                            xaxis: {
                                show: false,
                                labels: {
                                    show: false,
                                },
                                axisBorder: {
                                    show: false,
                                },
                                axisTicks: {
                                    show: false,
                                },
                            },
                            colors: "#CA8A0A",
                            grid: {
                                show: false,
                            },
                        },
                    },
                    chartType: 'bar',
                    chartHeight: '110',
                    chartWeight: '114',
                },
                {
                    title: "EUR Balance",
                    count: "0.00",
                    bg: "bg-[#E5F9FF] dark:bg-slate-900	",
                    text: "text-info-500",
                    icon: "heroicons:users",
                    iconr: "",
                    sign: '€',
                    stat: '',
                    chart: {
                        series: [
                            {
                                name: "",
                                data: [40, 70, 45, 100, 75, 40, 80, 90],
                            },
                        ],
                        chartOptions: {
                            chart: {
                                toolbar: {
                                    show: false,
                                },
                                offsetX: 0,
                                offsetY: 0,
                                zoom: {
                                    enabled: false,
                                },
                                sparkline: {
                                    enabled: true,
                                },
                            },
                            plotOptions: {
                                bar: {
                                    columnWidth: "60px",
                                    barHeight: "100%",
                                },
                            },
                            legend: {
                                show: false,
                            },

                            dataLabels: {
                                enabled: false,
                            },
                            stroke: {
                                curve: "smooth",
                                width: 2,
                            },

                            fill: {
                                opacity: 1,
                            },
                            tooltip: {
                                y: {
                                    formatter: function (val) {
                                        return "$ " + val + "k";
                                    },
                                },
                            },
                            yaxis: {
                                show: false,
                            },
                            xaxis: {
                                show: false,
                                labels: {
                                    show: false,
                                },
                                axisBorder: {
                                    show: false,
                                },
                                axisTicks: {
                                    show: false,
                                },
                            },
                            colors: "#CA8A0A",
                            grid: {
                                show: false,
                            },
                        },
                    },
                    chartType: 'bar',
                    chartHeight: '110',
                    chartWeight: '114',
                },
            ],
            chartOne: {

                series: [44, 55, 67, 83],
                chartOptions: {
                    chart: {
                        height: 350,
                        type: 'radialBar',
                    },
                    plotOptions: {
                        radialBar: {
                            dataLabels: {
                                name: {
                                    fontSize: '22px',
                                },
                                value: {
                                    fontSize: '16px',
                                },
                                total: {
                                    show: true,
                                    label: 'Total',
                                    formatter: function (w) {
                                        // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                                        return 249
                                    }
                                }
                            }
                        }
                    },
                    labels: ['Apples', 'Oranges', 'Bananas', 'Berries'],
                },


            },
            information: "",
            card_balance: 0.00,
            card_number: '',
            transactions: [],
            columns: [
                {
                    label: "Transaction Ref",
                    field: "transaction_ref",
                },

                {
                    label: "Amount",
                    field: "amount",
                },
                {
                    label: "Process",
                    field: "process",
                },
                {
                    label: "Method",
                    field: "method",
                },
                {
                    label: "Status",
                    field: "status",
                },
                {
                    label: "Date",
                    field: "created_at",
                },
            ],
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

            axios.post(`${import.meta.env.VITE_APP_API_URL}/customer/dashboard`, {}, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {
                
                if (response.data?.status) {
                    $this.information = response.data?.data;

                    $this.statistics1[0].count =  $this.information.last_transaction ? parseFloat($this.information.total_balance).toLocaleString("en-US") : "0"; 
                    $this.transactions = $this.information.recent_transaction ?  $this.information.recent_transaction : [];
                    $this.statistics1[0].stat = "";
                    $this.statistics1[1].count =  parseFloat($this.information.account_details?.aud_balance).toLocaleString("en-US");
                    $this.statistics1[2].count =  parseFloat($this.information.account_details?.usd_balance).toLocaleString("en-US");
                    $this.statistics1[3].count = parseFloat($this.information.account_details?.eur_balance).toLocaleString("en-US");
                    $this.statistics1[3].count = parseFloat($this.information.account_details?.eur_balance).toLocaleString("en-US");
                    $this.card_balance = $this.information.account_details?.first_card_balance
                    $this.card_number = $this.information.account_details.first_card_number.match(/.{1,4}/g);


                } else {
                    let message = response.data?.message[0];
                    toast.error(message, {
                        timeout: 4000,
                    });
                }
            }).catch(function (error) {
                console.log(error)
                toast.error("Error  ", {
                    timeout: 5000,
                });
            });
        }
    }
}
</script>
<style lang=""></style>
