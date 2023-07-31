<template>
    <div>
        <template v-if="notifications">
                    <vue-good-table :columns="columns" styleClass=" vgt-table  lesspadding2   v-middle" :rows="notifications"
                :pagination-options="{
                    enabled: false,
                    perPage: perpage,
                }" :sort-options="{
    enabled: false,
}">
                <template v-slot:table-row="props">
                    <div v-if="props.column.field == 'action'" class="flex items-center">
                        <!-- <div class="flex-1 text-start">
                            <h4 class="text-sm font-medium text-slate-600">
                                {{ Object.keys(JSON.parse(props.row.data))[0] }}
                            </h4>
                        </div> -->
                            <div class="flex text-left">
                            <div class="flex-none mr-3">
                                <div
                                class="h-10 w-10 rounded-full text-sm bg-slate-100 text-slate-900 dark:bg-slate-600 dark:text-slate-200 flex flex-col items-center justify-center font-normal capitalize"
                                >
                                {{ Object.keys(JSON.parse(props.row.data))[0]  }}
                                </div>
                            </div>
                            <div class="flex-1">
                                <div
                                :class="`${active
                                        ? 'text-slate-600 dark:text-slate-300'
                                        : ' text-slate-600 dark:text-slate-300'
                                    } text-sm`"
                                >
                                {{ Object.values(JSON.parse(props.row.data))[0]  }}
                                </div>
                            
                                <div class="text-secondary-500 dark:text-slate-400 text-xs">
                                {{ format_date(props.row.created_at) }}
                                </div>
                            </div>
                            </div>
                    </div>
                </template>
                <template #pagination-bottom="props" >
                    <div class="py-4 px-3 flex justify-center">
                        <Pagination :total="notifications.length" :current="current" :per-page="perpage" :pageRange="pageRange"
                            @page-changed="current = $event" :pageChanged="props.pageChanged"
                            :perPageChanged="props.perPageChanged" :options="options">
                            >
                        </Pagination>
                    </div>
                </template>
            </vue-good-table>
        </template>

    </div>
</template>
<script>
import Pagination from "@/components/Pagination";
import { activity } from "@/constant/basic-tablle-data";

import axios from 'axios';
import { useToast } from "vue-toastification";
import moment from 'moment';
export default {
    components: {
        Pagination,
    },

    data() {
        return {
            activity,
            notifications: "",
            current: 1,
            perpage: 10,
            pageRange: 5,
            searchTerm: "",
            actions: [
                {
                    name: "view",
                    icon: "heroicons-outline:eye",
                },
                {
                    name: "edit",
                    icon: "heroicons:pencil-square",
                },
                {
                    name: "delete",
                    icon: "heroicons-outline:trash",
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
                    label: "Action",
                    field: "action",
                },
            ],
        };
    },
    mounted() {
        this.dashboard();
    },
    methods: {
        format_date(value) {
            return moment(value).format("Do-MMM-YYYY hh:mm A");
        },
        dashboard() {

            let $this = this
            const toast = useToast();

            axios.post(`${import.meta.env.VITE_APP_API_URL}/admin/dashboard_notification`, {}, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {

                if (response.data?.status) {
                    $this.information = response.data?.data;

                    $this.notifications = $this.information.notifications;


                } else {
                    // let message = response.data?.message[0];
                    toast.error(message, {
                        timeout: 4000,
                    });
                }
            }).catch(function (error) {
                console.log(error)
                toast.error("Error  ", {
                    timeout: 5000,
                });
            });
        }
    }
};
</script>
<style lang="scss"></style>
