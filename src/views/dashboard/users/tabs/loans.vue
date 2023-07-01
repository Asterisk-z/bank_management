<template>
    <div>
        <Card noborder>
            <div class="md:flex pb-6 items-center">
                <h6 class="flex-1 md:mb-0 mb-3">Loans</h6>
                <div class="md:flex md:space-x-3 items-center flex-none rtl:space-x-reverse"
                    :class="window.width < 768 ? 'space-x-rb' : ''">
                    <InputGroup v-model="searchTerm" placeholder="Search" type="text" prependIcon="heroicons-outline:search"
                        merged />
                        
                    <Button
                        icon="heroicons-outline:plus-sm"
                        text="Add Loan"
                        btnClass=" btn-dark font-normal btn-sm "
                        iconClass="text-lg"
                        link="invoice-add"
                    />
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
                    }">
                    <template v-slot:table-row="props">
                        <span v-if="props.column.field == 'customer'" class="flex items-center">
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
                                    } `">
                                {{ props.row.status }}
                            </span>
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
    },

    data() {
        return {
            advancedTable,
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
                    label: "Loan ID",
                    field: "order",
                },
                {
                    label: "Loan Product",
                    field: "customer",
                },
                {
                    label: "Applied Amount",
                    field: "date",
                },

                {
                    label: "Total Payable",
                    field: "quantity",
                },

                {
                    label: "Amount Paid",
                    field: "amount",
                },

                {
                    label: "Due Amount",
                    field: "status",
                },
                {
                    label: "Release Date",
                    field: "status",
                },
                {
                    label: "Status",
                    field: "status",
                },
            ],
        };
    },
};
</script>
<style lang="scss"></style>
