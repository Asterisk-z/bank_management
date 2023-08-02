<template>
    <div>
        <Card noborder>
            <div class="md:flex pb-6 items-center">
                <h6 class="flex-1 md:mb-0 mb-3">Transfer Requests</h6>
                <div class="md:flex md:space-x-3 items-center flex-none rtl:space-x-reverse"
                    :class="window.width < 768 ? 'space-x-rb' : ''">
                    <InputGroup v-model="searchTerm" placeholder="Search" type="text" prependIcon="heroicons-outline:search"
                        merged />
                    <Select label="" :options="values" v-model="selected" style="width: 200px" classInput="h-[36px]" @change="updateValue" />
                </div>
            </div>
            <div class="-mx-6">
                <template v-if="payment_requests">
                <vue-good-table :columns="columns" styleClass=" vgt-table  centered " :rows="payment_requests" :sort-options="{
                    enabled: false,
                }" :pagination-options="{
    enabled: true,
    perPage: perpage,
}" :search-options="{
    enabled: true,
    externalQuery: searchTerm,
}" :select-options="{
    enabled: true,
    selectOnCheckboxOnly: true, // only select when checkbox is clicked instead of the row
    selectioninfoClass: 'table-input-checkbox',
    selectionText: 'rows selected',
    clearSelectionText: 'clear',
    disableSelectinfo: true, // disable the select info-500 panel on top
    selectAllByGroup: true, // when used in combination with a grouped table, add a checkbox in the header row to check/uncheck the entire group
}">
                        <template v-slot:table-row="props">
                            <span v-if="props.column.field == 'benefactor'" class="flex flex-col items-center">
                                    <span class="text-sm text-slate-600 dark:text-slate-300 capitalize font-medium">{{
                                        props.row.name }}</span>
                                <span class="text-sm text-slate-600 dark:text-slate-300 capitalize font-medium">{{
                                    props.row.email }}</span>
                            </span>
                            <span v-if="props.column.field == 'user'" class="flex flex-col items-center">
                                <span class="text-sm text-slate-600 dark:text-slate-300 capitalize font-medium">{{
                                    props.row.user.name }}</span>
                                    <span class="text-sm text-slate-600 dark:text-slate-300 capitalize font-medium">{{
                                        props.row.user.email }}</span>
                            </span>
                            
                            <span v-if="props.column.field == 'amount'" class="font-medium">
                                {{ props.row.currency + " " + parseFloat(props.row.amount).toLocaleString("en-US") }}
                            </span>
                            <span v-if="props.column.field == 'status'" class="block w-full">
                                <span
                                    class="inline-block px-3 min-w-[90px] text-center mx-auto py-1 rounded-[999px] bg-opacity-25"
                                    :class="`${props.row.status === 'paid'
                                        ? 'text-success-500 bg-success-500'
                                        : ''
                                        } 
                                                                                ${props.row.status === 'pending'
                                            ? 'text-warning-500 bg-warning-500'
                                            : ''
                                        }
                                                                                ${props.row.status === 'canceled'
                                            ? 'text-danger-500 bg-danger-500'
                                            : ''
                                        }
            
             `">
                                    {{ props.row.status }}
                                </span>
                            </span>
                            <span v-if="props.column.field == 'action'">
                                        <template v-if="props.row.status == 'pending'">
                                <Dropdown classMenuItems=" w-[140px]">
                                    <span class="text-xl">
                                        <Icon icon="heroicons-outline:dots-vertical" />
                                    </span>
                                    <template v-slot:menus>
                                        <MenuItem v-for="(item, i) in actions" :key="i" >
                                            <div @click="item.doit(props.row.id)"
                                                :class="`
                    
                    ${item.name === 'reject'
                                                        ? 'bg-danger-500 text-danger-500 bg-opacity-30  hover:bg-opacity-100 hover:text-white'
                                                        : 'hover:bg-slate-900 hover:text-white'
                                                    }
                    w-full border-b border-b-gray-500 border-opacity-10 px-4 py-2 text-sm  last:mb-0 cursor-pointer first:rounded-t last:rounded-b flex  space-x-2 items-center rtl:space-x-reverse `">
                                                <span class="text-base">
                                                    <Icon :icon="item.icon" />
                                                </span>
                                                <span>{{ item.name }}</span>
                                            </div>
                                        </MenuItem>
                                       
                                    </template>
                                </Dropdown>
                                        </template>
                            </span>
                        </template>
                        <template #pagination-bottom="props">
                            <div class="py-4 px-3">
                                <Pagination :total="payment_requests.length" :current="current" :per-page="perpage" :pageRange="pageRange"
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
import Breadcrumb from "@/views/components/Breadcrumbs";
import Button from "@/components/Button";
import Card from "@/components/Card";
import Icon from "@/components/Icon";
import InputGroup from "@/components/InputGroup";
import Pagination from "@/components/Pagination";
import { MenuItem } from "@headlessui/vue";
import window from "@/mixins/window";
import axios from 'axios';
import { useToast } from "vue-toastification";
import Select from "@/components/Select";

export default {
    mixins: [window],
    components: {
        Pagination,
        Breadcrumb,
        InputGroup,
        Dropdown,
        Icon,
        Card,
        Select,
        MenuItem,
        Button
    },

    data() {
        return {
            selected: "all", 
            values: [
                {
                    value: "all",
                    label: "All",
                },
                {
                    value: "paid",
                    label: "Paid",
                },
                {
                    value: "rejected",
                    label: "Rejected",
                },
            ],
            current: 1,
            perpage: 10,
            pageRange: 5,
            searchTerm: "",
            payment_requests: "",
            actions: [
                {
                    name: "reject",
                    icon: "heroicons-outline:trash",
                    doit: (id) => { 
                        this.cancel_request(id)
                    },
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
                    label: "Payment Ref",
                    field: "payment_ref",
                },
                {
                    label: "User",
                    field: "user",
                },

                {
                    label: "Amount",
                    field: "amount",
                },
                {
                    label: "Benefactor",
                    field: "benefactor",
                },

                {
                    label: "Status",
                    field: "status",
                },
                {
                    label: "Action",
                    field: "action",
                },
            ],
        };
    },    
    mounted() {
        this.fetch_all()
    },
    methods: {
        updateValue() {
            if (this.selected == 'all') {
                this.fetch_all()
            }
            if (this.selected == 'paid') {
                this.fetch_paid()
            }
            if (this.selected == 'rejected') {
                this.fetch_cancel()
            }
        },
        create_loan() {
            this.$router.push({name : "admin-loan-create"})
        },
        cancel_request(pay_id) {
            toast.info("Canceling Request", {
                timeout: 4000,
            });
            let $this = this
            const toast = useToast();
            const formData = new FormData();
            formData.append('id', pay_id)

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/cancel_request`, formData, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {
                    $this.fetch_all()
                     toast.success("Request Cancelled Successfully", {
                        timeout: 4000,
                    });

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
        },
        fetch_all() {
            const $this = this

            const toast = useToast();

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/transfer_requests`, {}, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {
                    // toast.success("User Found", {
                    //     timeout: 4000,
                    // });
                    $this.payment_requests = response.data.payment_requests
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
        },
        fetch_paid() {
            const $this = this

            const toast = useToast();

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/transfer_requests_paid`, {}, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {
                    $this.payment_requests = response.data.payment_requests
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
        },
        fetch_cancel() {
            const $this = this

            const toast = useToast();

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/transfer_requests_canceled`, {}, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {
                    // toast.success("User Found", {
                    //     timeout: 4000,
                    // });
                    $this.payment_requests = response.data.payment_requests
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

    }
};
</script>
<style lang="scss"></style>
