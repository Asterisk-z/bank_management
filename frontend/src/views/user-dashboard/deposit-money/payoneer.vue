<template>
    <div>
        <div class="grid xl:grid-cols-1 grid-cols-1 gap-5">
            <Card title="Payment With Payoneer">
                
                <form @submit.prevent="onSubmit" class="space-y-4"  enctype="multipart/form-data">
                    
                    <div class="grid lg:grid-cols-1 md:grid-cols-1 grid-cols-1 gap-5">
                        <InputGroup type="text" label="Amount" placeholder="Amount" v-model="amount" :error="amountError" classInput="h-[48px]">
                            <template v-slot:prepend>
                                <Select label="" :options="currencies" v-model="currency"  style="width: 200px" :error="currencyError" classInput="h-[48px]"/>
                            </template>
                        </InputGroup>
                        
                        <Textarea label="Description" name="pn4" placeholder="Description..."  v-model="description" :error="descriptionError"/>
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

    </div>
</template>
<script>
 
import Card from "@/components/Card";
import InputGroup from "@/components/InputGroup";
import Textarea from "@/components/Textarea";
import { useDropzone } from "vue3-dropzone";
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
         
        Card,
        Select,
         
    },
    data() {
        return {
            currencies: [
                {
                    value: "USD",
                    label: "USD",
                },
            ],
        }
    },
    mounted() {
        this.currency = this.currencies[0].value
    },
    setup() {
        const schema = yup.object({
            amount: yup.number('Amount Can only be numbers').required("amount is required"),
            description: yup.string().required("Description is required"),
            currency: yup.string().required("Country Code is required"),
            // file: yup.string().required("File is required"),
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

        const { value: amount, errorMessage: amountError } = useField("amount");
        const { value: description, errorMessage: descriptionError } = useField("description");
        const { value: currency, errorMessage: currencyError } = useField("currency");
        const { value: file, errorMessage: fileError } = files;

        const { getRootProps, getInputProps, ...rest } = useDropzone({ onDrop });

        const onSubmit = handleSubmit((values) => {

            if (!files._rawValue[0]) {
                toast.info("Please Provide Prove Of Payment", {
                    timeout: 5000,
                });
                return;
            }

            toast.info("Processing Deposit", {
                timeout: 5000,
            });

            const fromData = new FormData();
            fromData.append("file", files._rawValue[0]);
            fromData.append("amount", values.amount);
            fromData.append("description", values.description);
            fromData.append("currency", values.currency);

            axios.post(`${import.meta.env.VITE_APP_API_URL}/customer/deposit_via_payoneer`, fromData, {
                    headers: {
                        "Authorization": "Bearer " + auth.user.token
                    }
            }).then(function (response) {
                if (response.data?.status) {

                    toast.success("Deposit Received Successfully", {
                        timeout: 2000,
                    });
                    // router.push("/app/deposit-history");
                    router.push("/app/deposithistory");

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
                    $this.$router.push({ name: 'Login' })
                }
                toast.error("Sorry, We are unable to receive your deposit", {
                    timeout: 5000,
                });
                
            });

        });

        return {
            getRootProps,
            getInputProps,
            ...rest,
            files,
            amount,
            amountError,
            currency,
            currencyError,
            description,
            descriptionError,
            // file,
            // fileError,
            onSubmit,
            buttonText: "Make Deposit"
        };
    },
}
</script>
<style lang=""></style>
