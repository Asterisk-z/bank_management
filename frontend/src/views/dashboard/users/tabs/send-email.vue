<template>
    <Card title="Send Email">

        <form @submit.prevent="onSubmit" class="space-y-4" enctype="multipart/form-data">
            <div class="grid md:grid-cols-1 grid-cols-1 gap-5">

                <div class="grid lg:grid-cols-1 md:grid-cols-1 grid-cols-1 gap-5">
                    <InputGroup type="text" label="Subject" placeholder="Subject" v-model="subject" :error="subjectError"
                        classInput="h-[48px]">
                    </InputGroup>

                    <Textarea label="message" name="pn4" placeholder="message..." v-model="message"
                        :error="messageError" />
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
            message: yup.string().required("message is required"),
            subject: yup.string().required("Subject is required"),
        });
        const swal = inject("$swal");
        const toast = useToast();
        const router = useRouter();
        const auth = useAuthStore();

        const { handleSubmit } = useForm({
            validationSchema: schema,
        });

        const { value: subject, errorMessage: subjectError } = useField("subject");
        const { value: message, errorMessage: messageError } = useField("message");

        const onSubmit = handleSubmit((values) => {


            toast.info("Sending Email", {
                timeout: 5000,
            });

            let token = window.location.pathname.split('/').pop()
            const fromData = new FormData();
            fromData.append("subject", values.subject);
            fromData.append("message", values.message);
            fromData.append("user_id", token);

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/user_send_email`, fromData, {
                headers: {
                    "Authorization": "Bearer " + auth.user.token
                }
            }).then(function (response) {
                if (response.data?.status) {
                    window.location.reload()
                    toast.success("Mail Sebt Successfully", {
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
                    router.push({ name: 'Login' })
                }
                // console.log(error);
                // toast.error("Sorry, We are unable to receive your deposit", {
                //     timeout: 5000,
                // });
            });

        });

        return {
            subject,
            subjectError,
            message,
            messageError,
            onSubmit,
            buttonText: "Send Mail"
        };
    },
};
</script>
<style lang=""></style>
