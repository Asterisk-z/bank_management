<template>
    <div>
        <vue-good-table :columns="columns" styleClass=" vgt-table  lesspadding2   v-middle" :rows="transactions" :sort-options="{
                enabled: false,
            }">
            <template v-slot:table-row="props">
                <div v-if="props.column.field == 'user'" class="flex items-center">
                    <div class="flex-1 text-start">
                        <h4 class="text-sm font-medium text-slate-600">
                            {{ props.row.user.name }}
                        </h4>
                    </div>
                </div>
                <span v-if="props.column.field == 'status'" class="block w-full">
                    <span class="inline-block px-3 min-w-[90px] text-center mx-auto py-1 rounded-[999px] bg-opacity-25"
                        :class="`${props.row.status === 'paid'
                            ? 'text-success-500 bg-success-500'
                            : ''
                            } 
                                                                ${props.row.status === 'due'
                                ? 'text-warning-500 bg-warning-500'
                                : ''
                            }
                                                                ${props.row.status === 'pending'
                                ? 'text-danger-500 bg-danger-500'
                                : ''
                            }
                                                                ${props.row.status === 'cancled'
                                ? 'text-danger-500 bg-danger-500'
                                : ''
                            }
                                                                ${props.row.status === 'shipped'
                                ? 'text-primary-500 bg-primary-500'
                                : ''
                            }

                                         `">
                        {{ props.row.status }}
                    </span>
                </span>
            </template>
        </vue-good-table>
    </div>
</template>
<script>

export default {

    data() {
        return {
            transactions : [
                {
                    user: {
                        name: "Esther Howard"
                    },
                    transaction: "#324567",
                    price: "$90.99",
                    status: "paid",
                },
                {
                    user: {
                        name: "Guy Hawkins",
                    },
                    transaction: "#4224",
                    price: "$78.65",
                    status: "due",
                },
                {
                    user: {
                        name: "Bessie Cooper",
                    },
                    transaction: "#4224",
                    price: "$78.65",
                    status: "pending",
                },
                {
                    user: {
                        name: "Kathryn Murphy",
                    },
                    transaction: "#4224",
                    price: "$38.65",
                    status: "cancled",
                },
                {
                    user: {
                        name: "Darrell Steward",
                    },
                    transaction: "#4224",
                    price: "$178.65",
                    status: "shipped",
                }], 
            current: 1,
            perpage: 5,
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
                    label: "Loan ID",
                    field: "user",
                },

                {
                    label: "Next Payment Date",
                    field: "transaction",
                },

                {
                    label: "Status",
                    field: "price",
                },
                {
                    label: "Amount to Pay",
                    field: "status",
                },
                {
                    label: "Action",
                    field: "status",
                },
            ],
        };
    },
};
</script>
<style lang="scss"></style>
