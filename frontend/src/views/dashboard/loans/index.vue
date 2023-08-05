<template>
    <div>
        <Card noborder>
            <div class="md:flex pb-6 items-center">
                <h6 class="flex-1 md:mb-0 mb-3">All Loans</h6>
                <div class="md:flex md:space-x-3 items-center flex-none rtl:space-x-reverse"
                    :class="window.width < 768 ? 'space-x-rb' : ''">
                    <InputGroup v-model="searchTerm" placeholder="Search" type="text" prependIcon="heroicons-outline:search"
                        merged />
                    <Select label="" :options="values" v-model="selected" style="width: 200px" classInput="h-[36px]"
                        @change="updateValue" />
                               
              <Button
                icon="heroicons-outline:plus-sm"
                text="New Loan"
                btnClass=" btn-dark font-normal btn-sm "
                iconClass="text-lg"
                @click="create_loan"
              />
                </div>
            </div>
            <div class="-mx-6">
                <template v-if="loans">
                    <vue-good-table :columns="columns" styleClass=" vgt-table  centered " :rows="loans"
                        :sort-options="{
                            enabled: false,
                        }" :pagination-options="{
    enabled: true,
    perPage: perpage,
}" :search-options="{
    enabled: true,
    externalQuery: searchTerm,
}">
                        <template v-slot:table-row="props">
                            <span v-if="props.column.field == 'borrower'" class="flex flex-col items-center">
                                <span class="text-sm text-slate-600 dark:text-slate-300 capitalize font-medium">{{
                                    props.row.borrower.name }}</span>
                                <span class="text-sm text-slate-600 dark:text-slate-300 capitalize font-medium">{{
                                    props.row.borrower.email }}</span>
                            </span>

                            <span v-if="props.column.field == 'term'" class="font-medium">
                                <span v-if="props.row.term">
                                    {{ props.row.term + " / " + props.row.term_period   }}
                                </span>
                            </span>
                            <span v-if="props.column.field == 'applied_amount'" class="font-medium">
                                {{ props.row.currency+" " + parseFloat(props.row.applied_amount).toLocaleString("en-US") }}
                            </span>
                            <span v-if="props.column.field == 'maximum_amount'" class="font-medium">
                                {{ "USD " + parseFloat(props.row.maximum_amount).toLocaleString("en-US") }}
                            </span>

                            <span v-if="props.column.field == 'release_date'">
                                <template v-if="props.row.release_date">
                                    {{ format_date(props.row.release_date) }}
                                </template>
                            </span>
                            <span v-if="props.column.field == 'loan_product'">
                                {{ props.row.loan_product.name }}
                            </span>
                            <span v-if="props.column.field == 'interest_rate'">
                                {{ props.row.interest_rate + " %" }}
                            </span>
                            <span v-if="props.column.field == 'status'" class="block w-full">
                                <span
                                    class="inline-block px-3 min-w-[90px] text-center mx-auto py-1 rounded-[999px] bg-opacity-25"
                                    :class="`${props.row.status === 'approved'
                                        ? 'text-success-500 bg-success-500'
                                        : ''
                                        }${props.row.status === 'pending'
                                            ? 'text-danger-500 bg-danger-500'
                                            : ''
                                        } ${props.row.status === 'declined'
                                            ? 'text-danger-500 bg-danger-500'
                                            : ''
                                        } `">
                                    {{ props.row.status }}
                                </span>
                            </span>
                            <span v-if="props.column.field == 'action'">

                                <Dropdown classMenuItems=" w-[140px]">
                                    <span class="text-xl">
                                        <Icon icon="heroicons-outline:dots-vertical" />
                                    </span>
                                    <template v-slot:menus>
                                        <MenuItem>
                                        <div @click="edit_plan(props.row.id)"
                                            :class="`'hover:bg-slate-900  hover:bg-opacity-100 hover:text-white w-full border-b border-b-gray-500 border-opacity-10 px-4 py-2 text-sm  last:mb-0 cursor-pointer first:rounded-t last:rounded-b flex  space-x-2 items-center rtl:space-x-reverse `">
                                            <span class="text-base">
                                                <Icon :icon="'heroicons-outline:eye'" />
                                            </span>
                                            <span>View</span>
                                        </div>
                                        </MenuItem>
                                        <MenuItem  v-if="props.row.status == 'pending'">
                                        <div @click="edit_plan(props.row.id)"
                                            :class="`'hover:bg-slate-900  hover:bg-opacity-100 hover:text-white w-full border-b border-b-gray-500 border-opacity-10 px-4 py-2 text-sm  last:mb-0 cursor-pointer first:rounded-t last:rounded-b flex  space-x-2 items-center rtl:space-x-reverse `">
                                            <span class="text-base">
                                                <Icon :icon="'heroicons-outline:pencil'" />
                                            </span>
                                            <span>Edit</span>
                                        </div>
                                        </MenuItem>
                                        <MenuItem v-if="props.row.status != 'approved' && props.row.release_date">
                                        <div @click="approve_request(props.row.id)"
                                            :class="`'hover:bg-slate-900  hover:bg-opacity-100 hover:text-white w-full border-b border-b-gray-500 border-opacity-10 px-4 py-2 text-sm  last:mb-0 cursor-pointer first:rounded-t last:rounded-b flex  space-x-2 items-center rtl:space-x-reverse `">
                                            <span class="text-base">
                                                <Icon :icon="'heroicons-outline:check'" />
                                            </span>
                                            <span>Activate</span>
                                        </div>
                                        </MenuItem>
                                        <MenuItem v-if="props.row.status == 'pending'">
                                        <div @click="cancel_request(props.row.id)"
                                            :class="`'bg-danger-500 text-danger-500 bg-opacity-30  hover:bg-opacity-100 hover:text-white w-full border-b border-b-gray-500 border-opacity-10 px-4 py-2 text-sm  last:mb-0 cursor-pointer first:rounded-t last:rounded-b flex  space-x-2 items-center rtl:space-x-reverse `">
                                            <span class="text-base">
                                                <Icon :icon="'heroicons-outline:trash'" />
                                            </span>
                                            <span>Deactivate</span>
                                        </div>
                                        </MenuItem>
                                    </template>
                                </Dropdown>
                            </span>
                        </template>
                        <template #pagination-bottom="props">
                            <div class="py-4 px-3">
                                <Pagination :total="loans.length" :current="current" :per-page="perpage"
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
    Button,
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
                    value: "approved",
                    label: "Active",
                },
                {
                    value: "pending",
                    label: "Not Active",
                },
            ],
            current: 1,
            perpage: 10,
            pageRange: 5,
            searchTerm: "",
            loans: "",
            actions: [
                {
                    name: "Activate",
                    icon: "heroicons-outline:check",
                    doit: (id) => {
                        this.approve_request(id)
                    },
                },
                {
                    name: "Deactivate",
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
                    label: "Loan Ref",
                    field: "loan_ref",
                },
                {
                    label: "Loan Product",
                    field: "loan_product",
                },
                {
                    label: "Borrower",
                    field: "borrower",
                },
                {
                    label: "Release Date",
                    field: "release_date",
                },
                {
                    label: "Applied Amount",
                    field: "applied_amount",
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
        },
        create_loan() {
            this.$router.push({ name: "admin-create-loan" })
        },
        edit_plan(id) {
            this.$router.push({ name: "admin-edit-loan", params : {loan_id : id} })
        },
        edit_plan(id) {
            this.$router.push({ name: "admin-view-loan", params: { loan_id: id } })
        },
        approve_request(pay_id) {
            let $this = this
            const toast = useToast();
            const formData = new FormData();
            formData.append('loan_id', pay_id)

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/accept_loan`, formData, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {

                    toast.success("Loan Activated Successfully", {
                        timeout: 4000,
                    });
                    $this.fetch_all()

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
            formData.append('loan_id', pay_id)

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/decline_loan`, formData, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {

                    toast.success("Loan Deactivated  Successfully", {
                        timeout: 4000,
                    });
                    $this.fetch_all()

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

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/list_loans`, {}, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {
                    // toast.success("User Found", {
                    //     timeout: 4000,
                    // });
                    $this.loans = response.data.loans
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

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/all_active_loan_product`, {}, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {
                    $this.loans = response.data.loans
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

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/all_not_active_loan_product`, {}, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {
                    // toast.success("User Found", {
                    //     timeout: 4000,
                    // });
                    $this.loans = response.data.loans
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
