<template>
    <div>
        <Breadcrumb />

        <div class="grid xl:grid-cols-1 grid-cols-1 gap-5">
            <Card title="Create User">
      <form @submit.prevent="onSubmit" class="space-y-4">
                <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-5">
                    <Textinput label="First Name" name="first_name" type="text" placeholder="First name" v-model="first_name" :error="first_nameError" />
                    <Textinput label="Last Name" name="last_name" type="text" placeholder="Last name" v-model="first_name"/>
                    <Textinput label="Email" name="email" type="email" placeholder="Type your email" v-model="first_name"/>
                    <Textinput label="Account Number" name="account" type="phone" placeholder="Type your email" v-model="first_name"/>

                    <InputGroup type="text" label="Phone">
                        <template v-slot:prepend>
                            <Dropdown classMenuItems="left-0  w-[220px] top-[110%] ">
                                <Button text="Action" btnClass="btn-dark" icon="heroicons-outline:chevron-right"
                                    iconPosition="right" div iconClass="text-lg" />
                            </Dropdown>
                        </template>
                    </InputGroup>

                    <Textinput label="Company" name="hmi_commpanyname" type="text" placeholder="Company name" />

                </div>

                <div class="grid grid-cols-4 gap-5 mt-4">
                    <Select label="Batch" name="hmi_country" />
                    <Select label="Status" name="hmi_country" />
                    <Select label="Email Varified" name="hmi_country" />
                    <Select label="Country" name="hmi_country" />
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
                    <div class="space-y-5 m-4">          
                        <button type="submit" class="btn btn-dark float-right text-center">
                            Create
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
import Icon from "@/components/Icon";
import Button from "@/components/Button";
import Textinput from "@/components/Textinput";
import Checkbox from "@/components/Checkbox";
import Dropdown from "@/components/Dropdown";
import Select from "@/components/Select";
import InputGroup from "@/components/InputGroup";
import { useDropzone } from "vue3-dropzone";
import { ref } from "vue";
import { useField, useForm } from "vee-validate";
import * as yup from "yup";
import { inject } from "vue";
import { useAuthStore } from '@/store/authUser';
import { useRouter } from "vue-router";
import { useToast } from "vue-toastification";

export default {
    components: {
        Textinput,
        InputGroup,
        Dropdown,
        Checkbox,
        Select,
        Breadcrumb,
        Card,
        Icon,
        Button,
    },
    data() {
        return {
        }
    },
    setup() {
        const schema = yup.object({
            email: yup.string().nullable(" Email is required").email(),
            // last_name: yup.string().nullable("Last name is required"),
            // first_name: yup.string().nullable("First name is required"),
            // phone_number: yup.number().positive().integer().nullable("Phone is required"),
            // account_number: yup.number().positive().integer().nullable("Phone is required"),
            // branch: yup.string().nullable("Branch is required"),
            // country_code: yup.string().nullable("Country Code is required"),
            // countryCode: yup.string().required("Country Code is required"),
            // countryCode: yup.string().required("Country Code is required"),
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

        const { value: email, errorMessage: emailError } = useField("email");
        const { value: last_name, errorMessage: last_nameError } = useField("last_name");
        const { value: first_name, errorMessage: first_nameError } = useField("first_name");
        const { value: phone_number, errorMessage: phone_numberError } = useField("phone_number");
        const { value: account_number, errorMessage: account_numberError } = useField("account_number");
        const { value: branch, errorMessage: branchError } = useField("branch");
        const { value: country_code, errorMessage: country_codeError } = useField("country_code");

        const { getRootProps, getInputProps, ...rest } = useDropzone({ onDrop });

        const onSubmit = handleSubmit((values) => {
                // add value into user array if same email not found

                console.log("values");
                auth.register(values.fname, values.lname, values.countryCode, values.phone, values.email, values.password, values.cPassword)
                // if (!users.find((user) => user.email === values.email)) {
                //   // users.push(values);
                //   // localStorage.setItem("users", JSON.stringify(users));
                //   // router.push("/");
                //   // // use vue-toast-notification app use
                //   toast.success(" Account Create successfully", {
                //       timeout: 2000,
                //     });
                // } else {
                //   // use sweetalert 2
                //   swal.fire({
                //     title: "Email already exists",
                //     text: "Please try another email",
                //     icon: "error",
                //     confirmButtonText: "Ok",
                //   });
                // }
            });

        return {
            getRootProps,
            getInputProps,
            ...rest,
            files,
            email,
            emailError,
            last_name,
            last_nameError,
            first_name,
            first_nameError,
            phone_number,
            phone_numberError,
            account_number,
            account_numberError,
            branch,
            branchError,
            country_code,
            country_codeError,
        };
    },
}
</script>
<style lang=""></style>
