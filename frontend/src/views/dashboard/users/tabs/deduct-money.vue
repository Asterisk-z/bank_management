<template>
    <Card title="Deduct Money">

        <form @submit.prevent="onSubmit" class="space-y-4" enctype="multipart/form-data">
            <div class="grid md:grid-cols-1 grid-cols-1 gap-5">

                <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-5">
                    <InputGroup type="text" label="Amount" placeholder="Amount" v-model="amount" :error="amountError"
                        classInput="h-[48px]">
                        <template v-slot:prepend>
                            <Select label="" :options="currencies" v-model="currency" style="width: 200px"
                                :error="currencyError" classInput="h-[48px]" />
                        </template>
                        <input name="btcValue" type="hidden" v-model="btcValue" />
                    </InputGroup>
                     <FromGroup label="Date " name="d2">
                        <flat-pickr  v-model="date" :error="dateError" class="form-control h-[48px]" placeholder="Date"
                            :config="{ enableTime: false, dateFormat: 'Y-m-d' }" />
                    </FromGroup>
                </div>
                
                <div class="grid lg:grid-cols-1 md:grid-cols-1 grid-cols-1 gap-5">
                    <Textarea label="Description" name="pn4" placeholder="Description..." v-model="description"
                        :error="descriptionError" />
                </div>

            </div>

            <div class="grid grid-cols-1 mt-5">
                <div class="space-y-5 m-4">
                    <button type="submit" class="btn btn-primary float-right text-center">
                        {{ buttonText }}
                    </button>
                </div>
            </div>

        </form>
    </Card>
</template>
<script>
import Textinput from "@/components/Textinput";
import Checkbox from "@/components/Checkbox";
import Card from "@/components/Card";
import Button from "@/components/Button";
import Dropdown from "@/components/Dropdown";
import Icon from "@/components/Icon";
import InputGroup from "@/components/InputGroup";
import FromGroup from "@/components/FromGroup";
import Textarea from "@/components/Textarea";
import Select from "@/components/Select";
import SelectCurrency from "@/views/dashboard/users/tabs/select-currency";
import { useField, useForm } from "vee-validate";
import * as yup from "yup";
import { inject, ref } from "vue";
import { useAuthStore } from '@/store/authUser';
import { useRouter } from "vue-router";
import { useToast } from "vue-toastification";
import axios from 'axios';

export default {
    components: {
        Textinput,
        Checkbox,
        Card,
        InputGroup,
        Dropdown,
        Button,
        Select,
        Icon,
        FromGroup,
        Textarea,
        SelectCurrency
    },
    data() {
        return {
            dateNtim: null,
            currencies: [
                {
                    value: "USD",
                    label: "USD",
                },
                {
                    value: "AUD",
                    label: "AUD",
                },
                {
                    value: "EUR",
                    label: "EUR",
                },
            ],
        };
    },

    setup() {
        const schema = yup.object({
            amount: yup.number('Amount Can only be numbers').moreThan(50, 'Amount must be More than 50 USD').max(1000000, 'Amount should not be above 1,000,000 USD').required("Amount is required"),
            description: yup.string().required("Description is required"),
            date: yup.string().required("Date is required"),
            currency: yup.string().required("Country Code is required"),
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
        const { value: currency, errorMessage: currencyError } = useField("currency");

        const onSubmit = handleSubmit((values) => {


            toast.info("Processing Deposit", {
                timeout: 5000,
            });

            let token = window.location.pathname.split('/').pop()
            const fromData = new FormData();
            fromData.append("amount", values.amount);
            fromData.append("description", values.description);
            fromData.append("currency", values.currency); 
            fromData.append("date", values.date);
            fromData.append("user_id", token);

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/deduct_money`, fromData, {
                headers: {
                    "Authorization": "Bearer " + auth.user.token
                }
            }).then(function (response) {
                if (response.data?.status) {
                    window.location.reload()
                    // toast.success("Deposit Received Successfully", {
                    //     timeout: 2000,
                    // });
                    // router.push("/app/deposit-history");

                    // router.push("/app/deposithistory");

                } else {
                    let message = response.data?.message[0];
                    toast.error(message, {
                        timeout: 4000,
                    });
                }
            }).catch(function (error) {
                // console.log(error);
                toast.error("Sorry, We are unable to receive your deposit", {
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
            amount,
            amountError,
            currency,
            currencyError,
            description,
            descriptionError,
            date,
            dateError, 
            onSubmit,
            buttonText: "Deduct Money"
        };
    },
};
</script>
<style lang=""></style>
