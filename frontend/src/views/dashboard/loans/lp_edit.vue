<template>
    <div>


        <div class="grid grid-cols-12 gap-5">
            <div class="lg:col-span-8 col-span-12">
                <!-- {{ users }} -->
                <Card title="Edit Loan Product">

                    <form @submit.prevent="onSubmit" class="space-y-4" enctype="multipart/form-data">

                        <div class="grid lg:grid-cols-1 md:grid-cols-1 grid-cols-1 gap-5">
                            <InputGroup type="text" label="Name" placeholder="Name" v-model="name" :error="nameError"
                                classInput="h-[48px]">
                            </InputGroup>

                        </div>
                        <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-5">
                            <InputGroup type="number" label="Minimum Transfer Amount" placeholder="Minimum Transfer Amount"
                                v-model="minimum" :error="minimumError" classInput="h-[48px]" append="$">
                            </InputGroup>
                            <InputGroup type="number" label="Maximum Transfer Amount" placeholder="Maximum Transfer Amount"
                                v-model="maximum" :error="maximumError" classInput="h-[48px]" append="$">
                            </InputGroup>

                        </div>
                        <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-5">
                            <InputGroup type="number" label="Interest Rate Per Year" placeholder="Interest Rate Per Year"
                                v-model="interestRate" :error="interestRateError" classInput="h-[48px]">
                            </InputGroup>

                            <div class="fromGroup relative" :class="`${interestTypeError ? 'has-error' : ''}  `">
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
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-5">
                            <InputGroup type="number" label="Term" placeholder="Terms" v-model="terms" :error="termsError"
                                classInput="h-[48px]">
                                <template v-slot:prepend>

                                    <div class="fromGroup relative" :class="`${termPeriodError ? 'has-error' : ''}  `">
                                        <!-- <label :class="`inline-block input-label `">{{ '' }}</label> -->
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
                            </InputGroup>

                            <div class="fromGroup relative" :class="`${statusError ? 'has-error' : ''}  `">
                                <label :class="`inline-block input-label `">{{ 'Status' }}</label>
                                <select name="swift" class="input-control block w-full focus:outline-none h-[48px]"
                                    v-model="status">
                                    <option value="">Select A Status</option>
                                    <option value="active">Activate</option>
                                    <option value="not_active">Deactivate</option>
                                </select>

                                <span v-if="statusError" class="mt-2 text-danger-500 block text-sm">{{ statusError
                                }}</span>
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-1 md:grid-cols-1 grid-cols-1 gap-5">

                            <Textarea label="Description" name="pn4" placeholder="Description..." v-model="description"
                                :error="descriptionError" />
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
import { useRouter, useRoute } from "vue-router";
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
        }
    },
    mounted() {
        this.fetch_currencies()
    },
    methods: {
        format_date(value) {
            return moment(value).format("Do-MMM-YYYY hh:mm A");
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

            });
        }
    },

    setup() {
        const schema = yup.object({
            name: yup.string().required("Name is required"),
            interestRate: yup.string().required("Interest Rate is required"),
            termPeriod: yup.string().required("Term Period is required"),
            interestType: yup.string().required("Interest Type is required"),
            terms: yup.number('Terms Can only be numbers').required("Term is required"),
            minimum: yup.number('Mininum Amount Can only be numbers').required("Mininum Amount is required"),
            maximum: yup.number('Maximum Amount Can only be numbers').required("Maximum Amount is required"),
            status: yup.string().required("Status is required"),
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

        const { value: name, errorMessage: nameError } = useField("name");
        const { value: interestRate, errorMessage: interestRateError } = useField("interestRate");
        const { value: terms, errorMessage: termsError } = useField("terms");
        const { value: termPeriod, errorMessage: termPeriodError } = useField("termPeriod");
        const { value: interestType, errorMessage: interestTypeError } = useField("interestType");
        const { value: minimum, errorMessage: minimumError } = useField("minimum");
        const { value: maximum, errorMessage: maximumError } = useField("maximum");
        const { value: status, errorMessage: statusError } = useField("status");
        const { value: description, errorMessage: descriptionError } = useField("description");

        const onSubmit = handleSubmit((values) => {

            if (parseFloat(values.minimum) > parseFloat(values.maximum)) {
                toast.info("Minimun value can not be greater than Maximun Value", {
                    timeout: 5000,
                });
                return
            }
            toast.info("Creating Loan Product", {
                timeout: 5000,
            });

            let id = route.params.loan_product_id;
            const fromData = new FormData();
            fromData.append("id", id);
            fromData.append("name", values.name);
            fromData.append("interest_rate", values.interestRate);
            fromData.append("minimum_amount", values.minimum);
            fromData.append("maximum_amount", values.maximum);
            fromData.append("term", values.terms);
            fromData.append("description", values.description);
            fromData.append("interest_type", values.interestType);
            fromData.append("term_period", values.termPeriod);
            fromData.append("status", values.status);

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/update_loan_product`, fromData, {
                headers: {
                    "Authorization": "Bearer " + auth.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {

                    toast.success(response.data?.message, {
                        timeout: 2000,
                    });

                    router.push({ name: 'admin-loan-products' });

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
            });

        });

        
        let id = route.params.loan_product_id;
        let data = axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/get_loan_product`, {
            id: id,
        }, {
            headers: {
                "Authorization": "Bearer " + auth.user.token
            }
        }).then(function (response) {

            if (response.data?.status) {

                name.value = response.data.loan_product.name
                interestRate.value = response.data.loan_product.interest_rate
                terms.value = response.data.loan_product.term
                termPeriod.value = response.data.loan_product.term_period
                interestType.value = response.data.loan_product.interest_type
                minimum.value = response.data.loan_product.minimum_amount
                maximum.value = response.data.loan_product.maximum_amount
                status.value = response.data.loan_product.status
                description.value = response.data.loan_product.description

            } else {
                router.push({ name: 'admin-loan-products' });
                let message = response.data?.message[0];
                toast.error(message, {
                    timeout: 4000,
                });
            }
        }).catch(function (error) {
            router.push({ name: 'admin-loan-products' });
        });

        return {

            name,
            nameError,
            interestRate,
            interestRateError,
            termPeriod,
            termPeriodError,
            interestType,
            interestTypeError,
            minimum,
            minimumError,
            maximum,
            maximumError,
            terms,
            termsError,
            status,
            statusError,
            description,
            descriptionError,
            onSubmit,
            buttonText: "Update"
        };
    },
}
</script>
<style lang=""></style>
