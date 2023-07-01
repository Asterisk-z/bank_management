<template>
    <div>
        <Breadcrumb />

        <div class="grid xl:grid-cols-1 grid-cols-1 gap-5">
            <Card title="Loan Request">
                <div class="grid md:grid-cols-1 grid-cols-1 gap-5">
                    <div class="grid md:grid-cols-2 grid-cols-2 gap-5">

                        <VueSelect :options="options" label="Account Number/Email" />
                        <FromGroup label="First Payment Date " name="d2">
                            <flat-pickr v-model="dateNtim" class="form-control" placeholder="Date & Time" id="d2"
                                :config="{ enableTime: true, dateFormat: 'Y-m-d H:i' }" />
                        </FromGroup>
                    </div>

                    <InputGroup type="text" label="Amount" placeholder="00">
                        <template v-slot:prepend>
                            <SelectCurrency />
                        </template>
                    </InputGroup>

                     
                    <div v-bind="getRootProps()"
                        class="w-full text-center border-dashed border border-secondary-500 rounded-md py-[52px] flex flex-col justify-center items-center"
                        :class="files.length === 0 ? 'cursor-pointer' : ' pointer-events-none'" label="Amount" >
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

                    <div class="grid md:grid-cols-2 grid-cols-2 gap-5">

                        <Textarea label="Description" name="pn4" placeholder="Description..." />
                        <Textarea label="Remarks" name="pn4" placeholder="Remarks..." />
                    </div>

                </div>

                <div class="grid grid-cols-1 mt-5">
                    <div class="space-y-5 m-4">
                        <Button text="Submit" btnClass="btn-dark  float-right" />
                    </div>
                </div>
            </Card>
        </div>


    </div>
</template>
<script>
import Breadcrumb from "@/views/components/Breadcrumbs";
import Card from "@/components/Card";
import Button from "@/components/Button";
import Dropdown from "@/components/Dropdown";
import Select from "@/components/Select";
import InputGroup from "@/components/InputGroup";
import VueSelect from "@/components/Select/VueSelect";
import FromGroup from "@/components/FromGroup";
import Textarea from "@/components/Textarea";
import SelectCurrency from "@/views/dashboard/components/select-currency";
import { useDropzone } from "vue3-dropzone";
import { ref } from "vue";

export default {
    components: {
        InputGroup,
        Dropdown,
        Textarea,
        Select,
        Breadcrumb,
        Card,
        FromGroup,
        Button,
        VueSelect,
        SelectCurrency
    },
    data() {
        return {
            options: [
                {
                    value: "user1",
                    label: "User 1",
                },
                {
                    value: "user2",
                    label: "User 2",
                },
                {
                    value: "user3",
                    label: "User 3",
                },
            ],
        }
    },
    setup() {
        const files = ref([]);
        function onDrop(acceptFiles) {
            files.value = acceptFiles.map((file) =>
                Object.assign(file, {
                    preview: URL.createObjectURL(file),
                })
            );
        }

        const { getRootProps, getInputProps, ...rest } = useDropzone({ onDrop });

        return {
            getRootProps,
            getInputProps,
            ...rest,
            files,
        };
    },
}
</script>
<style lang=""></style>
