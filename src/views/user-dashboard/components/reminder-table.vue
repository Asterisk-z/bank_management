<template>
    <div>
            <Card  bodyClass="m-2">
                <div class="rounded-md bg-white dark:bg-slate-800 p-4 relative border-l-4 border-indigo-500 "   >
                    <div class="max-w-full">
                        <h4 class="text-lg font-medium text-slate-900 dark:text-white mb-2">
                            Deposit 500 to My wallet
                        </h4>
                        <p class="text-sm text-slate-600 dark:text-slate-300 text-opacity-80">
                            4min ago
                        </p>
                    </div>
                </div>
            </Card>
            <Card  bodyClass="m-2">
                <div class="rounded-md bg-white dark:bg-slate-800 p-4 relative border-l-4 border-indigo-500 "   >
                    <div class="max-w-full">
                        <h4 class="text-lg font-medium text-slate-900 dark:text-white mb-2">
                            Deposit 500 to My wallet
                        </h4>
                        <p class="text-sm text-slate-600 dark:text-slate-300 text-opacity-80">
                            4min ago
                        </p>
                    </div>
                </div>
            </Card>
    </div>
</template>
<script>

import Card from "@/components/Card";
export default {
    components: {
        Card  
    },

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
                    label: "Action",
                    field: "status",
                },
            ],
        };
    },
};
</script>
<style lang="scss"></style>
