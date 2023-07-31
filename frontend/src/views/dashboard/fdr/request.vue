<template>
    <div>
        <Card noborder>
            <div class="md:flex pb-6 items-center">
                <h6 class="flex-1 md:mb-0 mb-3">Fixed Deposit Plan</h6>
                <div class="md:flex md:space-x-3 items-center flex-none rtl:space-x-reverse"
                    :class="window.width < 768 ? 'space-x-rb' : ''">
                    <InputGroup v-model="searchTerm" placeholder="Search" type="text" prependIcon="heroicons-outline:search"
                        merged />
                    <Select label="" :options="values" v-model="selected" style="width: 200px" classInput="h-[36px]"
                        @change="updateValue" />
                     <Button
            icon="heroicons-outline:plus-sm"
            text="Add Plan"
            btnClass=" btn-dark font-normal btn-sm "
            iconClass="text-lg" @click="create_plan"
          />
                </div>
            </div>
            <div class="-mx-6">
                <template v-if="plans">
                    <vue-good-table :columns="columns" styleClass=" vgt-table  centered " :rows="plans"
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
                            <span v-if="props.column.field == 'user'" class="flex flex-col items-center">
                                <span class="text-sm text-slate-600 dark:text-slate-300 capitalize font-medium">{{
                                    props.row.name }}</span>
                                <span class="text-sm text-slate-600 dark:text-slate-300 capitalize font-medium">{{
                                    props.row.email }}</span>
                            </span>

                            <span v-if="props.column.field == 'duration'" class="font-medium">
                                {{ props.row.duration + " " +props.row.duration_type
                                }}
                            </span>
                            <span v-if="props.column.field == 'minimum_amount'" class="font-medium">
                                {{ " USD " + parseFloat(props.row.minimum_amount).toLocaleString("en-US") }}
                            </span>
                            <span v-if="props.column.field == 'maximum_amount'" class="font-medium">
                                {{ " USD " + parseFloat(props.row.maximum_amount).toLocaleString("en-US") }}
                            </span>

                            <span v-if="props.column.field == 'mature_date'">
                                <template v-if="props.row.mature_date">
                                    {{ format_date(props.row.mature_date) }}
                                </template>
                            </span>
                            <span v-if="props.column.field == 'interest_rate'">
                                {{ props.row.interest_rate + " %" }}
                            </span>
                            <span v-if="props.column.field == 'status'" class="block w-full">
                                <span
                                    class="inline-block px-3 min-w-[90px] text-center mx-auto py-1 rounded-[999px] bg-opacity-25"
                                    :class="`${props.row.status === 'active'
                                        ? 'text-success-500 bg-success-500'
                                        : ''
                                        }${props.row.status === 'not_active'
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
                                                <Icon :icon="'heroicons-outline:pencil'" />
                                            </span>
                                            <span>Edit</span>
                                        </div>
                                        </MenuItem>
                                        <MenuItem v-if="props.row.status != 'active'">
                                        <div @click="approve_request(props.row.id)"
                                            :class="`'hover:bg-slate-900  hover:bg-opacity-100 hover:text-white w-full border-b border-b-gray-500 border-opacity-10 px-4 py-2 text-sm  last:mb-0 cursor-pointer first:rounded-t last:rounded-b flex  space-x-2 items-center rtl:space-x-reverse `">
                                            <span class="text-base">
                                                <Icon :icon="'heroicons-outline:check'" />
                                            </span>
                                            <span>Activate</span>
                                        </div>
                                        </MenuItem>
                                        <MenuItem v-if="props.row.status != 'not_active'">
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
                                <Pagination :total="plans.length" :current="current" :per-page="perpage"
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
                    label: "Approved",
                },
                {
                    value: "pending",
                    label: "Pending",
                },
                {
                    value: "declined",
                    label: "Declined",
                },
            ],
            current: 1,
            perpage: 10,
            pageRange: 5,
            searchTerm: "",
            plans: "",
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
                    label: "Name",
                    field: "name",
                },
                {
                    label: "Minimun Amount",
                    field: "minimum_amount",
                },
                {
                    label: "Maximum Amount",
                    field: "maximum_amount",
                },

                {
                    label: "Duration",
                    field: "duration",
                },
                {
                    label: "Interest Rate",
                    field: "interest_rate",
                },
                {
                    label: "Status",
                    field: "status",
                },
                // {
                //     label: "Description",
                //     field: "description",
                // },
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
        create_plan() {
            this.$router.push({ name: "admin-fixed-deposit-create" })
        },
        edit_plan(id) {
            this.$router.push({ name: "admin-fixed-deposit-edit", params : {plan_id : id} })
        },
        approve_request(pay_id) {
            let $this = this
            const toast = useToast();
            const formData = new FormData();
            formData.append('id', pay_id)

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/plan_activate`, formData, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {

                    toast.success("Deposit Approved Successfully", {
                        timeout: 4000,
                    });
                    $this.$router.push({ name: 'admin-fixed-deposit-request-package' })

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
        cancel_request(pay_id) {
            let $this = this
            const toast = useToast();
            const formData = new FormData();
            formData.append('id', pay_id)

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/plan_deactivate`, formData, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {

                    toast.success("Deposit Declined Successfully", {
                        timeout: 4000,
                    });
                    $this.$router.push({ name: 'admin-fixed-deposit-request-package' })

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

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/list_all_plans`, {}, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {
                    // toast.success("User Found", {
                    //     timeout: 4000,
                    // });
                    $this.plans = response.data.plans
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
        fetch_approved() {
            const $this = this

            const toast = useToast();

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/list_active_plans`, {}, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {
                    $this.plans = response.data.plans
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
        fetch_pending() {
            const $this = this

            const toast = useToast();

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/list_not_active_plans`, {}, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {
                    // toast.success("User Found", {
                    //     timeout: 4000,
                    // });
                    $this.plans = response.data.plans
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

    }
};
</script>
<style lang="scss"></style>
