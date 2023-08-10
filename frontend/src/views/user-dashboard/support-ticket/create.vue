<template>
    <div>
        <div class="grid xl:grid-cols-1 grid-cols-1 gap-5">
            <Card title="Create Ticket">
                <form @submit.prevent="onSubmit" class="space-y-4">
                    <div class="grid lg:grid-cols-1 md:grid-cols-1 grid-cols-1 gap-5">
                        <Textinput label="Subject" type="text" placeholder="Subject" name="subject"
                            v-model="subject" :error="subjectError" classInput="h-[48px]" />
                        <Textinput label="Description" type="text" placeholder="Description" name="description" v-model="description" :error="descriptionError" classInput="h-[48px]" />
                        <Select label="Priority" :options="priorities" v-model="priority" :error="priorityError" classInput="h-[48px]" />
                    </div>

                    <div class="grid grid-cols-1 mt-5">
                        <label :class="`inline-block input-label `"> Attachment</label>

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
import axios from 'axios';
import Textarea from "@/components/Textarea";

export default {
    components: {
        Textinput,
        InputGroup,
        Dropdown,
        Select,
         
        Card,
    },
    data() {
        return {
            priorities: [
                {
                    label: 'Low',
                    value: 'low'
                }, {
                    label: 'Medium',
                    value: 'medium'
                }, {
                    label: 'High',
                    value: 'high'
                },
            ]
        }
    },
    mounted() {
        this.priority = this.priorities[0].value
    },
    setup() {

        const schema = yup.object({
            subject: yup.string().required("Subject is required"),
            description: yup.string().required("Description is required"),
            priority: yup.string().required("Priority is required"),
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

        
        const { value: subject, errorMessage: subjectError } = useField("subject");
        const { value: description, errorMessage: descriptionError } = useField("description");
        const { value: priority, errorMessage: priorityError } = useField("priority");

        const { getRootProps, getInputProps, ...rest } = useDropzone({ onDrop });

        const onSubmit = handleSubmit((values) => {

            toast.info("Creating Ticket", {
                timeout: 5000,
            });
            const fromData = new FormData();
            fromData.append("file", files._rawValue[0]);
            fromData.append("subject", values.subject);
            fromData.append("description", values.description);
            fromData.append("priority", values.priority);

            axios.post(`${import.meta.env.VITE_APP_API_URL}/customer/create_ticket`, fromData, {
                headers: {
                    "Authorization": "Bearer " + auth.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {

                    toast.success(" Ticket Created successfully", {
                        timeout: 2000,
                    });

                    router.push("/app/support-tickets");

                } else {
                    let message = response.data?.message[0];
                    toast.error(message, {
                        timeout: 4000,
                    });
                }
            }).catch(function (error) {
                 
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
            priority,
            priorityError,
            description,
            descriptionError,
            subject,
            subjectError,
            onSubmit,
            buttonText: "Send Ticket"
        };
    },
}
</script>
<style lang=""></style>
