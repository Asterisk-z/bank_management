<template>
    <div>
        <form @submit.prevent="onSubmit" class="space-y-4" enctype="multipart/form-data">

            <div class="grid lg:grid-cols-1 md:grid-cols-1 grid-cols-1 gap-5">

                <Select :options="kyc_documents" v-model="kycDocument" style="width: 100%" label="KYC Document"
                    :error="kycDocumentError" classInput="h-[48px]" />


                <Textarea label="Description" name="pn4" placeholder="Description..." v-model="description"
                    :error="descriptionError" />
            </div>


            <div class="grid grid-cols-1 mt-5">
                <div class="fromGroup relative">
                    <label :class="`inline-block input-label `"> Document</label>
                    <div v-bind="getRootProps()"
                        class="w-full text-center border-dashed border border-secondary-500 rounded-md py-[52px] flex flex-col justify-center items-center"
                        :class="files.length === 0 ? 'cursor-pointer' : ' pointer-events-none'">
                        <div v-if="files.length === 0">
                            <input v-bind="getInputProps()" class="hidden" name="file" />
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
            </div>

            <button type="submit" class="btn btn-primary float-right text-center">
                {{ buttonText }}
            </button>
        </form>


        <div class="-mx-6 mt-6">

            <template v-if="kycs">
                <!-- {{ kycs }} -->
                <vue-good-table :columns="columns" styleClass=" vgt-table  centered " :rows="kycs" :sort-options="{
                    enabled: true,
                }" :pagination-options="{
                    enabled: true,
                    perPage: perpage,
                }" :search-options="{
                    enabled: true,
                    externalQuery: searchTerm,
                }">
                    <template v-slot:table-row="props">
                        <span v-if="props.column.field == 'attachment'">
                            <Modal v-if="props.row.attachment" title="View Document" label="View Document"
                                labelClass="btn-outline-dark" ref="modal2" centered>
                                <h4 class="font-medium text-lg mb-3 text-slate-900">

                                </h4>
                                <div class="text-base text-slate-600 dark:text-slate-300">
                                    <img :src="app_url + '/uploads/kyc_document/' + props.row.attachment"
                                        class="object-cover w-full h-full" />
                                </div>
                                <template v-slot:footer>
                                    <Button text="Close" btnClass="btn-dark " @click="$refs.modal2.closeModal()" />
                                </template>
                            </Modal>
                        </span>
                        <span v-if="props.column.field == 'id'">
                            {{ '-' }}
                        </span>
                        <span v-if="props.column.field == 'name'">
                            {{ props.row.document_name }}
                        </span>
                        <span v-if="props.column.field == 'message'">
                            {{ props.row.message }}
                        </span>
                        <span v-if="props.column.field == 'status'">
                            {{ props.row.status }}
                        </span>
                    </template>

                    <template #pagination-bottom="props">
                        <div class="py-4 px-3">
                            <Pagination :total="kycs.length" :current="current" :per-page="perpage"
                                :pageRange="pageRange" @page-changed="current = $event" :pageChanged="props.pageChanged"
                                :perPageChanged="props.perPageChanged" enableSearch enableSelect :options="options">
                                >
                            </Pagination>
                        </div>
                    </template>
                </vue-good-table>
            </template>

        </div>
    </div>
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
import { useDropzone } from "vue3-dropzone";
import Pagination from "@/components/Pagination";
import { useToast } from "vue-toastification";
import axios from 'axios';
import Modal from '@/components/Modal/Modal';

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
        SelectCurrency,
        Modal,
        Pagination
    },
    data() {
        return {
            kyc_documents: [],
            kycs: '',
            dateNtim: null,
            app_url: import.meta.env.VITE_APP_API_BASEURL,
            current: 1,
            perpage: 10,
            pageRange: 5,
            searchTerm: "",
            options: [
                {
                    value: "1",
                    label: "1",
                },
                {
                    value: "3",
                    label: "3",
                },
                {
                    value: "5",
                    label: "5",
                },
            ],
            columns: [
                {
                    label: "#",
                    field: "id",
                },
                {
                    label: "Document Name",
                    field: "name",
                },
                {
                    label: "Attachment",
                    field: "attachment",
                },
                {
                    label: "Description",
                    field: "message",
                },
                {
                    label: "Status",
                    field: "status",
                }
            ],
        }
    },
    mounted() {
        this.get_kyc_documents();
        this.get_kycs()
    },

    methods: {
        get_kyc_documents() {

            let $this = this
            const toast = useToast();

            axios.post(`${import.meta.env.VITE_APP_API_URL}/customer/kyc_documents`, {}, {
                headers: {
                    "Authorization": "Bearer " + $this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {

                    let kyc_documents = response.data.kyc_documents;

                    $this.kyc_documents = kyc_documents.map((item) => ({ 'value': item.id, 'label': item.name }))

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
        get_kycs() {

            let $this = this
            const toast = useToast();

            axios.post(`${import.meta.env.VITE_APP_API_URL}/customer/user_kycs`, {}, {
                headers: {
                    "Authorization": "Bearer " + $this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {

                    $this.kycs = response.data.kycs;

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
            kycDocument: yup.number('kycDocument Can only be numbers').required("KYC Document is required"),
            description: yup.string().required("Description is required"),
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

        const { value: kycDocument, errorMessage: kycDocumentError } = useField("kycDocument");
        const { value: description, errorMessage: descriptionError } = useField("description");
        const { value: file, errorMessage: fileError } = files;

        const { getRootProps, getInputProps, ...rest } = useDropzone({ onDrop });

        const onSubmit = handleSubmit((values) => {

            if (!files._rawValue[0]) {
                toast.info("Document Is required", {
                    timeout: 5000,
                });
                return;
            }

            const fromData = new FormData();
            fromData.append("attachment", files._rawValue[0]);
            fromData.append("kyc_document_id", values.kycDocument);
            fromData.append("message", values.description);

            buttonText.value = "Uploading..."
            axios.post(`${import.meta.env.VITE_APP_API_URL}/customer/upload_kyc`, fromData, {
                headers: {
                    "Authorization": "Bearer " + auth.user.token
                }
            }).then(function (response) {
                if (response.data?.status) {

                    toast.success("KYC uploaded Received Successfully", {
                        timeout: 2000,
                    });

                    window.location.reload()

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
                // toast.error("Sorry, We are unable to receive your deposit", {
                //     timeout: 5000,
                // });

            });

        });

        return {
            getRootProps,
            getInputProps,
            ...rest,
            files,
            kycDocument,
            kycDocumentError,
            description,
            descriptionError,
            onSubmit,
            buttonText: "Upload KYC"
        };
    },
};
</script>
<style lang=""></style>
