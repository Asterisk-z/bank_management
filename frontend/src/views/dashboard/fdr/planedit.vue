<template>
    <div>


        <div class="grid grid-cols-12 gap-5">
            <div class="lg:col-span-8 col-span-12">
                <!-- {{ users }} -->
                <Card title="Edit Fixed Deposit Plan">

                    <form @submit.prevent="onSubmit" class="space-y-4" enctype="multipart/form-data">

                        <div class="grid lg:grid-cols-3 md:grid-cols-3 grid-cols-1 gap-5">
                            <InputGroup type="text" label="Name" placeholder="Name" v-model="name" :error="nameError"
                                classInput="h-[48px]">
                            </InputGroup>
                            <InputGroup type="number" label="Minimum Amount" placeholder="Minimum Amount" v-model="minimum"
                                :error="minimumError" classInput="h-[48px]" append="$">
                            </InputGroup>
                            <InputGroup type="number" label="Maximum Amount" placeholder="Maximum Amount" v-model="maximum"
                                :error="maximumError" classInput="h-[48px]" append="$">
                            </InputGroup>

                        </div>
                        <div class="grid lg:grid-cols-3 md:grid-cols-3 grid-cols-1 gap-5">
                            <InputGroup type="number" label="Interest Rate" placeholder="Interest Rate" v-model="rate"
                                :error="rateError" classInput="h-[48px]" append="%">
                            </InputGroup>

                            <InputGroup type="number" label="Duration" placeholder="Duration" v-model="duration"
                                :error="durationError" classInput="h-[48px] w-full">
                                <template v-slot:prepend>

                                    <div class="fromGroup relative" :class="`${durationTypeError ? 'has-error' : ''}  `">
                                        <select name="swift" class="input-control block w-auto focus:outline-none h-[48px]"
                                            v-model="durationType">
                                            <option value="">Select</option>
                                            <option value="day">Day</option>
                                            <option value="week">Week</option>
                                            <option value="month">Month</option>
                                            <option value="year">Year</option>
                                        </select>
                                        <span v-if="durationTypeError" class="mt-2 text-danger-500 block text-sm">{{
                                            durationTypeError }}</span>
                                    </div>
                                </template>
                            </InputGroup>

                            <div class="fromGroup relative" :class="`${statusError ? 'has-error' : ''}  `">
                                <label :class="`inline-block input-label `">{{ 'Status' }}</label>
                                <select name="swift" class="input-control block w-full focus:outline-none h-[48px]"
                                    v-model="status">
                                    <option value="">Select A User</option>
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
        Breadcrumb,
        FromGroup,
        Card,
        Select,
        Breadcrumb,
    },
    data() {
        return {
            history: '',
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
            name: yup.string().required("Name is required"),
            minimum: yup.number('Mininum Amount Can only be numbers').required("Mininum Amount is required"),
            maximum: yup.number('Maximum Amount Can only be numbers').required("Maximum Amount is required"),
            rate: yup.number('Rate Can only be numbers').required("Rate is required"),
            duration: yup.number('Duration Can only be numbers').required("Duration is required"),
            durationType: yup.string().required("Duration Type is required"),
            status: yup.string().required("Status is required"),
            description: yup.string().required("Description is required"),
        });
        const swal = inject("$swal");
        const toast = useToast();
        const router = useRouter();
        const auth = useAuthStore();

        const { handleSubmit } = useForm({
            validationSchema: schema,
        });

        const { value: name, errorMessage: nameError } = useField("name");
        const { value: minimum, errorMessage: minimumError } = useField("minimum");
        const { value: maximum, errorMessage: maximumError } = useField("maximum");
        const { value: rate, errorMessage: rateError } = useField("rate");
        const { value: duration, errorMessage: durationError } = useField("duration");
        const { value: durationType, errorMessage: durationTypeError } = useField("durationType");
        const { value: status, errorMessage: statusError } = useField("status");
        const { value: description, errorMessage: descriptionError } = useField("description");

        const onSubmit = handleSubmit((values) => {

            if (parseFloat(values.minimum) > parseFloat(values.maximum)) {
                toast.info("Minimun value can not be greater than Maximun Value", {
                    timeout: 5000,
                });
                return
            }
            toast.info("Creating Plan", {
                timeout: 5000,
            });

            let token = window.location.pathname.split('/')
            let id = token.pop();
            const fromData = new FormData();
            fromData.append("plan_id", id);
            fromData.append("name", values.name);
            fromData.append("minimum", values.minimum);
            fromData.append("maximum", values.maximum);
            fromData.append("rate", values.rate);
            fromData.append("duration", values.duration);
            fromData.append("durationType", values.durationType);
            fromData.append("status", values.status);
            fromData.append("description", values.description);

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/update_fd_plan`, fromData, {
                headers: {
                    "Authorization": "Bearer " + auth.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {

                    toast.success(response.data?.message, {
                        timeout: 2000,
                    });

                    router.push({ name: 'admin-fixed-deposit-request-package' });

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
        

        let token = window.location.pathname.split('/')
        let id = token.pop();
        let data = axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/plan`, {
            plan_id: id,
        }, {
            headers: {
                "Authorization": "Bearer " + auth.user.token
            }
        }).then(function (response) {

            if (response.data?.status) {

                name.value = response.data.plan.name
                minimum.value = response.data.plan.minimum_amount
                maximum.value = response.data.plan.maximum_amount
                rate.value = response.data.plan.interest_rate
                duration.value = response.data.plan.duration
                durationType.value = response.data.plan.duration_type
                status.value = response.data.plan.status
                description.value = response.data.plan.description

            } else {
                router.push("/app/users");
                let message = response.data?.message[0];
                toast.error(message, {
                    timeout: 4000,
                });
            }
        }).catch(function (error) {
            router.push("/app/users");
        });

        return {
            name,
            nameError,
            minimum,
            minimumError,
            maximum,
            maximumError,
            rate,
            rateError,
            duration,
            durationError,
            durationType,
            durationTypeError,
            status,
            statusError,
            description,
            descriptionError,
            onSubmit,
            buttonText: "Update Plan"
        };
    },
}
</script>
<style lang=""></style>
