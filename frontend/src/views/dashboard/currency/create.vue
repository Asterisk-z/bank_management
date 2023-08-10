<template>
    <div>


        <div class="grid grid-cols-12 gap-5">
            <div class="lg:col-span-8 col-span-12">
                <!-- {{ users }} -->
                <Card title="Create Currency">

                    <form @submit.prevent="onSubmit" class="space-y-4" enctype="multipart/form-data">
                        
                        <div class="grid lg:grid-cols-1 md:grid-cols-1 grid-cols-1 gap-5">
                            
                            <InputGroup type="text" label="Name" placeholder="Name" v-model="name"
                                :error="nameError" classInput="h-[48px]">
                            </InputGroup>
                        </div>
                        <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-5">
                            
                            <InputGroup type="number" label="Exchange Rate" placeholder="Exchange Rate" v-model="rate"
                                :error="rateError" classInput="h-[48px]">
                            </InputGroup>
                            <InputGroup type="text" label="Sign" placeholder="Sign" v-model="sign"
                                :error="signError" classInput="h-[48px]">
                            </InputGroup>

                            <div class="fromGroup relative" :class="`${isBaseError ? 'has-error' : ''}  `">
                                <label :class="`inline-block input-label `">{{ 'Base Currency' }}</label>
                                <select name="swift" class="input-control block w-full focus:outline-none h-[48px]"
                                    v-model="isBase">
                                    <option value="">Select </option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>

                                <span v-if="isBaseError" class="mt-2 text-danger-500 block text-sm">{{ isBaseError
                                }}</span>
                            </div>
                            <div class="fromGroup relative" :class="`${isActiveError ? 'has-error' : ''}  `">
                                <label :class="`inline-block input-label `">{{ 'Status' }}</label>
                                <select name="swift" class="input-control block w-full focus:outline-none h-[48px]"
                                    v-model="isActive">
                                    <option value="">Select </option>
                                    <option value="active">Active</option>
                                    <option value="not_active">Not Active</option>
                                </select>

                                <span v-if="isActiveError" class="mt-2 text-danger-500 block text-sm">{{ isActiveError
                                }}</span>
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
            plans: [],
            selecteUser: "",
            selectedCurrency: "",
            selecteUserDetails: "",
        }
    },
    mounted() {

    },
    methods: {
        format_date(value) {
            return moment(value).format("Do-MMM-YYYY hh:mm A");
        },
    },
    setup() {
        const schema = yup.object({
            name: yup.string().length(3).required("Name is required"),
            rate: yup.number().required("Rate is required"),
            sign: yup.string().max(2).required("Sign is required"),
            isBase: yup.string().required("Base Status is required"),
            isActive: yup.string().required("Currency Status is required"),
        });
        const swal = inject("$swal");
        const toast = useToast();
        const router = useRouter();
        const auth = useAuthStore();

        const { handleSubmit } = useForm({
            validationSchema: schema,
        });

        const { value: name, errorMessage: nameError } = useField("name");
        const { value: rate, errorMessage: rateError } = useField("rate");
        const { value: sign, errorMessage: signError } = useField("sign");
        const { value: isBase, errorMessage: isBaseError } = useField("isBase");
        const { value: isActive, errorMessage: isActiveError } = useField("isActive");

        const onSubmit = handleSubmit((values) => {

            toast.info("Creating", {
                timeout: 5000,
            });

            const fromData = new FormData();
            fromData.append("name", values.name);
            fromData.append("rate", values.rate);
            fromData.append("sign", values.sign);
            fromData.append("base_status", values.isBase);
            fromData.append("status", values.isActive);

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/create_currency`, fromData, {
                headers: {
                    "Authorization": "Bearer " + auth.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {

                    toast.success(response.data?.message, {
                        timeout: 2000,
                    });

                    router.push({ name: 'admin-all-currency' });

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
                    $this.$router.push({ name: 'Login' })
                }
            });

        });
        
        
        
        
        
        return {
            name,
            nameError,
            rate,
            rateError,
            sign,
            signError,
            isBase,
            isBaseError,
            isActive,
            isActiveError,
            onSubmit,
            buttonText: "Create"
        };
    },
}
</script>
<style lang=""></style>
