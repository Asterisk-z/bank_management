<template>
    <div>
        <Breadcrumb />

        <div class="grid xl:grid-cols-1 grid-cols-1 gap-5">
            <Card title="Redeem Gift Card">
                <form @submit.prevent="onSubmit" class="space-y-4" enctype="multipart/form-data">
                    <div class="grid md:grid-cols-1 grid-cols-1 gap-5">

                        <div class="grid lg:grid-cols-1 md:grid-cols-1 grid-cols-1 gap-5">
                            <InputGroup type="text" label="Gift Card Code" placeholder="Code" v-model="code"
                                :error="codeError" classInput="h-[48px]" @change="findCode(code)">
                            </InputGroup>

                        </div>

                    </div>

                    <div class="grid grid-cols-1 mt-5">
                        <div class="space-y-5 m-4">
                            <button type="submit" class="btn btn-primary float-right text-center">
                                {{ buttonText }}
                                <spam v-if="CodeAmount">{{ CodeAmount }}</spam>
                            </button>
                        </div>
                    </div>

                </form>
            </Card>
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
import axios from 'axios';

export default {
    components: {
        InputGroup,
        Textarea,
        Breadcrumb,
        Card,
        Select,
    },
    data() {
        return {
            CodeAmount: "",
        }
    },
    mounted() {

    },
    methods: {
        findCode(code) {
            let $this = this
            axios.post(`${import.meta.env.VITE_APP_API_URL}/customer/check_gift_card`, {
                'code' : code
             }, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {
                if (response.data?.status) {
                    
                    toast.success("Found an Active Gift Card", {
                        timeout: 2000,
                    });
                    $this.CodeAmount = response.data?.data.amount
                } else {
                    let message = response.data?.message[0];
                    toast.error(message, {
                        timeout: 4000,
                    });
                }
            }).catch(function (error) {
                // console.log(error);
                // toast.error("Sorry, We are unable to receive your deposit", {
                //     timeout: 5000,
                // });
            });
        }
    },
    setup() {
        const schema = yup.object({
            code: yup.string('Code Can only be numbers').required("code is required"),
        });
        const swal = inject("$swal");
        const toast = useToast();
        const router = useRouter();
        const auth = useAuthStore();

        const { handleSubmit } = useForm({
            validationSchema: schema,
        });

        const { value: code, errorMessage: codeError } = useField("code");
        const { value: description, errorMessage: descriptionError } = useField("description");
        const { value: currency, errorMessage: currencyError } = useField("currency");
        const { value: btcValue, errorMessage: btcValueError } = useField("btcValue");

        const onSubmit = handleSubmit((values) => {


            toast.info("Processing Deposit", {
                timeout: 5000,
            });

            const fromData = new FormData();
            fromData.append("code", values.code);
            fromData.append("btc_value", values.btcValue);
            fromData.append("description", values.description);
            fromData.append("currency", values.currency);

            axios.post(`${import.meta.env.VITE_APP_API_URL}/customer/deposit_via_paypal`, fromData, {
                headers: {
                    "Authorization": "Bearer " + auth.user.token
                }
            }).then(function (response) {
                if (response.data?.status) {

                    toast.success("Deposit Received Successfully", {
                        timeout: 2000,
                    });
                    // router.push("/app/deposit-history");

                    router.push("/app/manual-deposit");

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
            });

        });

        return {
            code,
            codeError,
            currency,
            currencyError,
            description,
            descriptionError,
            btcValue: "0.00",
            btcValueError,
            onSubmit,
            buttonText: "Redeem"
        };
    },
}
</script>
<style lang=""></style>
