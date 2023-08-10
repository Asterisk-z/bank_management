<template>
    <div>


        <div class="grid grid-cols-12 gap-5">
            <div class="lg:col-span-8 col-span-12">
                <!-- {{ users }} -->
                <Card title="Withdraw Money">

                    <form @submit.prevent="onSubmit" class="space-y-4" enctype="multipart/form-data">

                        <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-5">
                            <div class="fromGroup relative" :class="`${selecteUserError ? 'has-error' : ''}  `">
                                <label :class="`inline-block input-label `">{{ 'User' }}</label>
                                <select name="swift" class="input-control block w-full focus:outline-none h-[48px]"
                                    v-model="selecteUser">
                                    <option value="">Select A User</option>
                                    <option v-for="user in users" :value="user.id" v-bind:key="user.id">{{ user.name + " | " +
                                        user.email }}
                                    </option>
                                </select>

                                <span v-if="selecteUserError" class="mt-2 text-danger-500 block text-sm">{{ selecteUserError
                                }}</span>
                            </div>

                            <InputGroup type="text" label="Amount" placeholder="Amount" v-model="amount"
                                :error="amountError" classInput="h-[48px]">
                                <template v-slot:prepend>

                                    <div class="fromGroup relative"
                                        :class="`${selectedCurrencyError ? 'has-error' : ''}  `">
                                        <select name="swift" class="input-control block w-full focus:outline-none h-[48px]"
                                            v-model="selectedCurrency">
                                            <option value="">Select A Currency</option>
                                            <option v-for="currency in currencies" :value="currency.value"
                                                v-bind:key="currency.value">{{ currency.label }}
                                            </option>
                                        </select>
                                        <span v-if="selectedCurrencyError" class="mt-2 text-danger-500 block text-sm">{{
                                            selectedCurrencyError }}</span>
                                    </div>
                                </template>
                            </InputGroup>
                        </div>
                        <div class="grid lg:grid-cols-1 md:grid-cols-1 grid-cols-1 gap-5">
                         <FromGroup label="Date " name="d2">
                            <flat-pickr  v-model="date" :error="dateError" class="form-control h-[48px]" placeholder="Date"
                                :config="{ enableTime: false, dateFormat: 'Y-m-d' }" />
                        </FromGroup>
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
            history: '',
            currencies: [
                {
                    value: "USD",
                    label: "USD",
                    rate: 1.000000
                },
                {
                    value: "AUD",
                    label: "AUD",
                    rate: 0.983700
                },
                {
                    value: "EUR",
                    label: "EUR",
                    rate: 0.640000
                },
            ],
            users: [],
            selecteUser: "",
            selectedCurrency: "",
            selecteUserDetails: "",
            swiftCode: "",
            swiftCurrency: ""
        }
    },
    mounted() {
        this.get_users();
    },
    methods: {
        format_date(value) {
            return moment(value).format("Do-MMM-YYYY hh:mm A");
        },
        get_users() {

            let $this = this
            const toast = useToast();

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/list_user`, {}, {
                headers: {
                    "Authorization": "Bearer " + $this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {

                    $this.users = response.data.users;

                    toast.success("User List Updated Successfully", {
                        timeout: 2000,
                    });

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
                toast.error(error.response.data.message, {
                    timeout: 5000,
                });
            });
        },
    },
    setup() {
        const schema = yup.object({
            amount: yup.number('Amount Can only be numbers').required("Amount is required"),
            description: yup.string().required("Description is required"),
            selecteUser: yup.string().required("Bank is required"),
            selectedCurrency: yup.string().required("Currency is required"),
            date: yup.string().required("Date is required"),
        });
        const swal = inject("$swal");
        const toast = useToast();
        const router = useRouter();
        const auth = useAuthStore();

        const { handleSubmit } = useForm({
            validationSchema: schema,
        });

        const { value: amount, errorMessage: amountError } = useField("amount");
        const { value: date, errorMessage: dateError } = useField("date");
        const { value: description, errorMessage: descriptionError } = useField("description");
        const { value: selecteUser, errorMessage: selecteUserError } = useField("selecteUser");
        const { value: selectedCurrency, errorMessage: selectedCurrencyError } = useField("selectedCurrency");

        const onSubmit = handleSubmit((values) => {

            toast.info("Making Exchange", {
                timeout: 5000,
            });

            const fromData = new FormData();
            fromData.append("amount", values.amount);
            fromData.append("date", values.date);
            fromData.append("description", values.description);
            fromData.append("user", values.selecteUser);
            fromData.append("currency", values.selectedCurrency);

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/create_withdraw`, fromData, {
                headers: {
                    "Authorization": "Bearer " + auth.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {

                    toast.success(response.data?.message, {
                        timeout: 2000,
                    });

                    router.push({ name: 'admin-withdraw-history' });

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
                    router.push({ name: 'Login' })
                }
                toast.error(error.response.data.message, {
                    timeout: 5000,
                });
            });

        });

        return {
            date,
            dateError,
            amount,
            amountError,
            selecteUser,
            selecteUserError,
            selectedCurrency,
            selectedCurrencyError,
            description,
            descriptionError,
            onSubmit,
            buttonText: "Withdraw"
        };
    },
}
</script>
<style lang=""></style>
