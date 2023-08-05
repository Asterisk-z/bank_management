<template>
    <div class="space-y-5">
        <Card>
            <div class="flex justify-between mb-6">
                <h4 class="text-slate-900 text-xl font-medium">Manual Method</h4>
            </div>
            <div class="grid xl:grid-cols-4 md:grid-cols-2 grid-cols-1 gap-5">
                <div class="price-table bg-opacity-[0.16] dark:bg-opacity-[0.36] rounded-[6px] p-6 text-slate-900 dark:text-white relative overflow-hidden z-[1]"
                    :class="item.bg" v-for="(item, i) in tables" :key="i">
                    <div v-if="item.ribon"
                        class="text-sm font-medium bg-slate-900 dark:bg-slate-900 text-white py-2 text-center absolute ltr:-right-[43px] rtl:-left-[43px] top-6 px-10 transform ltr:rotate-[45deg] rtl:-rotate-45">
                        {{ item.ribon }}
                    </div>
                    <header class="mb-6">
                        <h4 class="text-xl mb-5">{{ item.title }}</h4>
                    </header>
                    <div class="price-body space-y-8">
                        <p class="text-sm leading-5 text-slate-600 dark:text-slate-300">
                            {{ item.limit }} <br />{{ item.charge }}
                        </p>
                        <div>
                            <Button :text="item.button" btnClass="btn-outline-dark dark:border-slate-400 w-full"
                                @click="item.doit()" />
                        </div>
                    </div>
                </div>
            </div>
        </Card>

    </div>
</template>
<script>
import Button from "@/components/Button";
import Breadcrumb from "@/views/components/Breadcrumbs";
import Card from "@/components/Card";

export default {
    components: {
        Card,
        Breadcrumb,
        Button,
    },
    data() {
        return {
            check: true,
            tables: [
                {
                    title: "Payoneer",
                    price_Yearly: "$126",
                    price_Monthly: "$16",
                    limit: "Withdraw Limit($50.00 - $10,000.00)",
                    charge: "Withdraw Charge($0.00 + 1.00 %)",
                    button: "Withdraw",
                    bg: "bg-primary-500",
                    doit: () => {
                        this.$router.push({name : 'withdraw'});
                    }
                },
                {
                    title: "Plaid",
                    price_Yearly: "$126",
                    price_Monthly: "$16",
                    limit: "Withdraw Limit($50.00 - $10,000.00)",
                    charge: "Withdraw Charge($0.00 + 1.00 %)",
                    button: "Withdraw",
                    bg: "bg-primary-500",
                    doit: () => {
                        this.$router.push({ name: 'withdraw' });
                    }
                },
            ],
        };
    },
    methods: {
        toggle() {
            this.check = !this.check;
        },
    },
};
</script>
<style lang=""></style>
