<template>
    <div>
        <Breadcrumb />

        <Card noborder>
            <div class="md:flex pb-6 items-center">
                <h6 class="flex-1 md:mb-0 mb-3">Deposit Request</h6>
                <div class="md:flex md:space-x-3 items-center flex-none rtl:space-x-reverse"
                    :class="window.width < 768 ? 'space-x-rb' : ''">
                    <InputGroup v-model="searchTerm" placeholder="Search" type="text" prependIcon="heroicons-outline:search"
                        merged />
                    <Button icon="heroicons-outline:plus-sm" text="Add Record" btnClass=" btn-dark font-normal btn-sm "
                        iconClass="text-lg" link="invoice-add" />
                </div>
            </div>
            <div class="-mx-6">
                <vue-good-table :columns="columns" styleClass=" vgt-table  centered " :rows="advancedTable" :sort-options="{
                        enabled: false,
                    }" :pagination-options="{
                        enabled: true,
                        perPage: perpage,
                    }" :search-options="{
                        enabled: true,
                        externalQuery: searchTerm,
                    }" :select-options="{
                        enabled: true,
                        selectOnCheckboxOnly: true, // only select when checkbox is clicked instead of the row
                        selectioninfoClass: 'table-input-checkbox',
                        selectionText: 'rows selected',
                        clearSelectionText: 'clear',
                        disableSelectinfo: true, // disable the select info-500 panel on top
                        selectAllByGroup: true, // when used in combination with a grouped table, add a checkbox in the header row to check/uncheck the entire group
                    }">
                    <template v-slot:table-row="props">
                        <span v-if="props.column.field == 'customer'" class="flex items-center">
                            <span class="w-7 h-7 rounded-full ltr:mr-3 rtl:ml-3 flex-none">
                                <img :src="props.row.customer.image" :alt="props.row.customer.name"
                                    class="object-cover w-full h-full rounded-full" />
                            </span>
                            <span class="text-sm text-slate-600 dark:text-slate-300 capitalize font-medium">{{
                                props.row.customer.name }}</span>
                        </span>
                        <span v-if="props.column.field == 'order'" class="font-medium">
                            {{ "#" + props.row.order }}
                        </span>
                        <span v-if="props.column.field == 'date'" class="text-slate-500 dark:text-slate-400">
                            {{ props.row.date }}
                        </span>
                        <span v-if="props.column.field == 'status'" class="block w-full">
                            <span
                                class="inline-block px-3 min-w-[90px] text-center mx-auto py-1 rounded-[999px] bg-opacity-25"
                                :class="`${props.row.status === 'paid'
                                        ? 'text-success-500 bg-success-500'
                                        : ''
                                    } 
                                            ${props.row.status === 'due'
                                        ? 'text-warning-500 bg-warning-500'
                                        : ''
                                    }
                                            ${props.row.status === 'cancled'
                                        ? 'text-danger-500 bg-danger-500'
                                        : ''
                                    }
                                    `">
                                {{ props.row.status }}
                            </span>
                        </span>
                        <span v-if="props.column.field == 'action'">
                            <Dropdown classMenuItems=" w-[140px]">
                                <span class="text-xl">
                                    <Icon icon="heroicons-outline:dots-vertical" />
                                </span>
                                <template v-slot:menus>
                                    <MenuItem v-for="(item, i) in actions" :key="i">
                                    <div @click="item.doit"
                                        :class="`  ${item.name === 'delete'
                                                ? 'bg-danger-500 text-danger-500 bg-opacity-30  hover:bg-opacity-100 hover:text-white'
                                                : 'hover:bg-slate-900 hover:text-white'
                                            }  w-full border-b border-b-gray-500 border-opacity-10 px-4 py-2 text-sm  last:mb-0 cursor-pointer first:rounded-t last:rounded-b flex  space-x-2 items-center rtl:space-x-reverse `">
                                        <span class="text-base">
                                            <Icon :icon="item.icon" />
                                        </span>
                                        <span>{{ item.name }}</span>
                                    </div>
                                    </MenuItem>
                                </template>
                            </Dropdown>
                        </span>
                    </template>
                    <template #pagination-bottom="props">
                        <div class="py-4 px-3">
                            <Pagination :total="50" :current="current" :per-page="perpage" :pageRange="pageRange"
                                @page-changed="current = $event" :pageChanged="props.pageChanged"
                                :perPageChanged="props.perPageChanged" enableSearch enableSelect :options="options">
                                >
                            </Pagination>
                        </div>
                    </template>
                </vue-good-table>
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
import { advancedTable } from "@/constant/basic-tablle-data";
import window from "@/mixins/window";
import Breadcrumb from "@/views/components/Breadcrumbs";

export default {
    mixins: [window],
    components: {
        Pagination,
        InputGroup,
        Breadcrumb,
        Dropdown,
        Icon,
        Card,
        MenuItem,
        Button,
    },

    data() {
        return {
            advancedTable,
            current: 1,
            perpage: 10,
            pageRange: 5,
            searchTerm: "",
            actions: [
                {
                    name: "send",
                    icon: "ph:paper-plane-right",
                    doit: () => {
                        this.$router.push("/app/invoice-add");
                    },
                },
                {
                    name: "view",
                    icon: "heroicons-outline:eye",
                    doit: () => {
                        this.$router.push("/app/invoice-preview");
                    },
                },
                {
                    name: "edit",
                    icon: "heroicons:pencil-square",
                    doit: () => {},
                },
                {
                    name: "delete",
                    icon: "heroicons-outline:trash",
                    doit: () => { },
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
                    label: "Id",
                    field: "id",
                },
                {
                    label: "Created",
                    field: "order",
                },
                {
                    label: "Currency",
                    field: "customer",
                },
                {
                    label: "Amount",
                    field: "date",
                },

                {
                    label: "Status",
                    field: "quantity",
                },

                {
                    label: "Sender",
                    field: "amount",
                },

                {
                    label: "Receiver",
                    field: "status",
                },
                {
                    label: "Action",
                    field: "action",
                },
            ],
        };
    },
};
</script>
<style lang="scss"></style>
