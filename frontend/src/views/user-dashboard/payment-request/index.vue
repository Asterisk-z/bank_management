<template>
    <div>
        
        <Card noborder>
            <div class="md:flex pb-6 items-center">
                <h6 class="flex-1 md:mb-0 mb-3">{{ banner }}</h6>
                <div class="md:flex md:space-x-3 items-center flex-none rtl:space-x-reverse"
                    :class="window.width < 768 ? 'space-x-rb' : ''">
                    <InputGroup v-model="searchTerm" placeholder="Search" type="text" prependIcon="heroicons-outline:search"
                        merged />
                    <Button text="Sent Request Only"
                        btnClass=" btn-dark font-normal btn-sm " iconClass="text-lg"  @click="fetch_deposit_requests" />
                    <Button text="Received Request Only"
                        btnClass=" btn-dark font-normal btn-sm " iconClass="text-lg" @click="fetch_receive_requests" />
                </div>
            </div>
            <div class="-mx-6">
                <template v-if="deposit_requests">
                    <vue-good-table :columns="columns" styleClass=" vgt-table  centered " :rows="deposit_requests"
                        :sort-options="{
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
                            <span v-if="props.column.field == 'user_id'" class="flex items-center">
                                <span class="text-sm text-slate-600 dark:text-slate-300 capitalize font-medium">{{
                                    props.row.user.name }}</span>
                            </span>
                            <span v-if="props.column.field == 'amount'" class="font-medium">
                                {{ props.row.currency + " " + props.row.amount }}
                            </span>
                            <span v-if="props.column.field == 'description'" class="text-slate-500 dark:text-slate-400">
                                {{ props.row.description.substring(0, 15)+"..." }}
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
                                        }  `">
                                    {{ props.row.status }}
                                </span>
                            </span>
                            <span v-if="props.column.field == 'action'">
                                <Modal v-if="props.row.benefactor == this.$store.authStore.user.user.id " title="Send Money" label="Send Money"
                                    labelClass="btn-outline-dark btn-sm" ref="modal2" centered >
                                    <h4 class="font-medium text-lg mb-3 text-slate-900">

                                    </h4>
                                    <div class="text-base text-slate-600 dark:text-slate-300">
                                        <!-- {{ props.row }} -->
                                        <div class="space-y-[5px]">
                                            <span class="block text-slate-900 dark:text-slate-300 font-medium leading-5 text-xl mb-4" > Billing Details:</span >
                                            <h4 class="text-slate-600 font-medium dark:text-slate-300 text-sm uppercase">
                                                Sender's Name: {{ props.row.user.name }}
                                            </h4>
                                            <h4 class="text-slate-600 font-medium dark:text-slate-300 text-sm uppercase">
                                                Payment number: {{ props.row.payment_ref }}
                                            </h4>
                                            <h4 class="text-slate-600 font-medium dark:text-slate-300 text-sm uppercase">
                                                Amount : {{ props.row.currency + " " + props.row.amount }}
                                            </h4>
                                            <h4 class="text-slate-600 font-medium dark:text-slate-300 text-sm uppercase">
                                                Date : {{ props.row.created_at }}
                                            </h4>
                                            <div class="text-slate-600 font-medium dark:text-slate-300 text-sm" >
                                                Description : {{ props.row.description }}
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <template v-slot:footer>
                                        <Button text="send money" btnClass="btn-primary btn-sm " @click="make_payment(props.row.id)" />
                                        <Button text="Close" btnClass="btn-dark btn-sm " @click="$refs.modal2.closeModal()" />
                                    </template>
                                </Modal>
                                <Button v-if="props.row.user_id == this.$store.authStore.user.user.id"  text="Deactivate" btnClass="btn-dark btn-sm " @click="cancel" />
                            </span>
                        </template>
                        <template #pagination-bottom="props">
                            <div class="py-4 px-3">
                                <Pagination :total="deposit_requests.length" :current="current" :per-page="perpage"
                                    :pageRange="pageRange" @page-changed="current = $event" :pageChanged="props.pageChanged"
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
import window from "@/mixins/window";
import axios from "axios";
import { useToast } from "vue-toastification";
import Modal from '@/components/Modal/Modal';
export default {
    mixins: [window],
    components: {
        Pagination,
        InputGroup,
        Dropdown,
        Icon,
        Breadcrumb,
        Card,
        Button,
        Modal,
    },

    data() {
        return {
            deposit_requests: "",
            app_url: import.meta.env.VITE_APP_API_BASEURL,
            current: 1,
            perpage: 10,
            pageRange: 5,
            searchTerm: "",
            banner: "All Payment Requests",
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
                    label: "Request Reference",
                    field: "payment_ref",
                },
                {
                    label: "Description",
                    field: "description",
                },
                {
                    label: "Benefactor",
                    field: "user_id",
                },
                {
                    label: "Amount",
                    field: "amount",
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
        this.fetch_deposit_requests();
        const toast = useToast();
    },
    methods: {
        async fetch_deposit_requests() {
            const data = await axios.post(`${import.meta.env.VITE_APP_API_URL}/customer/all_request`, {}, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {
                    return response.data?.data

                } else {
                    let message = response.data?.message[0];
                    toast.error(message, {
                        timeout: 4000,
                    });
                }
            });
            this.deposit_requests = data
        },
        async fetch_receive_requests() {
            const data = await axios.post(`${import.meta.env.VITE_APP_API_URL}/customer/received_requests`, {}, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {
                    return response.data?.data

                } else {
                    let message = response.data?.message[0];
                    toast.error(message, {
                        timeout: 4000,
                    });
                }
            });
            this.deposit_requests = data
        },
        make_payment() {
            this.$swal.fire({
                title: 'Do you want to save the changes?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'Save',
                denyButtonText: `Don't save`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    axios.post(`${import.meta.env.VITE_APP_API_URL}/customer/pay_request`, {}, {
                        headers: {
                            "Authorization": "Bearer " + this.$store.authStore.user.token
                        }
                    }).then(function (response) {

                        if (response.data?.status) {
                            return response.data?.data

                        } else {
                            let message = response.data?.message[0];
                            toast.error(message, {
                                timeout: 4000,
                            });
                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            })
            
            // this.deposit_requests = data
        },
        cancel() {

        },
    }
};
</script>
<style lang="scss"></style>
