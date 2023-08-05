<template>
    <div>
        <Card noborder>
            <div class="md:flex pb-6 items-center">
                <h6 class="flex-1 md:mb-0 mb-3">Deposit Request History</h6>
                <div class="md:flex md:space-x-3 items-center flex-none rtl:space-x-reverse"
                    :class="window.width < 768 ? 'space-x-rb' : ''">
                    <InputGroup v-model="searchTerm" placeholder="Search" type="text" prependIcon="heroicons-outline:search"
                        merged />
                    <Button icon="heroicons-outline:plus-sm" text="Deposit via Payoneer" btnClass=" btn-dark font-normal btn-sm "
                        iconClass="text-lg" link="manual-deposit-payoneer"  />
                </div>
            </div>
            <div class="-mx-6">
                <template v-if="deposit_requests">
                    <vue-good-table :columns="columns" styleClass=" vgt-table  centered " :rows="deposit_requests" :sort-options="{
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
                            <span v-if="props.column.field == 'customer'" class="flex items-center">
                                <span class="text-sm text-slate-600 dark:text-slate-300 capitalize font-medium">{{
                                    props.row.customer.name }}</span>
                            </span>
                            <span v-if="props.column.field == 'amount'" class="font-medium">
                                {{ props.row.currency +" " + props.row.amount }}
                            </span>
                            <span v-if="props.column.field == 'date'" class="text-slate-500 dark:text-slate-400">
                                {{ props.row.date }}
                            </span>
                            <span v-if="props.column.field == 'status'" class="block w-full">
                                <span
                                    class="inline-block px-3 min-w-[90px] text-center mx-auto py-1 rounded-[999px] bg-opacity-25"
                                    :class="`${props.row.status === 'approved'
                                        ? 'text-success-500 bg-success-500'
                                        : ''
                                        } 
                                                                                ${props.row.status === 'pending'
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
                            <span v-if="props.column.field == 'action'">
                                    <Modal v-if="props.row.proof"
                                        title="View Attachment"
                                        label="View Attachment"
                                        labelClass="btn-outline-dark"
                                        ref="modal2"
                                        centered
                                        >
                                        <h4 class="font-medium text-lg mb-3 text-slate-900">
                                            
                                        </h4>
                                        <div class="text-base text-slate-600 dark:text-slate-300">
                                        <img :src="app_url+'/uploads/deposit_proof/'+ props.row.proof"
                                                                            class="object-cover w-full h-full" />
                                        </div>
                                        <template v-slot:footer>
                                            <Button
                                            text="Close"
                                            btnClass="btn-dark "
                                            @click="$refs.modal2.closeModal()" 
                                            />
                                        </template>
                                    </Modal>
                            </span>
                        </template>
                        <template #pagination-bottom="props">
                            <div class="py-4 px-3">
                                <Pagination :total="deposit_requests.length" :current="current" :per-page="perpage" :pageRange="pageRange"
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
                    field: "deposit_ref",
                },
                {
                    label: "Description",
                    field: "description",
                },
                {
                    label: "Method",
                    field: "method",
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
            const data = await axios.post(`${import.meta.env.VITE_APP_API_URL}/customer/deposit_requests`, {}, {
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
            }).catch(function (error) {
                
                if (error.response?.data?.error == 'Unauthorized') {
                    toast.error("Session Expired", {
                        timeout: 3000,
                    });
                    $this.$router.push({ name: 'Login' })
                }
            });
            this.deposit_requests = data
        }
    }
};
</script>
<style lang="scss"></style>
