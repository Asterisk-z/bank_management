<template>
    <div>


        <div class="grid grid-cols-12 gap-5">
            <div class="lg:col-span-12 col-span-12">
                
                <Card title="Loan Details">

                     <TabGroup>
        <TabList class="lg:space-x-8 md:space-x-4 space-x-0 rtl:space-x-reverse">
          <Tab
            v-slot="{ selected }"
            as="template"
            v-for="(item, i) in buttons"
            :key="i"
          >
            <button
              :class="[
                  selected
                      ? 'text-primary-500 before:w-full'
                      : 'text-slate-500 before:w-0 dark:text-slate-300',
              ]"
              class="text-sm font-medium mb-7 capitalize bg-white dark:bg-slate-800 ring-0 foucs:ring-0 focus:outline-none px-2 transition duration-150 before:transition-all before:duration-150 relative before:absolute before:left-1/2 before:bottom-[-6px] before:h-[1.5px] before:bg-primary-500 before:-translate-x-1/2"
            >
              {{ item.title }}
            </button>
          </Tab>
        </TabList>
        <TabPanels>
          <TabPanel>
            <div class="text-slate-600 dark:text-slate-400 text-sm font-normal" v-if="loan">

              <table class="w-full border-collapse border-none text-left">
                <tr class="border-b border-slate-100 dark:border-slate-700">
                  <td class="text-slate-600 dark:text-slate-300 text-left px-6 py-4 text-sm font-normal">
                    Loan Ref
                  </td>
                  <td class="text-slate-600 dark:text-slate-300 text-base font-sm font-normal text-left t px-6 py-4">
                    {{ loan.loan_ref }}
                  </td>
                </tr>
                <tr class="border-b border-slate-100 dark:border-slate-700">
                  <td class="text-slate-600 dark:text-slate-300 text-left px-6 py-4 text-sm font-normal">
                    Status
                  </td>
                  <td class="text-slate-600 dark:text-slate-300 text-base font-sm font-normal text-left t px-6 py-4">
                     <span class="inline-block px-3 min-w-[90px] text-center mx-auto py-1 rounded-[999px] bg-opacity-25"
                        :class="`${loan.status === 'approved'
                            ? 'text-success-500 bg-success-500'
                            : ''
                            }${loan.status === 'pending'
                                ? 'text-danger-500 bg-danger-500'
                                : ''
                            } ${loan.status === 'declined'
                                ? 'text-danger-500 bg-danger-500'
                                : ''
                            } `">
                        {{ loan.status }}
                    </span>
                  </td>
                </tr>
                <tr class="border-b border-slate-100 dark:border-slate-700">
                  <td class="text-slate-600 dark:text-slate-300 text-left px-6 py-4 text-sm font-normal">
                    Borrower Name
                  </td>
                  <td class="text-slate-600 dark:text-slate-300 text-base font-sm font-normal text-left t px-6 py-4">
                    {{ loan.borrower.name + " | " + loan.borrower.email }}
                  </td>
                </tr>
                    <tr class="border-b border-slate-100 dark:border-slate-700">
                      <td class="text-slate-600 dark:text-slate-300 text-left px-6 py-4 text-sm font-normal">
                        Applied Amount
                      </td>
                      <td class="text-slate-600 dark:text-slate-300 text-base font-sm font-normal text-left t px-6 py-4">
                         {{ loan.currency+" " + parseFloat(loan.applied_amount).toLocaleString("en-US") }}
                      </td>
                    </tr>
                    <tr class="border-b border-slate-100 dark:border-slate-700">
                      <td class="text-slate-600 dark:text-slate-300 text-left px-6 py-4 text-sm font-normal">
                        Total Payable
                      </td>
                      <td class="text-slate-600 dark:text-slate-300 text-base font-sm font-normal text-left t px-6 py-4">
                         {{ loan.currency+" " + parseFloat(loan.total_payable).toLocaleString("en-US") }}
                      </td>
                    </tr>
                    <tr class="border-b border-slate-100 dark:border-slate-700">
                      <td class="text-slate-600 dark:text-slate-300 text-left px-6 py-4 text-sm font-normal">
                        Total Paid
                      </td>
                      <td class="text-slate-600 dark:text-slate-300 text-base font-sm font-normal text-left t px-6 py-4">
                         {{ loan.currency+" " + parseFloat(loan.total_paid).toLocaleString("en-US") }}
                      </td>
                    </tr>
                    <tr class="border-b border-slate-100 dark:border-slate-700">
                      <td class="text-slate-600 dark:text-slate-300 text-left px-6 py-4 text-sm font-normal">
                         Due Amount
                      </td>
                      <td class="text-slate-600 dark:text-slate-300 text-base font-sm font-normal text-left t px-6 py-4">
                         {{ loan.currency+" " + (parseFloat(loan.total_payable) - parseFloat(loan.total_paid)).toLocaleString("en-US") }}
                      </td>
                    </tr>
                    <tr class="border-b border-slate-100 dark:border-slate-700">
                      <td class="text-slate-600 dark:text-slate-300 text-left px-6 py-4 text-sm font-normal">
                         Late Payment Penalties
                      </td>
                      <td class="text-slate-600 dark:text-slate-300 text-base font-sm font-normal text-left t px-6 py-4">
                         {{  parseFloat(loan.late_payment_penalties).toLocaleString("en-US")+"%" }}
                      </td>
                    </tr>
                    <tr class="border-b border-slate-100 dark:border-slate-700">
                      <td class="text-slate-600 dark:text-slate-300 text-left px-6 py-4 text-sm font-normal">
                      First Payment Date
                      </td>
                      <td class="text-slate-600 dark:text-slate-300 text-base font-sm font-normal text-left t px-6 py-4">
                        {{ loan.first_payment_date }}
                      </td>
                    </tr>
                    <tr class="border-b border-slate-100 dark:border-slate-700">
                      <td class="text-slate-600 dark:text-slate-300 text-left px-6 py-4 text-sm font-normal">
                        Release Date
                      </td>
                      <td class="text-slate-600 dark:text-slate-300 text-base font-sm font-normal text-left t px-6 py-4">
                        {{ loan.release_date }}
                      </td>
                    </tr>
                    <tr class="border-b border-slate-100 dark:border-slate-700">
                      <td class="text-slate-600 dark:text-slate-300 text-left px-6 py-4 text-sm font-normal">
                        Attachment	
                      </td>
                      <td class="text-slate-600 dark:text-slate-300 text-base font-sm font-normal text-left t px-6 py-4">
                        {{ loan.attachment ? "yes" : 'no' }}
                      </td>
                    </tr>
                    <tr class="border-b border-slate-100 dark:border-slate-700">
                      <td class="text-slate-600 dark:text-slate-300 text-left px-6 py-4 text-sm font-normal">
                         Approved Date
                      </td>
                      <td class="text-slate-600 dark:text-slate-300 text-base font-sm font-normal text-left t px-6 py-4">
                        {{ loan.approved_date }}
                      </td>
                    </tr>
                    <tr class="border-b border-slate-100 dark:border-slate-700">
                      <td class="text-slate-600 dark:text-slate-300 text-left px-6 py-4 text-sm font-normal">
                         Description
                      </td>
                      <td class="text-slate-600 dark:text-slate-300 text-base font-sm font-normal text-left t px-6 py-4">
                        {{ loan.description }}
                      </td>
                    </tr>
                    <tr class="border-b border-slate-100 dark:border-slate-700">
                      <td class="text-slate-600 dark:text-slate-300 text-left px-6 py-4 text-sm font-normal">
                        Remarks
                      </td>
                      <td class="text-slate-600 dark:text-slate-300 text-base font-sm font-normal text-left t px-6 py-4">
                        {{ loan.remark }}
                      </td>
                    </tr>
              </table>
            </div>
          </TabPanel>
          <TabPanel>
            
                        <div class="md:flex pb-6 items-center">
                            <h6 class="flex-1 md:mb-0 mb-3">Collaterals</h6>
                            <div class="md:flex md:space-x-3 items-center flex-none rtl:space-x-reverse"
                                :class="window.width < 768 ? 'space-x-rb' : ''">
                                <InputGroup v-model="searchTerm" placeholder="Search" type="text" prependIcon="heroicons-outline:search"
                                    merged />
                                
                            </div>
                        </div>
                            
                        <div class="-mx-6">
                            <template v-if="loan_collaterals">
                                <vue-good-table :columns="loan_collateralsColumns" styleClass=" vgt-table  centered " :rows="loan_collaterals"
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

                                            <span v-if="props.column.field == 'amount_to_pay'" class="font-medium">
                                                {{ "USD " + (parseFloat(props.row.amount_to_pay) - parseFloat(props.row.interest)).toLocaleString("en-US") }}
                                            </span>
                                            <span v-if="props.column.field == 'interest'" class="font-medium">
                                                {{ "USD " + parseFloat(props.row.interest).toLocaleString("en-US") }}
                                            </span>
                                            <span v-if="props.column.field == 'late_penalties'" class="font-medium">
                                                {{ "USD " + parseFloat(props.row.late_penalties).toLocaleString("en-US") }}
                                            </span>
                                            <span v-if="props.column.field == 'total_amount'" class="font-medium">
                                                {{ "USD " + parseFloat(props.row.total_amount + parseFloat(props.row.late_penalties)).toLocaleString("en-US") }}
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
                                    </template>
                                    <template #pagination-bottom="props">
                                        <div class="py-4 px-3">
                                            <Pagination :total="loan_collaterals.length" :current="current" :per-page="perpage"
                                                :pageRange="pageRange" @page-changed="current = $event" :pageChanged="props.pageChanged"
                                                :perPageChanged="props.perPageChanged" enableSearch enableSelect :options="options">
                                                >
                                            </Pagination>
                                        </div>
                                    </template>
                                </vue-good-table>
                            </template>

                        </div>
          </TabPanel>
          <TabPanel>
                <div class="md:flex pb-6 items-center">
                    <h6 class="flex-1 md:mb-0 mb-3">Repayment Schedule</h6>
                    <div class="md:flex md:space-x-3 items-center flex-none rtl:space-x-reverse"
                        :class="window.width < 768 ? 'space-x-rb' : ''">
                        <InputGroup v-model="searchTerm" placeholder="Search" type="text" prependIcon="heroicons-outline:search"
                            merged />
                                
                    </div>
                </div>
                            
                <div class="-mx-6">
                    <template v-if="repayments">
                        <vue-good-table :columns="repaymentsColumns" styleClass=" vgt-table  centered " :rows="repayments"
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

                                    <span v-if="props.column.field == 'amount_to_pay'" class="font-medium">
                                        {{ "USD " + parseFloat(props.row.amount_to_pay).toLocaleString("en-US") }}
                                    </span>
                                    <span v-if="props.column.field == 'penalty'" class="font-medium">
                                        {{ "USD " + parseFloat(props.row.penalty).toLocaleString("en-US") }}
                                    </span>
                                    <span v-if="props.column.field == 'principal_amount'" class="font-medium">
                                        {{ "USD " + parseFloat(props.row.principal_amount).toLocaleString("en-US") }}
                                    </span>
                                    <span v-if="props.column.field == 'interest'" class="font-medium">
                                        {{ "USD " + parseFloat(props.row.interest).toLocaleString("en-US") }}
                                    </span>
                                    <span v-if="props.column.field == 'balance'" class="font-medium">
                                        {{ "USD " + parseFloat(props.row.balance).toLocaleString("en-US") }}
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
                            </template>
                            <template #pagination-bottom="props">
                                <div class="py-4 px-3">
                                    <Pagination :total="repayments.length" :current="current" :per-page="perpage"
                                        :pageRange="pageRange" @page-changed="current = $event" :pageChanged="props.pageChanged"
                                        :perPageChanged="props.perPageChanged" enableSearch enableSelect :options="options">
                                        >
                                    </Pagination>
                                </div>
                            </template>
                        </vue-good-table>
                    </template>

                </div>
             
            </TabPanel>
          <TabPanel
            >
            
                    <div class="md:flex pb-6 items-center">
                        <h6 class="flex-1 md:mb-0 mb-3">Repayments</h6>
                        <div class="md:flex md:space-x-3 items-center flex-none rtl:space-x-reverse"
                            :class="window.width < 768 ? 'space-x-rb' : ''">
                            <InputGroup v-model="searchTerm" placeholder="Search" type="text" prependIcon="heroicons-outline:search"
                                merged />
                                
                        </div>
                    </div>
                            
                    <div class="-mx-6">
                        <template v-if="payments">
                            <vue-good-table :columns="paymentsColumns" styleClass=" vgt-table  centered " :rows="payments"
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

                                        <span v-if="props.column.field == 'amount_to_pay'" class="font-medium">
                                            {{ "USD " + (parseFloat(props.row.amount_to_pay) -  parseFloat(props.row.interest)).toLocaleString("en-US") }}
                                        </span>
                                        <span v-if="props.column.field == 'interest'" class="font-medium">
                                            {{ "USD " + parseFloat(props.row.interest).toLocaleString("en-US") }}
                                        </span>
                                        <span v-if="props.column.field == 'late_penalties'" class="font-medium">
                                            {{ "USD " + parseFloat(props.row.late_penalties).toLocaleString("en-US") }}
                                        </span>
                                        <span v-if="props.column.field == 'total_amount'" class="font-medium">
                                            {{ "USD " + parseFloat(props.row.total_amount + parseFloat(props.row.late_penalties)).toLocaleString("en-US") }}
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
                                </template>
                                <template #pagination-bottom="props">
                                    <div class="py-4 px-3">
                                        <Pagination :total="payments.length" :current="current" :per-page="perpage"
                                            :pageRange="pageRange" @page-changed="current = $event" :pageChanged="props.pageChanged"
                                            :perPageChanged="props.perPageChanged" enableSearch enableSelect :options="options">
                                            >
                                        </Pagination>
                                    </div>
                                </template>
                            </vue-good-table>
                        </template>

                    </div>
            </TabPanel
          >
        </TabPanels>
      </TabGroup>

                </Card>
            </div>
            <!-- <div class="lg:col-span-4 col-span-12">
                <Card title="">

                </Card>
            </div> -->
        </div>
    </div>
</template>
<script>
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from "@headlessui/vue";
import Breadcrumb from "@/views/components/Breadcrumbs";
import Card from "@/components/Card";
import InputGroup from "@/components/InputGroup";
import Textarea from "@/components/Textarea";
import Select from "@/components/Select";
import { useField, useForm } from "vee-validate";
import * as yup from "yup";
import { inject, ref } from "vue";
import { useAuthStore } from '@/store/authUser';
import { useRouter, useRoute } from "vue-router";
import { useToast } from "vue-toastification";
import FromGroup from "@/components/FromGroup";
import axios from 'axios';
import vSelect from "vue-select";
import { Countries } from "@/constant/country";
import "vue-select/dist/vue-select.css";
import Pagination from "@/components/Pagination";
import { useDropzone } from "vue3-dropzone";

import moment from 'moment';
import window from "@/mixins/window";

export default {
    mixins: [window],
    components: {
        Pagination,
        InputGroup,
        Textarea,
        vSelect,
        Breadcrumb,
        FromGroup,
        Card,
        Select,
        TabGroup,
        TabList,
        Tab,
        TabPanels,
        TabPanel,
        Breadcrumb,
    },
    data() {
        return {
            Countries,
            history: '',
            users: [],
            plans: [],
            selecteUser: "",
            selectedCurrency: "",
            selecteUserDetails: "",
            currencies: "",
            loan_products: "",
            users: "",
            buttons : [
                {
                    title: "Details",
                },
                {
                    title: "Collaterals",
                },
                {
                    title: "Repayment Schedule",
                },
                {
                    title: "Repayments",
                },
            ],
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
            repaymentsColumns: [
                {
                    label: "Amount to Pay",
                    field: "amount_to_pay",
                },
                {
                    label: "Penalty",
                    field: "penalty",
                },
                {
                    label: "Principal Amount",
                    field: "principal_amount",
                },
                {
                    label: "Interest",
                    field: "interest",
                },
                {
                    label: "Balance",
                    field: "balance",
                },
                {
                    label: "Status",
                    field: "status",
                },
                {
                    label: "Date",
                    field: "repayment_date",
                },
            ],
            paymentsColumns: [
                {
                    label: "Principal Amount",
                    field: "amount_to_pay",
                },
                {
                    label: "Interest",
                    field: "interest",
                },
                {
                    label: "Late Penalty",
                    field: "late_penalties",
                },
                {
                    label: "Total Amount",
                    field: "total_amount",
                },
                {
                    label: "Paid At",
                    field: "paid_at",
                },
            ],
            loan_collateralsColumns: [
                {
                    label: "Name",
                    field: "name",
                },
                {
                    label: "Collateral Type",
                    field: "collateral_type",
                },
                {
                    label: "Serial Number",
                    field: "serial_number",
                },
                {
                    label: "Estimated Price",
                    field: "estimated_price",
                },
                {
                    label: "Action",
                    field: "action",
                },
            ],
        }
    },
    mounted() {
        this.fetch_currencies()
        this.fetch_products()
        this.fetch_users()
    },
    methods: {
        format_date(value) {
            return moment(value).format("Do-MMM-YYYY hh:mm A");
        },
        fetch_products() {
            let $this = this
            let data = axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/fetch_products`, {}, {
                headers: {
                    "Authorization": "Bearer " + $this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {

                    $this.loan_products = response.data.loan_products

                } else {

                }
            }).catch(function (error) {
                if (error.response?.data?.error == 'Unauthorized') {
                    // toast.error("Session Expired", {
                    //     timeout: 3000,
                    // });
                    $this.$router.push({ name: 'Login' })
                }
            });
        },
        fetch_users() {
            let $this = this
            let data = axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/fetch_users`, {}, {
                headers: {
                    "Authorization": "Bearer " + $this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {

                    $this.users = response.data.users

                } else {

                }
            }).catch(function (error) {
                if (error.response?.data?.error == 'Unauthorized') {
                    // toast.error("Session Expired", {
                    //     timeout: 3000,
                    // });
                    $this.$router.push({ name: 'Login' })
                }
            });
        },
        fetch_currencies() {
            let $this = this
            let data = axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/fetch_currencies`, {}, {
                headers: {
                    "Authorization": "Bearer " + $this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {

                    $this.currencies = response.data.currencies

                } else {

                }
            }).catch(function (error) {
                if (error.response?.data?.error == 'Unauthorized') {
                    // toast.error("Session Expired", {
                    //     timeout: 3000,
                    // });
                    $this.$router.push({ name: 'Login' })
                }
            });
        }
    },

    setup() {
        const schema = yup.object({
            product: yup.string().required("Name is required"),
            user: yup.string().required("Interest Rate is required"),

            latePayment: yup.string().required("Late Payment is required"),
            currency: yup.string().required("Currency is required"),
            Amount: yup.number('Terms Can only be numbers').required("Amount is required"),

            firstPaymentDate: yup.string().required("First Payment Date is required"),
            releaseDate: yup.string().required("Release Date is required"),

            remark: yup.string().required("Remark is required"),
            description: yup.string().required("Description is required"),
        });
        const swal = inject("$swal");
        const toast = useToast();
        const router = useRouter();
        const route = useRoute();
        const auth = useAuthStore();

        const { handleSubmit } = useForm({
            validationSchema: schema,
        });
        
        const files = ref([]);
        function onDrop(acceptFiles) {
            files.value = acceptFiles.map((file) =>
                Object.assign(file, {
                    preview: URL.createObjectURL(file),
                })
            );
        }
        

        const { value: repayments, errorMessage: repaymentsError } = useField("repayments");
        const { value: payments, errorMessage: paymentsError } = useField("payments");
        const { value: loan_collaterals, errorMessage: loan_collateralsError } = useField("loan_collaterals");
        const { value: loan, errorMessage: loanError } = useField("loan");

        const { value: product, errorMessage: productError } = useField("product");
        const { value: user, errorMessage: userError } = useField("user");

        const { value: latePayment, errorMessage: latePaymentError } = useField("latePayment");
        const { value: currency, errorMessage: currencyError } = useField("currency");
        const { value: Amount, errorMessage: AmountError } = useField("Amount");
        
        const { value: firstPaymentDate, errorMessage: firstPaymentDateError } = useField("firstPaymentDate");
        const { value: releaseDate, errorMessage: releaseDateError } = useField("releaseDate");

        const { value: remark, errorMessage: remarkError } = useField("remark");
        const { value: description, errorMessage: descriptionError } = useField("description");

        const { getRootProps, getInputProps, ...rest } = useDropzone({ onDrop });
        const onSubmit = handleSubmit((values) => {

            toast.info("Updating Loan", {
                timeout: 5000,
            });

            let id = route.params.loan_id;
            const fromData = new FormData();
            fromData.append("attachment", files._rawValue[0]);
            fromData.append("id", id);
            fromData.append("loan_product_id", values.product);
            fromData.append("borrower_id", values.user);
            fromData.append("late_payment_penalties", values.latePayment);
            fromData.append("currency", values.currency);
            fromData.append("applied_amount", values.Amount);
            fromData.append("first_payment_date", values.firstPaymentDate);
            fromData.append("release_date", values.releaseDate);
            fromData.append("remarks", values.remark);
            fromData.append("description", values.description);

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/update_loan`, fromData, {
                headers: {
                    "Authorization": "Bearer " + auth.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {

                    toast.success(response.data?.message, {
                        timeout: 2000,
                    });

                    router.push({ name: 'admin-loans' });

                } else {
                    let message = response.data?.message[0];
                    toast.error(message, {
                        timeout: 4000,
                    });
                }
            }).catch(function (error) {
                toast.error(error.response.data.message, {
                    timeout: 5000,
                });
                if (error.response?.data?.error == 'Unauthorized') {
                    toast.error("Session Expired", {
                        timeout: 3000,
                    });
                    router.push({ name: 'Login' })
                }
            });

        });

        
        let id = route.params.loan_id;
        let data = axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/single_loan`, {
            loan_id: id,
        }, {
            headers: {
                "Authorization": "Bearer " + auth.user.token
            }
        }).then(function (response) {

            if (response.data?.status) {
                // loan.value = "healin Loaner"
                loan.value = response.data.data.loan
                loan_collaterals.value = response.data.data.loan_collaterals
                payments.value = response.data.data.payments
                repayments.value = response.data.data.repayments
                // user.value = response.data.loan.borrower_id
                // latePayment.value = response.data.loan.late_payment_penalties
                // currency.value = response.data.loan.currency
                // Amount.value = response.data.loan.applied_amount
                // firstPaymentDate.value = response.data.loan.first_payment_date
                // if (response.data.loan.release_date) {
                //      releaseDate.value = response.data.loan.release_date
                // }
               
                // remark.value = response.data.loan.remarks ? response.data.loan.remarks : "0"
                // description.value = response.data.loan.description
            } else {
                // router.push({ name: 'admin-loans' });
                let message = response.data;
                toast.error(message, {
                    timeout: 4000,
                });
            }
        }).catch(function (error) {
            if (error.response?.data?.error == 'Unauthorized') {
                toast.error("Session Expired", {
                    timeout: 3000,
                });
                router.push({ name: 'Login' })
            }
            toast.error(error, {
                timeout: 4000,
            });
            // router.push({ name: 'admin-loans' });
        });

        return {

            getRootProps,
            getInputProps,
            ...rest,
            files,
            loan,
            loanError,
            loan_collaterals,
            loan_collateralsError,
            payments,
            paymentsError,
            repayments,
            repaymentsError,

            product,
            productError,
            user,
            userError,

            latePayment,
            latePaymentError,
            currency,
            currencyError,
            Amount,
            AmountError,


            firstPaymentDate,
            firstPaymentDateError,
            releaseDate,
            releaseDateError,
            remark,
            remarkError,
            description,
            descriptionError,
            onSubmit,
            buttonText: "Update"
        };
    },
}
</script>
<style lang=""></style>
