<template>
    <div>


        <div class="grid grid-cols-12 gap-5">
            <div class="lg:col-span-8 col-span-12">
                <!-- {{ users }} -->
                <Card title="Create Loan Payment">

                    <form @submit.prevent="onSubmit" class="space-y-4" enctype="multipart/form-data">

                        <div class="grid lg:grid-cols-1 md:grid-cols-1 grid-cols-1 gap-5">
                        
                            <FromGroup label="Payment Date" name="d2" :error="paymentDateError">
                                <flat-pickr  v-model="paymentDate" class="form-control h-[48px]" placeholder="Date"
                                    :config="{ enableTime: false, dateFormat: 'Y-m-d' }" />
                            </FromGroup>
                            
                            <div class="fromGroup relative" :class="`${loanError ? 'has-error' : ''}  `">
                                <label :class="`inline-block input-label `">{{ 'Loan' }}</label>
                                <select name="swift" class="input-control block w-full focus:outline-none h-[48px]" @change="getPayments"
                                    v-model="loan">
                                    <option value="">Select A Loan</option>
                                    <option v-for="item in loans" :key="item" :value="item.id">{{ item.loan_ref +" | "+item.borrower.name + " | " + item.currency+ " " + item.applied_amount  }}</option>
                                </select>
                                <span v-if="loanError" class="mt-2 text-danger-500 block text-sm">{{ loanError  }}</span>
                            </div>

                            <div class="fromGroup relative" :class="`${duesError ? 'has-error' : ''}  `">
                                <label :class="`inline-block input-label `">{{ 'Due Payments' }}</label>
                                <select name="swift" class="input-control block w-full focus:outline-none h-[48px]"
                                    v-model="dues" @change="getDetail">
                                    <option value="">Select A Due Loans</option>
                                    <option v-for="item in repayments" :key="item" :value="item.id">{{ item.repayment_date +" | USD"+item.amount_to_pay }}</option>
                                </select>
                                <span v-if="duesError" class="mt-2 text-danger-500 block text-sm">{{ duesError }}</span>
                            </div>

                        </div>
                        <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-5">
                            <InputGroup type="number" label="Late Penalties ( It will apply if payment date is over )" placeholder="Late Penalties" v-model="latePenalties"
                                    :error="latePenaltiesError" classInput="h-[48px]" append="$" isReadonly>
                            </InputGroup>
                            <InputGroup type="number" label="Amount To Pay" placeholder="Amount To Pay" v-model="ammountToPay" isReadonly
                                    :error="ammountToPayError" classInput="h-[48px]"  append="$">
                            </InputGroup>

                        </div>
                        
                        
                        <div class="grid lg:grid-cols-1 md:grid-cols-1 grid-cols-1 gap-5">
                                
                            <Textarea label="Remarks" name="pn4" placeholder="Remarks..." v-model="remark"
                                :error="remarkError" />
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

import moment from 'moment';

export default {
    components: {
        InputGroup,
        Textarea,
        vSelect,
         
        FromGroup,
        Card,
        Select,
         
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
            loans: "",
            repayments: "",
        }
    },
    mounted() {
        this.fetch_loans()
        this.fetch_currencies()
    },
    methods: {
        format_date(value) {
            return moment(value).format("Do-MMM-YYYY hh:mm A");
        },
        getDetail(e) {
            
            let $this = this
            let data = axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/list_loans_payment_detail_for_payments`, {
                'id': e.target.value
            }, {
                headers: {
                    "Authorization": "Bearer " + $this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {
                    $this.latePenalties = response.data.repayment.penalty
                    $this.ammountToPay =  response.data.repayment.amount_to_pay

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
        getPayments(e) {
            let $this = this
            let data = axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/list_loans_payment_for_payments`, {
                'loan_id': e.target.value
            }, {
                headers: {
                    "Authorization": "Bearer " + $this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {

                    $this.repayments = response.data.repayments

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
        fetch_loans() {
            let $this = this
            let data = axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/list_active_loans_for_payments`, {}, {
                headers: {
                    "Authorization": "Bearer " + $this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {

                    $this.loans = response.data.loans

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
            paymentDate: yup.string().required("Payment Date is required"),
            loan: yup.string().required("Loan is required"),
            dues: yup.string().required("Due Amount is required"),
            latePenalties: yup.number('Mininum Amount Can only be numbers').required("Mininum Amount is required"),
            ammountToPay: yup.number('ammountToPay Amount Can only be numbers').required("ammountToPay Amount is required"),
            remark: yup.string().required("Remark is required"),
        });
        const swal = inject("$swal");
        const toast = useToast();
        const router = useRouter();
        const auth = useAuthStore();

        const { handleSubmit } = useForm({
            validationSchema: schema,
        });

        const { value: paymentDate, errorMessage: paymentDateError } = useField("paymentDate");
        const { value: loan, errorMessage: loanError } = useField("loan");
        const { value: dues, errorMessage: duesError } = useField("dues");
        const { value: latePenalties, errorMessage: latePenaltiesError } = useField("latePenalties");
        const { value: ammountToPay, errorMessage: ammountToPayError } = useField("ammountToPay");
        const { value: remark, errorMessage: remarkError } = useField("remark");

        const onSubmit = handleSubmit((values) => {

            // if (parseFloat(values.latePenalties) > parseFloat(values.ammountToPay)) {
            //     toast.info("Minimun value can not be greater than Maximun Value", {
            //         timeout: 5000,
            //     });
            //     return
            // }
            toast.info("Creating Loan Payment", {
                timeout: 5000,
            });

            const fromData = new FormData();
            fromData.append("paid_at", values.paymentDate);
            fromData.append("loan_id", values.loan);
            fromData.append("late_penalties", values.latePenalties);
            fromData.append("amount_to_pay", values.ammountToPay);
            fromData.append("due_amount_of", values.dues);

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/create_loan_payment`, fromData, {
                headers: {
                    "Authorization": "Bearer " + auth.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {

                    toast.success(response.data?.message, {
                        timeout: 2000,
                    });

                    router.push({ name: 'admin-loan-payments' });

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
        
            paymentDate,
            paymentDateError,
            loan,
            loanError,
            latePenalties,
            latePenaltiesError,
            ammountToPay,
            ammountToPayError,
            dues,
            duesError,
            remark,
            remarkError,
            onSubmit,
            buttonText: "Create"
        };
    },
}
</script>
<style lang=""></style>
