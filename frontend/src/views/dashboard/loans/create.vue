<template>
    <div>


        <div class="grid grid-cols-12 gap-5">
            <div class="lg:col-span-8 col-span-12">
                
                <Card title="Create Loan">

                    <form @submit.prevent="onSubmit" class="space-y-4" enctype="multipart/form-data">

                        <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-5">
                            
                            <div class="fromGroup relative" :class="`${productError ? 'has-error' : ''}  `">
                                <label :class="`inline-block input-label `">{{ 'Product' }}</label>
                                <select name="swift" class="input-control block w-full focus:outline-none h-[48px]"
                                    v-model="product">
                                    <option value="">Select A Product</option>
                                    <option v-for="item in loan_products" :key="item" :value="item.id">{{ item.name }}</option>
                                </select>

                                <span v-if="productError" class="mt-2 text-danger-500 block text-sm">{{ productError
                                }}</span>
                            </div>

                            <div class="fromGroup relative" :class="`${userError ? 'has-error' : ''}  `">
                                <label :class="`inline-block input-label `">{{ 'Borrower' }}</label>
                                <select name="swift" class="input-control block w-full focus:outline-none h-[48px]"
                                    v-model="user">
                                    <option value="">Select A User</option>
                                    <option v-for="item in users" :key="item" :value="item.id">{{ item.name +" | "+item.email }}</option>
                                </select>
                                <span v-if="userError" class="mt-2 text-danger-500 block text-sm">{{ userError
                                }}</span>
                            </div>

                        </div>
                        <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-5">

                            <InputGroup type="number" label="Applied Amount" placeholder="Applied Amount" v-model="Amount" :error="AmountError"
                                classInput="h-[48px]">
                                <template v-slot:prepend>

                                    <div class="fromGroup relative" :class="`${currencyError ? 'has-error' : ''}  `">
                                        
                                        <select name="swift" class="input-control block focus:outline-none h-[48px] w-auto"
                                            v-model="currency">
                                            <option value="">Select A Currencies</option>
                                            <option v-for="item in currencies" :key="item"  :value="item.name">{{ item.name }}</option>
                                        </select>

                                        <span v-if="currencyError" class="mt-2 text-danger-500 block text-sm">{{ currencyError }}</span>
                                    </div>
                                </template>
                            </InputGroup>

                            <InputGroup type="number" label="Late Payment Penalties" placeholder="Late Payment Penalties" v-model="latePayment" :error="latePaymentError"
                                classInput="h-[48px]"  append="$">
                            </InputGroup>
                                
                            
                        </div>
                        <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-5">
                            
                            <FromGroup label="First Payment Date " name="d2" :error="firstPaymentDateError">
                                <flat-pickr  v-model="firstPaymentDate"  class="form-control h-[48px]" placeholder="Date"
                                    :config="{ enableTime: false, dateFormat: 'Y-m-d' }" />
                            </FromGroup>
                            
                                
                            <FromGroup label="Release Date" name="d2" :error="releaseDateError">
                                <flat-pickr  v-model="releaseDate" class="form-control h-[48px]" placeholder="Date"
                                    :config="{ enableTime: false, dateFormat: 'Y-m-d' }" />
                            </FromGroup>

                            <!-- <InputGroup type="number" label="Minimum Transfer Amount" placeholder="Minimum Transfer Amount"
                                v-model="minimum" :error="minimumError" classInput="h-[48px]" append="$">
                            </InputGroup>
                            <InputGroup type="number" label="Maximum Transfer Amount" placeholder="Maximum Transfer Amount"
                                v-model="maximum" :error="maximumError" classInput="h-[48px]" append="$">
                            </InputGroup>

                            <InputGroup type="number" label="Interest Rate Per Year" placeholder="Interest Rate Per Year"
                                v-model="interestRate" :error="interestRateError" classInput="h-[48px]">
                            </InputGroup> -->

                            <!-- <div class="fromGroup relative" :class="`${interestTypeError ? 'has-error' : ''}  `">
                                <label :class="`inline-block input-label `">{{ 'Interest Type' }}</label>
                                <select name="swift" class="input-control block w-full focus:outline-none h-[48px]"
                                    v-model="interestType">
                                    <option value="">Select A Type</option>
                                    <option value="flat_rate">Flat Rate</option>
                                    <option value="fixed_rate">Fixed Rate</option>
                                    <option value="mortgage">Mortgage Amortization</option>
                                    <option value="one_time">One Time Payment</option>
                                </select>

                                <span v-if="interestTypeError" class="mt-2 text-danger-500 block text-sm">{{
                                    interestTypeError
                                }}</span>
                            </div> -->
                        </div>

                        <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-5">
                            <!-- <InputGroup type="number" label="Term" placeholder="Terms" v-model="terms" :error="termsError"
                                classInput="h-[48px]">
                                <template v-slot:prepend>

                                    <div class="fromGroup relative" :class="`${termPeriodError ? 'has-error' : ''}  `">
                                        <select name="swift" class="input-control block w-auto focus:outline-none h-[48px]"
                                            v-model="termPeriod">
                                            <option value="">Select A Period</option>
                                            <option value="day">Day</option>
                                            <option value="week">Week</option>
                                            <option value="month">Month</option>
                                            <option value="year">Year</option>
                                        </select>

                                        <span v-if="termPeriodError" class="mt-2 text-danger-500 block text-sm">{{
                                            termPeriodError
                                        }}</span>
                                    </div>
                                </template>
                            </InputGroup> -->

                            <!-- <div class="fromGroup relative" :class="`${statusError ? 'has-error' : ''}  `">
                                <label :class="`inline-block input-label `">{{ 'Status' }}</label>
                                <select name="swift" class="input-control block w-full focus:outline-none h-[48px]"
                                    v-model="status">
                                    <option value="">Select A Status</option>
                                    <option value="active">Activate</option>
                                    <option value="not_active">Deactivate</option>
                                </select>

                                <span v-if="statusError" class="mt-2 text-danger-500 block text-sm">{{ statusError
                                }}</span>
                            </div> -->
                        </div>

                        <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-5">

                            <Textarea label="Description" name="pn4" placeholder="Description..." v-model="description"
                                :error="descriptionError" />
                            <Textarea label="Remark" name="pn4" placeholder="Remark..." v-model="remark"
                                    :error="remarkError" />
                        </div>
                        
                        <div class="grid grid-cols-1 mt-5">
                            <label :class="`inline-block input-label `"> Attachment</label>

                            <div v-bind="getRootProps()"
                                class="w-full text-center border-dashed border border-secondary-500 rounded-md py-[52px] flex flex-col justify-center items-center"
                                :class="files.length === 0 ? 'cursor-pointer' : ' pointer-events-none'">
                                <div v-if="files.length === 0">
                                    <input v-bind="getInputProps()" class="hidden" />
                                    <img src="@/assets/images/svg/upload.svg" alt="" class="mx-auto mb-4" />
                                    <p v-if="isDragActive" class="text-sm text-slate-500 dark:text-slate-300 font-light">
                                        Drop the files here ...
                                    </p>
                                    <p v-else class="text-sm text-slate-500 dark:text-slate-300 font-light">
                                        Drop files here or click to upload.
                                    </p>
                                </div>
                                <div class="flex space-x-4">
                                    <div v-for="(file, i) in files" :key="i" class="mb-4 flex-none">
                                        <div class="h-[300px] w-[300px] mx-auto mt-6 rounded-md" key="{i}">
                                            <img :src="file.preview" class="object-cover h-full w-full block rounded-md" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-primary float-right text-center">
                            {{ buttonText }}
                        </button>
                    </form>

                </Card>
            </div>
            <div class="lg:col-span-4 col-span-12">
                <Card title="">

                </Card>
            </div>
        </div>
    </div>
</template>
<script>
import Breadcrumb from "@/views/components/Breadcrumbs";
import Card from "@/components/Card";
import InputGroup from "@/components/InputGroup";
import Textarea from "@/components/Textarea";
import Select from "@/components/Select";
import { useField, useForm } from "vee-validate";
import * as yup from "yup";
import { inject, ref } from "vue";
import { useAuthStore } from '@/store/authUser';
import { useRouter } from "vue-router";
import { useToast } from "vue-toastification";
import FromGroup from "@/components/FromGroup";
import axios from 'axios';
import vSelect from "vue-select";
import { Countries } from "@/constant/country";
import "vue-select/dist/vue-select.css";
import { useDropzone } from "vue3-dropzone";

import moment from 'moment';

export default {
    components: {
        InputGroup,
        Textarea,
        vSelect,
        Breadcrumb,
        FromGroup,
        Card,
        Select,
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
            users: ""
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

            toast.info("Creating Loan", {
                timeout: 5000,
            });

            const fromData = new FormData();
            fromData.append("attachment", files._rawValue[0]);
            fromData.append("loan_product_id", values.product);
            fromData.append("borrower_id", values.user);
            fromData.append("late_payment_penalties", values.latePayment);
            fromData.append("currency", values.currency);
            fromData.append("applied_amount", values.Amount);
            fromData.append("first_payment_date", values.firstPaymentDate);
            fromData.append("release_date", values.releaseDate);
            fromData.append("remarks", values.remark);
            fromData.append("description", values.description);

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/create_loan`, fromData, {
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

        return {

            getRootProps,
            getInputProps,
            ...rest,
            files,
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
            buttonText: "Create"
        };
    },
}
</script>
<style lang=""></style>
