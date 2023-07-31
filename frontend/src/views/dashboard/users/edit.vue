<template>
    <div>
        <Breadcrumb />

        <div class="grid xl:grid-cols-1 grid-cols-1 gap-5">
            <Card title="Create User">
                <form @submit.prevent="onSubmit" class="space-y-4">
                    <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-5">
                        <Textinput label="First Name" type="text" placeholder="First Name" name="first_name" v-model="firstName" :error="firstNameError" classInput="h-[48px]"/>
                        <Textinput label="Last Name" type="text" placeholder="Last Name" name="last_name" v-model="lastName" :error="lastNameError" classInput="h-[48px]" />
                        <Textinput label="Email" type="email" placeholder="Type your email" name="emil" v-model="email" :error="emailError" classInput="h-[48px]" />
                    </div>
                    <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-5">
                        <InputGroup type="text" label="Phone Number" placeholder="Phone Number" v-model="phone" :error="phoneError" classInput="h-[48px]">
                            <template v-slot:prepend>
                                <Select label="" :options="CountryCodeList" v-model="countryCode"  style="width: 200px" :error="countryCodeError" classInput="h-[48px]"/>
                            </template>
                        </InputGroup>
                        <Textinput label="Account Number" type="text" placeholder="Account Number" name="account_number" v-model="accountNumber" :error="accountNumberError" classInput="h-[48px]" />
                        <Select label="branch" name="hmi_country"  :options="[{value: 1, label: 'Melbourne branch'}]"  classInput="h-[48px]" v-model="branch" :error="branchError" />
                    </div>
                    
                    
                    <div class="grid grid-cols-1 mt-5">

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

                    <button type="submit" class="btn btn-dark float-right text-center">
                        {{ buttonText }}
                    </button>
                </form>
            </Card>
        </div>

    </div>
</template>
<script>
import Breadcrumb from "@/views/components/Breadcrumbs";
import Card from "@/components/Card";
import Textinput from "@/components/Textinput";
import Dropdown from "@/components/Dropdown";
import Select from "@/components/Select";
import InputGroup from "@/components/InputGroup";
import { useField, useForm } from "vee-validate";
import * as yup from "yup";
import { inject, ref } from "vue";
import { useDropzone } from "vue3-dropzone";
import { useAuthStore } from '@/store/authUser';
import { useRouter } from "vue-router";
import { useToast } from "vue-toastification";
import { CountryCodeList } from "@/constant/country";
import axios from 'axios';

export default {
    components: {
        Textinput,
        InputGroup,
        Dropdown,
        Select,
        Breadcrumb,
        Card,
    },
    data() {
        return {
            CountryCodeList
        }
    },
    mounted() {
        this.countryCode = CountryCodeList[20].value
    },
    setup() {
        
        const schema = yup.object({
            email: yup.string().required(" Email is required").email(),
            lastName: yup.string().required("Last name is required"),
            firstName: yup.string().required("First name is required"),
            phone: yup.string('Phone Can only be numbers').required("Phone is required"),
            branch: yup.string().required("Branch is required"),
            accountNumber: yup.string().required("Account is required"),
            countryCode: yup.string().required("Country Code is required"),
        });
        const swal = inject("$swal");
        const toast = useToast();
        const router = useRouter();
        const auth = useAuthStore();
        
        const files = ref([]);
        function onDrop(acceptFiles) {
            files.value = acceptFiles.map((file) =>
                Object.assign(file, {
                    preview: URL.createObjectURL(file),
                })
            );
        }
        
        const { handleSubmit } = useForm({
            validationSchema: schema,
        });

        let { value: email, errorMessage: emailError } = useField("email");
        let { value: lastName, errorMessage: lastNameError } = useField("lastName");
        let { value: firstName, errorMessage: firstNameError } = useField("firstName");
        let { value: phone, errorMessage: phoneError } = useField("phone");
        let { value: branch, errorMessage: branchError } = useField("branch");
        let { value: accountNumber, errorMessage: accountNumberError } = useField("accountNumber");
        let { value: countryCode, errorMessage: countryCodeError } = useField("countryCode");

        const { getRootProps, getInputProps, ...rest } = useDropzone({ onDrop });

        const onSubmit = handleSubmit((values) => {
            
            toast.info("Updating User", {
                timeout: 5000,
            });
            let token = window.location.pathname.split('/')
            token.pop();
            let id = token.pop();

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/update_user`, {
                user_id: id,
                first_name: values.firstName,
                last_name: values.lastName,
                country_code: values.countryCode,
                email: values.email,
                phone_number: values.phone,
                branch_id: values.branch,
                account_number: values.accountNumber,
            }, {
                headers: {
                    "Authorization" : "Bearer "+ auth.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {

                    toast.success(" User Created successfully", {
                        timeout: 2000,
                    });
                    router.push("/app/users");

                } else {
                    let message = response.data?.message[0];
                    toast.error(message, {
                        timeout: 4000,
                    });
                }
            });

        });

        let token = window.location.pathname.split('/')
        token.pop();
        let id = token.pop();
        let data = axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/user`, {
            user_id: id,
        }, {
            headers: {
                "Authorization": "Bearer " + auth.user.token
            }
        }).then(function (response) {

            if (response.data?.status) {

                email.value = response.data.user.email
                lastName.value = response.data.user.last_name
                firstName.value = response.data.user.first_name
                phone.value = response.data.user.phone
                branch.value = response.data.user.branch_id
                countryCode.value = response.data.user.country_code

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
        if (data) {
            console.log(data)
        }
        return {
            getRootProps,
            getInputProps,
            ...rest,
            files,
            email,
            emailError,
            phone,
            phoneError,
            countryCode,
            countryCodeError,
            firstName,
            firstNameError,
            lastName,
            lastNameError,
            branch,
            branchError,
            accountNumber,
            accountNumberError,
            onSubmit,
            buttonText: "Update User"
        };
    },
}
</script>
<style lang=""></style>
