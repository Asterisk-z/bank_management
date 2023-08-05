<template>
    <div>
        <Card noborder>
            <div class="md:flex pb-6 items-center">
                <h6 class="flex-1 md:mb-0 mb-3">Ticket</h6>
                <div class="md:flex md:space-x-3 items-center flex-none rtl:space-x-reverse"
                    :class="window.width < 768 ? 'space-x-rb' : ''">
                    <InputGroup v-model="searchTerm" placeholder="Search" type="text" prependIcon="heroicons-outline:search"
                        merged />
                    <Select label="" :options="values" v-model="selected" style="width: 200px" classInput="h-[36px]"
                        @change="updateValue" />
                </div>
            </div>
            <div class="-mx-6">
                <template v-if="support_tickets">
                    <vue-good-table :columns="columns" styleClass=" vgt-table  centered " :rows="support_tickets"
                        :sort-options="{
                            enabled: false,
                        }" :pagination-options="{
                            enabled: true,
                            perPage: perpage,
                        }" :search-options="{
                            enabled: true,
                            externalQuery: searchTerm,
                        }" >
                        <template v-slot:table-row="props">
                            <span v-if="props.column.field == 'user'" class="flex flex-col items-center">
                                <span class="text-sm text-slate-600 dark:text-slate-300 capitalize font-medium">{{
                                    props.row.name }}</span>
                                <span class="text-sm text-slate-600 dark:text-slate-300 capitalize font-medium">{{
                                    props.row.email }}</span>
                            </span>

                            <span v-if="props.column.field == 'deposit_amount'" class="font-medium">
                                {{ props.row.currency + " " + parseFloat(props.row.deposit_amount).toLocaleString("en-US") }}
                            </span>
                            <span v-if="props.column.field == 'return_amount'" class="font-medium">
                                {{ props.row.currency + " " + parseFloat(props.row.return_amount).toLocaleString("en-US") }}
                            </span>

                            <span v-if="props.column.field == 'status'" class="block w-full">
                                <span
                                    class="inline-block px-3 min-w-[90px] text-center mx-auto py-1 rounded-[999px] bg-opacity-25"
                                    :class="`${props.row.status === 'active'
                                        ? 'text-success-500 bg-success-500'
                                        : ''
                                        }  ${props.row.status === 'pending'
                                            ? 'text-warning-500 bg-warning-500'
                                            : ''
                                        }${props.row.status === 'closed'
                                            ? 'text-danger-500 bg-danger-500'
                                            : ''
                                        } `">
                                    {{ props.row.status }}
                                </span>
                            </span>
                            <span v-if="props.column.field == 'base'" class="block w-full">
                                <span
                                    class="inline-block px-3 min-w-[90px] text-center mx-auto py-1 rounded-[999px] bg-opacity-25"
                                    :class="`${props.row.base === 'yes'
                                        ? 'text-success-500 bg-success-500'
                                        : ''
                                        }  ${props.row.base === 'no'
                                            ? 'text-danger-500 bg-danger-500'
                                            : ''
                                        } `">
                                    {{ props.row.base }}
                                </span>
                            </span>
                            <span v-if="props.column.field == 'attachment'" class="block w-full">
                                 <Modal v-if="props.row.attachment"
                                        title="View"
                                        label="View"
                                        labelClass="btn-sm btn-outline-dark"
                                        ref="modal2"
                                        centered
                                        >
                                        <h4 class="font-medium text-lg mb-3 text-slate-900">
                                            
                                        </h4>
                                        <div class="text-base text-slate-600 dark:text-slate-300">
                                        <img :src="app_url+'/uploads/support_ticket/'+ props.row.attachment"
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
                            <span v-if="props.column.field == 'action'">

                                <Dropdown classMenuItems=" w-[170px]" >
                                    <span class="text-xl">
                                        <Icon icon="heroicons-outline:dots-vertical" />
                                    </span>
                                    <template v-slot:menus>
                                        <MenuItem  v-if="props.row.status == 'pending'">
                                        <div @click="edit_loan(props.row.id)"
                                            :class="`'hover:bg-slate-900  hover:bg-opacity-100 hover:text-white w-full border-b border-b-gray-500 border-opacity-10 px-4 py-2 text-sm  last:mb-0 cursor-pointer first:rounded-t last:rounded-b flex  space-x-2 items-center rtl:space-x-reverse `">
                                            <span class="text-base">
                                                <Icon :icon="'heroicons-outline:pencil'" />
                                            </span>
                                            <span>Edit</span>
                                        </div>
                                        </MenuItem>
                                        <MenuItem  v-if="props.row.status != 'pending'">
                                        <div @click="chat_user(props.row.id)"
                                            :class="`'hover:bg-slate-900  hover:bg-opacity-100 hover:text-white w-full border-b border-b-gray-500 border-opacity-10 px-4 py-2 text-sm  last:mb-0 cursor-pointer first:rounded-t last:rounded-b flex  space-x-2 items-center rtl:space-x-reverse `">
                                            <span class="text-base">
                                                <Icon :icon="'heroicons-outline:chat'" />
                                            </span>
                                            <span>Chat</span>
                                        </div>
                                        </MenuItem>
                                            <MenuItem v-if="props.row.status == 'pending'">
                                            <div @click="approve_request(props.row.id)"
                                                :class="`'hover:bg-slate-900  hover:bg-opacity-100 hover:text-white w-full border-b border-b-gray-500 border-opacity-10 px-4 py-2 text-sm  last:mb-0 cursor-pointer first:rounded-t last:rounded-b flex  space-x-2 items-center rtl:space-x-reverse `">
                                                <span class="text-base">
                                                    <Icon :icon="'heroicons-outline:check'" />
                                                </span>
                                                <span>Activate</span>
                                            </div>
                                            </MenuItem>
                                        <MenuItem v-if="props.row.status != 'closed' ">
                                        <div @click="cancel_request(props.row.id)"
                                            :class="`'bg-danger-500 text-danger-500 bg-opacity-30  hover:bg-opacity-100 hover:text-white w-full border-b border-b-gray-500 border-opacity-10 px-4 py-2 text-sm  last:mb-0 cursor-pointer first:rounded-t last:rounded-b flex  space-x-2 items-center rtl:space-x-reverse `">
                                            <span class="text-base">
                                                <Icon :icon="'heroicons-outline:trash'" />
                                            </span>
                                            <span>Close Ticket</span>
                                        </div>
                                        </MenuItem>
                                    </template>
                                </Dropdown>
                            </span>
                        </template>
                        <template #pagination-bottom="props">
                            <div class="py-4 px-3">
                                <Pagination :total="support_tickets.length" :current="current" :per-page="perpage"
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
import { MenuItem } from "@headlessui/vue";
import window from "@/mixins/window";
import axios from 'axios';
import { useToast } from "vue-toastification";
import Select from "@/components/Select";
import moment from 'moment';
import Modal from '@/components/Modal/Modal';

export default {
    mixins: [window],
    components: {
        Pagination,
        Breadcrumb,
        InputGroup,
        Dropdown,
        Icon,
        Card,
        Modal,
        Select,
        MenuItem,
        Button
    },

    data() {
        return {
            
            app_url: import.meta.env.VITE_APP_API_BASEURL,
            selected: "all",
            values: [
                {
                    value: "all",
                    label: "All",
                },
                {
                    value: "approved",
                    label: "Active",
                },
                {
                    value: "pending",
                    label: "Pending",
                },
                {
                    value: "closed",
                    label: "Closed",
                },
            ],
            current: 1,
            perpage: 10,
            pageRange: 5,
            searchTerm: "",
            support_tickets: "",
            actions: [
                {
                    name: "approve",
                    icon: "heroicons-outline:check",
                    doit: (id) => {
                        this.approve_request(id)
                    },
                },
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
                    label: "User",
                    field: "user",
                },
                {
                    label: "Subject",
                    field: "subject",
                },
                {
                    label: "Description",
                    field: "description",
                },
                {
                    label: "Attachment",
                    field: "attachment",
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
        format_date(value) {
            return moment(value).format("Do-MMM-YYYY hh:mm A");
        },
        updateValue() {
            if (this.selected == 'all') {
                this.fetch_all()
            }
            if (this.selected == 'approved') {
                this.fetch_approved()
            }
            if (this.selected == 'pending') {
                this.fetch_pending()
            }
            if (this.selected == 'closed') {
                this.fetch_declined()
            }
        },
        edit_loan(id) {
            this.$router.push({ name: "admin-edit-ticket", params: { ticket_id: id } })
        },
        chat_user(id) {
            this.$router.push({ name: "admin-chat-ticket", params: { ticket_id: id } })
        },
        approve_request(pay_id) {
            let $this = this
            const toast = useToast();
            const formData = new FormData();
            formData.append('ticket_id', pay_id)

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/make_active`, formData, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {

                    toast.success("Currency Approved Successfully", {
                        timeout: 4000,
                    });
                    $this.updateValue()

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
        },
        cancel_request(pay_id) {
            let $this = this
            const toast = useToast();
            const formData = new FormData();
            formData.append('ticket_id', pay_id)

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/close_ticket`, formData, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {

                    toast.success("Currency Declined Successfully", {
                        timeout: 4000,
                    });
                    $this.updateValue()

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
        },
        fetch_all() {
            const $this = this

            const toast = useToast();

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/list_tickets`, {}, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {
                    // toast.success("User Found", {
                    //     timeout: 4000,
                    // });
                    $this.support_tickets = response.data.support_tickets
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
        },
        fetch_approved() {
            const $this = this

            const toast = useToast();

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/list_tickets_active`, {}, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {
                    $this.support_tickets = response.data.support_tickets
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
        },
        fetch_pending() {
            const $this = this

            const toast = useToast();

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/list_tickets_pending`, {}, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {
                    // toast.success("User Found", {
                    //     timeout: 4000,
                    // });
                    $this.support_tickets = response.data.support_tickets
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
        },
        fetch_declined() {
            const $this = this

            const toast = useToast();

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/list_tickets_closed`, {}, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {
                    // toast.success("User Found", {
                    //     timeout: 4000,
                    // });
                    $this.support_tickets = response.data.support_tickets
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
        },

    }
};
</script>
<style lang="scss"></style>
