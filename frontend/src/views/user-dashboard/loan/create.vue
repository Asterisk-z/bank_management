<template>
    <div>

        <div class="grid grid-cols-12 gap-5">
            <div class="lg:col-span-8 col-span-12">
                <!-- {{ loan_product }} -->
                <Card title="Loan Request">

                    <form @submit.prevent="onSubmit" class="space-y-4" enctype="multipart/form-data">

                        <div class="grid lg:grid-cols-3 md:grid-cols-3 grid-cols-1 gap-5">
                            <div class="fromGroup relative" :class="`${selectedProductError ? 'has-error' : ''}  `">
                                <label :class="`inline-block input-label `">{{ 'Loan Products' }}</label>
                                <select name="swift" class="input-control block w-full focus:outline-none h-[48px]" v-model="selectedProduct">
                                    <option>Select A Product</option>
                                    <option v-for="bank in loan_product" :value="bank.id" v-bind:key="bank.id">{{ bank.name }}</option>
                                </select>

                                <span v-if="selectedProductError" class="mt-2 text-danger-500 block text-sm">{{
                                    selectedProductError }}</span>
                            </div>
                            
                            <InputGroup type="text" label="Applied Amount" placeholder="Applied Amount" v-model="amount" :error="amountError" classInput="h-[48px]">
                                <template v-slot:prepend>
                                    <Select label="" :options="currencies" v-model="currency"  style="width: 100px" :error="currencyError" classInput="h-[48px]"/>
                                </template>
                            </InputGroup>

                            
                            <FromGroup label="First Payment Date " name="paymentDate" :error="paymentDateError" >
                                <flat-pickr class="form-control h-[48px]" placeholder="Date & Time" id="d2" name="paymentDate"
                                    :config="{ enableTime: false, dateFormat: 'Y-m-d' }"  v-model="paymentDate"  />
                            </FromGroup>
                        </div>
                        <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-5">
                            <Textarea label="Description" name="pn4" placeholder="Description..." v-model="description"
                                :error="descriptionError" />
                            <Textarea label="Remark" name="pn4" placeholder="Remark..." v-model="remark"
                                :error="remarkError" />
                        </div>
                        
                    
                    
                        <div class="grid grid-cols-1 mt-5">
                              <div class="fromGroup relative">
                                    <label :class="`inline-block input-label `"> Attachment</label>
                                    <div v-bind="getRootProps()"
                                        class="w-full text-center border-dashed border border-secondary-500 rounded-md py-[52px] flex flex-col justify-center items-center"
                                        :class="files.length === 0 ? 'cursor-pointer' : ' pointer-events-none'">
                                        <div v-if="files.length === 0">
                                            <input v-bind="getInputProps()" class="hidden" name="file"/>
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
                                    <!-- <span v-if="fileError" class="mt-2" :class="' text-danger-500 block text-sm' " >{{ fileError }}</span> -->
                              </div>
                        </div>

                        <button type="submit" class="btn btn-primary float-right text-center">
                            {{ buttonText }}
                        </button>
                    </form>

                </Card>
            </div>
            <div class="lg:col-span-4 col-span-12">
                <Card title="Loan History ">
                    <!-- <h5 class="text-xs font-medium">Send Money History</h5> -->
                    <ul class="space-y-3 mt-6 divide-y dark:divide-slate-700 divide-slate-100">
                        <!-- <li class="flex justify-between items-center text-xs text-slate-600 dark:text-slate-300 pt-3">
                            <span>{{ "You sent olang@royal.com 10 USD" }} </span>
                            <span>{{ "1st of May" }}</span>
                        </li>
                        <li class="flex justify-between items-center text-xs text-slate-600 dark:text-slate-300 pt-3">
                            <span>{{ "olang@royal.com credit you 10 USD" }} </span>
                            <span>{{ "1st of May" }}</span>
                        </li> -->
                    </ul>
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
import axios from 'axios';
import vSelect from "vue-select";
import { useDropzone } from "vue3-dropzone";
import "vue-select/dist/vue-select.css";
import FromGroup from "@/components/FromGroup";


export default {
    components: {
        InputGroup,
        Textarea,
        vSelect,
         
        Card,
        Select,
        FromGroup,
         
    },
    data() {
        return {
            voptions: [
                {
                    title: "HTML5",
                    meal: "meal",
                    author: {
                        firstName: "Remy",
                        lastName: "Sharp"
                    }
                }
            ],
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
            loan_product: [],
            selectedProduct: "",
            selectedProductDetails: "",
            swiftCode: "",
            swiftCurrency: ""
        }
    },
    mounted() {
        this.get_loan_products();
        this.currency = this.currencies[0].value
    },
    methods: {
        get_loan_products() {

            let $this = this
            const toast = useToast();

            axios.post(`${import.meta.env.VITE_APP_API_URL}/customer/list_loan_products`, {}, {
                headers: {
                    "Authorization": "Bearer " + $this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {

                    $this.loan_product = response.data.products;

                    toast.success(response.data.message, {
                        timeout: 2000,
                    });

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
        },
    },
    setup() {
        const schema = yup.object({
            amount: yup.number('Amount Can only be numbers').required("Amount is required"),
            paymentDate: yup.date().required("Payment Date is required"),
            remark: yup.string().required("Remark is required"),
            description: yup.string().required("Description is required"),
            selectedProduct: yup.string().required("Loan Product is required"),
            currency: yup.string().required("Currency is required"), 
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

        const { value: paymentDate, errorMessage: paymentDateError } = useField("paymentDate");
        const { value: amount, errorMessage: amountError } = useField("amount");
        const { value: remark, errorMessage: remarkError } = useField("remark"); 
        const { value: description, errorMessage: descriptionError } = useField("description");
        const { value: selectedProduct, errorMessage: selectedProductError } = useField("selectedProduct");
        const { value: currency, errorMessage: currencyError } = useField("currency");

        
        const { getRootProps, getInputProps, ...rest } = useDropzone({ onDrop });

        const onSubmit = handleSubmit((values) => {

            // if (!files._rawValue[0]) {
            //     toast.info("Please Provide Prove Of Payment", {
            //         timeout: 5000,
            //     });
            //     return;
            // }
            toast.info("Making Request", {
                timeout: 5000,
            });

            const fromData = new FormData();
            fromData.append("attachment", files._rawValue[0]);
            fromData.append("applied_amount", values.amount);
            fromData.append("description", values.description);
            fromData.append("remark", values.remark);
            fromData.append("loan_product", values.selectedProduct);
            fromData.append("currency", values.currency);
            fromData.append("first_payment_date", values.paymentDate);

            axios.post(`${import.meta.env.VITE_APP_API_URL}/customer/loan_request`, fromData, {
                headers: {
                    "Authorization": "Bearer " + auth.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {

                    toast.success(response.data?.message, {
                        timeout: 2000,
                    });
                    // router.push("/app/deposit-history");
                    router.push({name : "all-loan"});

                } else {
                    let message = response.data?.message[0];
                    toast.error(message, {
                        timeout: 4000,
                    });
                }
            }).catch(function (error) {
                console.log(error);

                toast.error(error.response.data.message, {
                    timeout: 5000,
                });
                 
                if (error.response?.data?.error == 'Unauthorized') {
                    router.push({ name: 'Login' })
                }
            });

        });

        return {
            
            getRootProps,
            getInputProps,
            ...rest,
            files,
            paymentDate,
            paymentDateError, 
            currency,
            currencyError,
            amount,
            amountError,
            amount,
            amountError,
            selectedProduct,
            selectedProductError,
            remark, 
            remarkError,
            description,
            descriptionError,
            onSubmit,
            buttonText: "Send request"
        };
    },
}
</script>
<style lang=""></style>
