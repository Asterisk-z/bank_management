<template>
    <div>
        <Card noborder>
            <div class="md:flex pb-6 items-center">
                <h6 class="flex-1 md:mb-0 mb-3">Transaction</h6>
                <div class="md:flex md:space-x-3 items-center flex-none rtl:space-x-reverse"
                    :class="window.width < 768 ? 'space-x-rb' : ''">
                    <InputGroup v-model="searchTerm" placeholder="Search" type="text" prependIcon="heroicons-outline:search" merged />
                </div>
            </div>
            <div class="-mx-6">
                <template v-if="transactions">
                <vue-good-table :columns="columns" styleClass=" vgt-table  centered " :rows="transactions" :sort-options="{
                    enabled: false,
                }" :pagination-options="{
    enabled: true,
    perPage: perpage,
}" :search-options="{
    enabled: true,
    externalQuery: searchTerm,
}" >
                        <template v-slot:table-row="props">
                            <span v-if="props.column.field == 'amount'" class="font-medium">
                                {{ props.row.currency + " " + parseFloat(props.row.amount).toLocaleString("en-US") }}
                            </span>
                            <span v-if="props.column.field == 'fee'" class="font-medium">
                                {{ props.row.currency + " " + parseFloat(props.row.fee).toLocaleString("en-US") }}
                            </span>
                                <span v-if="props.column.field == 'type'" class="block w-full">
                                    <span>
                                        {{ props.row.type.replace('_', ' ') }}
                                    </span>
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
                        <template #pagination-bottom="props">
                            <div class="py-4 px-3">
                                <Pagination :total="transactions.length" :current="current" :per-page="perpage" :pageRange="pageRange"
                                    @page-changed="current = $event" :pageChanged="props.pageChanged"
                                    :perPageChanged="props.perPageChanged" enableSearch enableSelect :options="options">
                                    >
                                </Pagination>
                            </div>
                        </template>
                    </vue-good-table>
                </template>
                
            </div>
        </Card>
    </div>
</template>
<script>
import Dropdown from "@/components/Dropdown";
import Button from "@/components/Button";
import Card from "@/components/Card";
import Icon from "@/components/Icon";
import InputGroup from "@/components/InputGroup";
import Pagination from "@/components/Pagination";
import { MenuItem } from "@headlessui/vue";
import window from "@/mixins/window";
import axios from 'axios';
import { useToast } from "vue-toastification";

export default {
    mixins: [window],
    components: {
        Pagination,
        InputGroup,
        Dropdown,
        Icon,
        Card,
        MenuItem,
        Button,
    },

    data() {
        return {
            current: 1,
            perpage: 10,
            pageRange: 5,
            searchTerm: "",
            transactions: "",
            actions: [
                {
                    name: "delete",
                    icon: "heroicons-outline:trash",
                    doit: () => { },
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
                    label: "Amount",
                    field: "amount",
                },

                {
                    label: "Fee",
                    field: "fee",
                },

                {
                    label: "Type",
                    field: "type",
                },
                {
                    label: "Process",
                    field: "process",
                },
                {
                    label: "Status",
                    field: "status",
                },
                // {
                //     label: "Action",
                //     field: "action",
                // },
            ],
        };
    },
    mounted() {
        const $this = this

            const toast = useToast();
        const fromData = new FormData();
        fromData.append("user_id", $this.$route.params.user_id);
        axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/user_transactions`, fromData, {
            headers: {
                "Authorization": "Bearer " + this.$store.authStore.user.token
            }
        }).then(function (response) {

            if (response.data?.status) {
                // toast.success("User Found", {
                //     timeout: 4000,
                // });
                $this.transactions = response.data.transactions
            } else {
                let message = response.data?.message[0];
                toast.error(message, {
                    timeout: 4000,
                });
            }
        }).catch(function (result) {
            if (result.response?.data?.error == 'Unauthorized') {
                $this.$router.push({ name: 'Login' })
            }
        });
    }
};
</script>
<style lang="scss"></style>
