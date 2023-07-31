<template>
    <div>
        <Listbox v-model="selectedStatus">
            <div class="relative z-[22]">
                <ListboxButton
                    class="relative w-full flex justify-between cursor-pointer rounded-md bg-white items-center min-w-[110px] form-control py-2 px-3 dark:text-slate-300">
                    <span class="text-sm">{{ selectedStatus.name }}</span>
                    <span>
                        <Icon icon="heroicons-outline:chevron-down" />
                    </span>
                </ListboxButton>

                <Transition leave-active-class="transition duration-100 ease-in" leave-from-class="opacity-100"
                    leave-to-class="opacity-0">
                    <ListboxOptions
                        class="absolute max-h-60 w-full overflow-auto border border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded bg-white mt-1">
                        <ListboxOption v-slot="{ active }" v-for="item in statuses" :key="item.name" :value="item"
                            as="template">
                            <li :class="[
                                active
                                    ? 'bg-secondary-500 text-white dark:bg-slate-600 dark:bg-opacity-60'
                                    : 'text-slate-600 dark:text-slate-300',
                                'w-full border-b border-b-gray-500 border-opacity-10 px-4 py-2 last:border-none text-sm last:mb-0 cursor-pointer first:rounded-t last:rounded-b flex space-x-2 items-center rtl:space-x-reverse',
                            ]">
                                {{ item.name }}
                            </li>
                        </ListboxOption>
                    </ListboxOptions>
                </Transition>
            </div>
        </Listbox>
    </div>
</template>

<script setup>
import { ref } from "vue";
import {
    Listbox,
    ListboxButton,
    ListboxOptions,
    ListboxOption,
} from "@headlessui/vue";
import Icon from "@/components/Icon";
const statuses = [{ name: "All Transaction" }, { name: "Pending" }, { name: "Approved" }, { name: "Rejected" }];
const selectedStatus = ref(statuses[0]);
</script>
