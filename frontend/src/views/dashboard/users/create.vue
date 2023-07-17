<template>
    <div>
        <Breadcrumb />

        <div class="grid xl:grid-cols-1 grid-cols-1 gap-5">
            <Card title="Create User">
                <form @submit.prevent="onSubmit" class="space-y-4">
                    <Textinput label="First Name" type="text" placeholder="First Name" name="first_name" v-model="fname" :error="fnameError" classInput="h-[48px]"/>
                    <Textinput label="Last Name" type="text" placeholder="Last Name" name="last_name" v-model="lname" :error="lnameError" classInput="h-[48px]" />
                    <Textinput label="Email" type="email" placeholder="Type your email" name="emil" v-model="email" :error="emailError" classInput="h-[48px]" />
                
                    <InputGroup type="text" label="Phone Number" placeholder="Phone Number" v-model="phone" :error="phoneError">
                        <template v-slot:prepend>
                            <Select label="" :options="CountryCodeList" v-model="countryCode"  style="width: 200px"/>
                        </template>
                    </InputGroup>



                    <Textinput label="Password" type="password" placeholder="8+ characters, 1 capital letter " name="password" v-model="password" :error="passwordError" hasicon classInput="h-[48px]" />
                    <Textinput label="Confirm Password" type="password" placeholder="8+ characters, 1 capital letter " name="cpassword" v-model="cPassword" :error="cPasswordError" hasicon classInput="h-[48px]" />

                    <label class="cursor-pointer flex items-start">
                    <input  type="checkbox"  class="hidden"  @change="() => (checkbox = !checkbox)"/>
                    <span class="h-4 w-4 border rounded inline-flex mr-3 relative flex-none top-1 transition-all duration-150" :class="checkbox ? 'ring-2 ring-black-500 dark:ring-offset-slate-600 dark:ring-slate-900  dark:bg-slate-900 ring-offset-2 bg-slate-900' : 'bg-slate-100 dark:bg-slate-600 border-slate-100 dark:border-slate-600 '">
                        <img  src="@/assets/images/icon/ck-white.svg"  alt=""  class="h-[10px] w-[10px] block m-auto"  v-if="checkbox"/>
                    </span>
                    <span class="text-slate-500 dark:text-slate-400 text-sm leading-6">Accept our Terms and Conditions</span>
                    </label>

                    <button type="submit" class="btn btn-dark float-right text-center">
                    Create
                    </button>
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
        // Define a validation schema
        const schema = yup.object({
            email: yup.string().required(" Email is required").email(),
            password: yup.string().required("Password is  required").min(8),
            cPassword: yup.string().required("Password is  required").min(8),
            lname: yup.string().required("Last name is required"),
            fname: yup.string().required("First name is required"),
            phone: yup.string().required("Phone is required"),
            countryCode: yup.string().required("Country Code is required"),
        });
        const swal = inject("$swal");
        const toast = useToast();
        const router = useRouter();
        const auth = useAuthStore();

        // Create a form context with the validation schema
        const users = [];
        const { handleSubmit } = useForm({
            validationSchema: schema,
        });
        // No need to define rules for fields

        const { value: email, errorMessage: emailError } = useField("email");
        const { value: lname, errorMessage: lnameError } = useField("lname");
        const { value: fname, errorMessage: fnameError } = useField("fname");
        const { value: phone, errorMessage: phoneError } = useField("phone");
        const { value: countryCode, errorMessage: countryCodeError } = useField("countryCode");
        const { value: cPassword, errorMessage: cPasswordError } = useField("cPassword");
        const { value: password, errorMessage: passwordError } = useField("password");

        const onSubmit = handleSubmit((values) => {
            // add value into user array if same email not found

            console.log(values);
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
            email,
            emailError,
            phone,
            phoneError,
            countryCode,
            countryCodeError,
            fname,
            fnameError,
            lname,
            lnameError,
            password,
            passwordError,
            cPassword,
            cPasswordError,
            onSubmit,
        };
    },
}
</script>
<style lang=""></style>
