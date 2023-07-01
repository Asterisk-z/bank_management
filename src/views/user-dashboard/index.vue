<template>
    <div>
        <Breadcrumb />

        <div class="grid grid-cols-12 gap-5 mb-5">
            <div class="2xl:col-span-8 lg:col-span-8 col-span-8">
                <Card bodyClass="p-4">
                    <div class="grid md:grid-cols-2 grid-cols-2 gap-4 mb-5">
                        <div v-for="(item, i) in statistics1" :key="i">
                            <Card :bodyClass="`pt-4 pb-3 px-4 ${item.bg} rounded-lg h-[180px]` ">
                                <div class="flex space-x-3 rtl:space-x-reverse">
                                    <div class="flex-1">
                                        <div class="text-slate-600 dark:text-slate-300 text-[15px] font-medium ml-6 mb-3 mt-2">
                                            {{ item.title }}
                                        </div>
                                        <div class="text-slate-900 dark:text-white text-[35px] font-medium ml-6 mb-3">
                                            {{ "$"+item.count }}
                                        </div>
                                        <div class="flex text-yellow-600 dark:text-yellow-600 text-[16px] font-medium  ml-6 mb-3">
                                            <Icon :icon="item.iconr"/> 
                                            <span class="text-[12px] ml-2">{{ item.stat }}</span>
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
                        <TransactionTable class="-mx-2 -mb-6" />
                    </Card>
                </Card> 
                

            </div>
            <div class="2xl:col-span-4 lg:col-span-4 col-span-4 ">
                <div class=" flex justify-center items-center">
                    <div class="space-y-5">

                        <div class=" rounded-md bg-white dark:bg-slate-800 lg:h-full px-5 py-8  flex items-center" >
                            <div class="flex-1">
                                <div class="max-w-[180px]">
                                    <h4 class="text-2xl font-medium text-white mb-2">
                                        <span class="block text-sm text-slate-600 dark:text-slate-300">Card balance</span>
                                        <span class="block text-slate-600 dark:text-slate-300">$34,564</span>
                                    </h4>
                                </div>
                            </div>
                            <div class="flex-none">
                                <Button icon="heroicons-outline:eye" text="Offset" btnClass="btn-light bg-white btn-sm "/>
                            </div>
                        </div>
                        
                        <div class="w-100 h-56 m-auto bg-red-100 rounded-xl relative text-white shadow-2xl">
                
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
                                        <span class="mr-2">7632</span>   <span class="mr-2">7632</span>   <span class="mr-2">7632</span>   <span class="mr-2">7632</span>
                                    </p>
                                </div>
                                <div class="pt-2 pr-6">
                                    <div class="flex justify-start gap-10">
                                        <div class="">
                                            <p class="font-light text-xs">
                                                Name
                                            </p>
                                            <p class="font-medium tracking-wider text-sm">
                                                Olang Daniel
                                            </p>
                                        </div>
                                        <div class="">
                                            <p class="font-light text-xs">
                                                Exp. Date
                                            </p>
                                            <p class="font-medium tracking-wider text-sm">
                                                03/25
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
                
                <div class="xl:col-span-12 col-span-12 mt-10">
                    <Card title="Reminders" noborder bodyClass="bg-transparent p-6">
                        <ReminderTable class="-mx-2 -mb-6" />
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
                    title: "Overview Total Balance",
                    count: "3,564",
                    bg: "bg-[#E5F9FF] dark:bg-slate-900	",
                    text: "text-info-500",
                    icon: "heroicons:users",
                    iconr: "heroicons:arrow-trending-up-solid",
                    stat: 'per month in a year 2023',
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
                    chartHeight: '180',
                    chartWeight: '124',
                },
                {
                    title: "AUD Balance",
                    count: "3,564",
                    bg: "bg-[#E5F9FF] dark:bg-slate-900	",
                    text: "text-info-500",
                    icon: "heroicons:users",
                    iconr: "heroicons:arrow-trending-up-solid",
                    stat: 'per week',
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
                    chartHeight: '120',
                    chartWeight: '124',
                },
                {
                    title: "USD Balance",
                    count: "3,564",
                    bg: "bg-[#E5F9FF] dark:bg-slate-900	",
                    text: "text-info-500",
                    icon: "heroicons:users",
                    iconr: "heroicons:arrow-trending-up-solid",
                    stat: 'per week',
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
                    chartHeight: '120',
                    chartWeight: '124',
                },
                {
                    title: "EUR Balance",
                    count: "3,564",
                    bg: "bg-[#E5F9FF] dark:bg-slate-900	",
                    text: "text-info-500",
                    icon: "heroicons:users",
                    iconr: "heroicons:arrow-trending-up-solid",
                    stat: 'per week',
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
                    chartHeight: '120',
                    chartWeight: '124',
                },
            ],
            statistics2: [
                {
                    title: "USD Balance",
                    count: "564",
                    bg: "bg-[#E5F9FF] dark:bg-slate-900	",
                    text: "text-info-500",
                    icon: "heroicons:cube",
                },
                {
                    title: "EUR Balance",
                    count: "564",
                    bg: "bg-[#E5F9FF] dark:bg-slate-900	",
                    text: "text-info-500",
                    icon: "heroicons:cube",
                },
                {
                    title: "AUD Balance",
                    count: "564",
                    bg: "bg-[#E5F9FF] dark:bg-slate-900	",
                    text: "text-info-500",
                    icon: "heroicons:cube",
                },
            ],
            statistics3: [
                {
                    title: "Active Loan",
                    count: "564",
                    bg: "bg-[#E5F9FF] dark:bg-slate-900	",
                    text: "text-warning-500",
                    icon: "heroicons:arrow-trending-up-solid",
                },
                {
                    title: "Payment Requests",
                    count: "564",
                    bg: "bg-[#FFEDE6] dark:bg-slate-900	",
                    text: "text-warning-500",
                    icon: "heroicons:arrow-trending-up-solid",
                },
                {
                    title: "Active Fixed Deposits",
                    count: "564",
                    bg: "bg-[#FFEDE6] dark:bg-slate-900	",
                    text: "text-warning-500",
                    icon: "heroicons:arrow-trending-up-solid",
                },
                {
                    title: "Active Tickets",
                    count: "564",
                    bg: "bg-[#FFEDE6] dark:bg-slate-900	",
                    text: "text-warning-500",
                    icon: "heroicons:arrow-trending-up-solid",
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
        }
    }
}
</script>
<style lang=""></style>
