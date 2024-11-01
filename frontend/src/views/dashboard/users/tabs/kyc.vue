<template>
    <div>
        <Card noborder>
            <div class="md:flex pb-6 items-center">
                <h6 class="flex-1 md:mb-0 mb-3">KYC Documents</h6>
                <div class="md:flex md:space-x-3 items-center flex-none rtl:space-x-reverse"
                    :class="window.width < 768 ? 'space-x-rb' : ''">
                    <InputGroup v-model="searchTerm" placeholder="Search" type="text"
                        prependIcon="heroicons-outline:search" merged />

                </div>
            </div>
            <div class="-mx-6">
                <template v-if="kycs">
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
                            <span v-if="props.column.field == 'name'">
                                {{ props.row.document_name }}
                            </span>
                            <span v-if="props.column.field == 'message'">
                                {{ props.row.message }}
                            </span>
                            <span v-if="props.column.field == 'status'">
                                {{ props.row.status }}
                            </span>
                            <span v-if="props.column.field == 'action'">

                                <Dropdown classMenuItems=" w-[170px]" v-if="props.row.status == 'pending'">
                                    <span class="text-xl">
                                        <Icon icon="heroicons-outline:dots-vertical" />
                                    </span>
                                    <template v-slot:menus>
                                        <MenuItem>
                                        <div @click="approve_request(props.row.id)"
                                            :class="`'hover:bg-slate-900  hover:bg-opacity-100 hover:text-white w-full border-b border-b-gray-500 border-opacity-10 px-4 py-2 text-sm  last:mb-0 cursor-pointer first:rounded-t last:rounded-b flex  space-x-2 items-center rtl:space-x-reverse `">
                                            <span class="text-base">
                                                <Icon :icon="'heroicons-outline:check'" />
                                            </span>
                                            <span>Accept</span>
                                        </div>
                                        </MenuItem>
                                        <MenuItem>
                                        <div @click="cancel_request(props.row.id)"
                                            :class="`'bg-danger-500 text-danger-500 bg-opacity-30  hover:bg-opacity-100 hover:text-white w-full border-b border-b-gray-500 border-opacity-10 px-4 py-2 text-sm  last:mb-0 cursor-pointer first:rounded-t last:rounded-b flex  space-x-2 items-center rtl:space-x-reverse `">
                                            <span class="text-base">
                                                <Icon :icon="'heroicons-outline:trash'" />
                                            </span>
                                            <span>Reject</span>
                                        </div>
                                        </MenuItem>
                                    </template>
                                </Dropdown>
                            </span>

                        </template>

                        <template #pagination-bottom="props">
                            <div class="py-4 px-3">
                                <Pagination :total="kycs.length" :current="current" :per-page="perpage"
                                    :pageRange="pageRange" @page-changed="current = $event"
                                    :pageChanged="props.pageChanged" :perPageChanged="props.perPageChanged" enableSearch
                                    enableSelect :options="options">
                                    >
                                </Pagination>
                            </div>
                        </template>
                    </vue-good-table>
                </template>

            </div>
        </Card>
    </div>
</template>
<script>
import Dropdown from "@/components/Dropdown";
import Button from "@/components/Button";
import Card from "@/components/Card";
import Icon from "@/components/Icon";
import InputGroup from "@/components/InputGroup";
import Pagination from "@/components/Pagination";
import { MenuItem } from "@headlessui/vue";
import window from "@/mixins/window";
import axios from 'axios';
import { useToast } from "vue-toastification";
import Modal from '@/components/Modal/Modal';

export default {
    mixins: [window],
    components: {
        Pagination,
        InputGroup,
        Dropdown,
        Icon,
        Card,
        MenuItem,
        Button,
        Modal,
    },

    data() {
        return {
            current: 1,
            perpage: 10,
            app_url: import.meta.env.VITE_APP_API_BASEURL,
            pageRange: 5,
            kycs: '',
            searchTerm: "",
            actions: [
                {
                    name: "approve",
                    icon: "heroicons-outline:check",
                    doit: (id) => {
                        this.approve_request(id)
                    },
                },
                {
                    name: "reject",
                    icon: "heroicons-outline:trash",
                    doit: (id) => {
                        this.cancel_request(id)
                    },
                },
            ],
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
                },
                {
                    label: "Action",
                    field: "action",
                }
            ],
        };
    },

    methods: {
        create_loan() {
            this.$router.push({ name: "admin-loan-create" })
        },
        approve_request(pay_id) {
            let $this = this
            const toast = useToast();
            const formData = new FormData();
            formData.append('kyc_id', pay_id)
            formData.append('status', 'accepted')


            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/action_kyc`, formData, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {

                    toast.success("KYC  Accepted Successfully", {
                        timeout: 4000,
                    });
                    $this.getKycs()

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
            });
        },
        cancel_request(pay_id) {
            let $this = this
            const toast = useToast();
            const formData = new FormData();
            formData.append('kyc_id', pay_id)
            formData.append('status', 'rejected')

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/action_kyc`, formData, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {

                    toast.success("KYC Rejected Successfully", {
                        timeout: 4000,
                    });
                    $this.getKycs()

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
            });
        },
        getKycs() {
            const $this = this

            const toast = useToast();
            const fromData = new FormData();
            fromData.append("user_id", $this.$route.params.user_id);
            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/admin_user_kyc/${$this.$route.params.user_id}`, fromData, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {
                    // toast.success("User Found", {
                    //     timeout: 4000,
                    // });
                    $this.kycs = response.data.kycs
                } else {
                    let message = response.data?.message[0];
                    toast.error(message, {
                        timeout: 4000,
                    });
                }
            }).catch(function (result) {
                if (result.response?.data?.error == 'Unauthorized') {
                    $this.$router.push({ name: 'Login' })
                }
            });
        },
    },

    mounted() {
        this.getKycs()
    },

};
</script>
<style lang="scss"></style>
