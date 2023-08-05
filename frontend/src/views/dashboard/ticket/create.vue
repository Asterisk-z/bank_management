<template>
    <div>


        <div class="grid grid-cols-12 gap-5">
            <div class="lg:col-span-8 col-span-12">
                <!-- {{ users }} -->
                <Card title="Create Ticket">

                    <form @submit.prevent="onSubmit" class="space-y-4" enctype="multipart/form-data">
                        
                        <div class="grid lg:grid-cols-1 md:grid-cols-1 grid-cols-1 gap-5">
                            
                            <div class="fromGroup relative" :class="`${selecteUserError ? 'has-error' : ''}  `">
                                <label :class="`inline-block input-label `">{{ 'User' }}</label>
                                <select name="swift" class="input-control block w-full focus:outline-none h-[48px]"
                                    v-model="selecteUser">
                                    <option value="">Select A User</option>
                                    <option v-for="user in users" :value="user.id" v-bind:key="user.id">{{ user.name + " | " +
                                        user.email }}
                                    </option>
                                </select>

                                <span v-if="selecteUserError" class="mt-2 text-danger-500 block text-sm">{{ selecteUserError
                                }}</span>
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-1 md:grid-cols-1 grid-cols-1 gap-5">

                            <InputGroup type="text" label="Subject" placeholder="Subject" v-model="subject"
                                :error="subjectError" classInput="h-[48px]">
                            </InputGroup>
                        </div>
                        
                        <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-5">
                            
                            <div class="fromGroup relative" :class="`${isActiveError ? 'has-error' : ''}  `">
                                <label :class="`inline-block input-label `">{{ 'Status' }}</label>
                                <select name="swift" class="input-control block w-full focus:outline-none h-[48px]"
                                    v-model="isActive">
                                    <option value="">Select </option>
                                    <option value="active">Open</option>
                                    <option value="pending">Pending</option>
                                </select>

                                <span v-if="isActiveError" class="mt-2 text-danger-500 block text-sm">{{ isActiveError
                                }}</span>
                            </div>

                            <Select label="Priority" :options="priorities" v-model="priority" :error="priorityError" classInput="h-[48px]" />


                        </div>
                        
                        <div class="grid lg:grid-cols-1 md:grid-cols-1 grid-cols-1 gap-5">
                            <Textarea label="Description" name="pn4" placeholder="Description..." v-model="description"
                                :error="descriptionError" />
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
import { useDropzone } from "vue3-dropzone";
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
        this.get_users();
    },
    methods: {
        format_date(value) {
            return moment(value).format("Do-MMM-YYYY hh:mm A");
        },
        get_users() {

            let $this = this
            const toast = useToast();

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/list_user`, {}, {
                headers: {
                    "Authorization": "Bearer " + $this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {

                    $this.users = response.data.users;

                    toast.success("User List Updated Successfully", {
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
                    $this.$router.push({ name: 'Login' })
                }
                toast.error(error.response.data.message, {
                    timeout: 5000,
                });
            });
        },
    },
    setup() {
        const schema = yup.object({
            subject: yup.string().required("Subject is required"),
            selecteUser: yup.string().required("User is required"),
            isActive: yup.string().required("Status is required"),
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
        const { value: selecteUser, errorMessage: selecteUserError } = useField("selecteUser");
        const { value: isActive, errorMessage: isActiveError } = useField("isActive");

        const { getRootProps, getInputProps, ...rest } = useDropzone({ onDrop });
        const onSubmit = handleSubmit((values) => {

            toast.info("Creating", {
                timeout: 5000,
            });

            const fromData = new FormData();
            fromData.append("file", files._rawValue[0]);
            fromData.append("user", values.selecteUser);
            fromData.append("subject", values.subject);
            fromData.append("priority", values.priority);
            fromData.append("description", values.description);
            fromData.append("status", values.isActive);

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/create_ticket`, fromData, {
                headers: {
                    "Authorization": "Bearer " + auth.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {

                    toast.success(response.data?.message, {
                        timeout: 2000,
                    });

                    router.push({ name: 'admin-all-tickets' });

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
                toast.error(error.response.data.message, {
                    timeout: 5000,
                });
            });

        });
        
        
        
        
        
        return {
            getRootProps,
            getInputProps,
            ...rest,
            files,
            priority,
            priorityError,
            selecteUser,
            selecteUserError,
            description,
            descriptionError,
            subject,
            subjectError,
            isActive,
            isActiveError,
            onSubmit,
            buttonText: "Create"
        };
    },
}
</script>
<style lang=""></style>
