<template>
    <Card title="Update Password">

        <form @submit.prevent="onSubmit" class="space-y-4" enctype="multipart/form-data">
            <div class="grid md:grid-cols-1 grid-cols-1 gap-5">

                <div class="grid lg:grid-cols-1 md:grid-cols-1 grid-cols-1 gap-5">
                    
                    <Textinput label="Present Password" type="password" placeholder="Password" name="password" v-model="password" :error="passwordError" hasicon classInput="h-[48px]"/>
                    <Textinput label="New Password" type="password" placeholder="New Password" name="new_password" v-model="new_password" :error="new_passwordError" hasicon classInput="h-[48px]"/>
                    <Textinput label="Confirm Password" type="password" placeholder="Confirm Password" name="confirm_password" v-model="confirm_password" :error="confirm_passwordError" hasicon classInput="h-[48px]"/>

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
            password: yup.string().required("Password is required").min(8),
            new_password: yup.string().required("Password is required").min(8),
            confirm_password: yup.string().required("Confirm Password is required").min(8),
        });
        const swal = inject("$swal");
        const toast = useToast();
        const router = useRouter();
        const auth = useAuthStore();

        const { handleSubmit } = useForm({
            validationSchema: schema,
        });

        const { value: password, errorMessage: passwordError } = useField("password");
        const { value: new_password, errorMessage: new_passwordError } = useField("new_password");
        const { value: confirm_password, errorMessage: confirm_passwordError } = useField("confirm_password");

        const onSubmit = handleSubmit((values) => {


            toast.info("Processing", {
                timeout: 5000,
            });

            let token = window.location.pathname.split('/').pop()

            const fromData = new FormData();
            fromData.append("old_password", values.password);
            fromData.append("password", values.new_password);
            fromData.append("password_confirmation", values.confirm_password);

            axios.post(`${import.meta.env.VITE_APP_API_URL}/customer/update_password`, fromData, {
                headers: {
                    "Authorization": "Bearer " + auth.user.token
                }
            }).then(function (response) {
                if (response.data?.status) {
                    window.location.reload()
                    toast.success("Password Updated Successfully", {
                        timeout: 2000,
                    });
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
                 
                if (error.response?.data?.error == 'Unauthorized') {
                    router.push({ name: 'Login' })
                }
            });

        });

        return {
            password,
            passwordError,
            new_password,
            new_passwordError,
            confirm_password,
            confirm_passwordError,
            onSubmit,
            buttonText: "Update Password"
        };
    },
};
</script>
<style lang=""></style>
