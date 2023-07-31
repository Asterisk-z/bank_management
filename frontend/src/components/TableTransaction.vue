<template>
    <div>
        <template v-if="transactions">
            <vue-good-table :columns="columns" styleClass=" vgt-table  lesspadding2   v-middle" :rows="transactions"
                :pagination-options="{
                    enabled: false,
                    perPage: perpage,
                }" :sort-options="{
    enabled: false,
}">
                <template v-slot:table-row="props">
                    <div v-if="props.column.field == 'user'" class="flex items-center">
                        <div class="flex-none">
                            <div class="w-8 h-8 rounded-[100%] ltr:mr-2 rtl:ml-2">
                                <img :src="props.row.user.image" alt="" class="w-full h-full rounded-[100%] object-cover" />
                            </div>
                        </div>
                        <div class="flex-1 text-start">
                            <h4 class="text-sm font-medium text-slate-600">
                                {{ props.row.user.name }}
                            </h4>
                        </div>
                    </div>
                            <span v-if="props.column.field == 'amount'" class="font-medium">
                                {{ props.row.currency + " " + parseFloat(props.row.amount).toLocaleString("en-US") }}
                            </span>

                            <span v-if="props.column.field == 'status'" class="block w-full">
                                <span
                                    class="inline-block px-3 min-w-[90px] text-center mx-auto py-1 rounded-[999px] bg-opacity-25"
                                    :class="`${props.row.status === 'approved'
                                        ? 'text-success-500 bg-success-500'
                                        : ''
                                        } 
                                                                                                                    ${props.row.status === 'pending' || props.row.status === 'awaiting_otp'
                                            ? 'text-warning-500 bg-warning-500'
                                            : ''
                                        }
                                                                                                                    ${props.row.status === 'declined'
                                            ? 'text-danger-500 bg-danger-500'
                                            : ''
                                        }  `">
                                    {{ props.row.status }}
                                </span>
                            </span>
                </template>
                <template #pagination-bottom="props">
                    <div class="py-4 px-3 flex justify-center">
                        <Pagination :total="transactions.length" :current="current" :per-page="perpage" :pageRange="pageRange"
                            @page-changed="current = $event" :pageChanged="props.pageChanged"
                            :perPageChanged="props.perPageChanged" :options="options">
                            >
                        </Pagination>
                    </div>
                </template>
            </vue-good-table>
        </template>
        
    </div>
</template>
<script>
import Pagination from "@/components/Pagination";
import axios from 'axios';
import { useToast } from "vue-toastification";

export default {
    components: {
    
        Pagination,
    },

    data() {
        return {
            transactions: "",
            information: "",
            current: 1,
            perpage: 10,
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
                    label: "Transaction Ref",
                    field: "transaction_ref",
                },

                {
                    label: "Type",
                    field: "type",
                },

                {
                    label: "Amount",
                    field: "amount",
                },
                {
                    label: "Status",
                    field: "status",
                },
            ],
        };
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

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/dashboard_transaction`, {}, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {
                    $this.information = response.data?.data;

                    $this.transactions = $this.information.transactions;


                } else {
                    // let message = response.data?.message[0];
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
};
</script>
<style lang="scss"></style>
