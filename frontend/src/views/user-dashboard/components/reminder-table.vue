<template>
    <div>
            <Card  bodyClass="m-2" v-for="notify in table_data" v-bind:key="notify">
                <div class="rounded-md bg-white dark:bg-slate-800 p-4 relative border-l-4 border-indigo-500 "   >
                    <div class="max-w-full">
                        <p class="text-[12px] font-medium text-slate-900 dark:text-white mb-1">
                            {{ Object.values(notify.data)[0] }}
                        </p>
                        <p class="text-[10px] text-slate-600 dark:text-slate-300 text-opacity-80">
                           {{ fromNow(notify.created_at) }}
                        </p>
                    </div>
                </div>
            </Card>
    </div>
</template>
<script>

import Card from "@/components/Card";
import moment from 'moment';
export default {
    props: {
        table_data: {
            type: Object,
            default: {},
        }
    },
    components: {
        Card  
    },
    methods: {
        fromNow(value) {
            return moment(value).fromNow();
        }
    },

    data() {
        return {
            transactions : [
                {
                    user: {
                        name: "Esther Howard"
                    },
                    transaction: "#324567",
                    price: "$90.99",
                    status: "paid",
                },
                {
                    user: {
                        name: "Guy Hawkins",
                    },
                    transaction: "#4224",
                    price: "$78.65",
                    status: "due",
                },
                {
                    user: {
                        name: "Bessie Cooper",
                    },
                    transaction: "#4224",
                    price: "$78.65",
                    status: "pending",
                },
                {
                    user: {
                        name: "Kathryn Murphy",
                    },
                    transaction: "#4224",
                    price: "$38.65",
                    status: "cancled",
                },
                {
                    user: {
                        name: "Darrell Steward",
                    },
                    transaction: "#4224",
                    price: "$178.65",
                    status: "shipped",
                }], 
            current: 1,
            perpage: 5,
            pageRange: 5,
            searchTerm: "",
            actions: [
                {
                    name: "view",
                    icon: "heroicons-outline:eye",
                },
                {
                    name: "edit",
                    icon: "heroicons:pencil-square",
                },
                {
                    name: "delete",
                    icon: "heroicons-outline:trash",
                },
            ],
            options: [
                {
                    value: "1",
                    label: "1",
                },
                {
                    value: "3",
                    label: "3",
                },
                {
                    value: "5",
                    label: "5",
                },
            ],
            columns: [
                {
                    label: "Loan ID",
                    field: "user",
                },
                {
                    label: "Action",
                    field: "status",
                },
            ],
        };
    },
};
</script>
<style lang="scss"></style>
