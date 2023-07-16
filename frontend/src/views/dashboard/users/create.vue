<template>
    <div>
        <Breadcrumb />

        <div class="grid xl:grid-cols-1 grid-cols-1 gap-5">
            <Card title="Create User">
                <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-5">
                    <Textinput label="First Name" name="first_name" type="text" placeholder="First name" />
                    <Textinput label="Last Name" name="last_name" type="text" placeholder="Last name" />
                    <Textinput label="Email" name="email" type="email" placeholder="Type your email" />
                    <Textinput label="Account Number" name="account" type="phone" placeholder="Type your email" />

                    <InputGroup type="text" label="Phone">
                        <template v-slot:prepend>
                            <Dropdown classMenuItems="left-0  w-[220px] top-[110%] ">
                                <Button text="Action" btnClass="btn-dark" icon="heroicons-outline:chevron-right"
                                    iconPosition="right" div iconClass="text-lg" />
                            </Dropdown>
                        </template>
                    </InputGroup>

                    <Textinput label="Company" name="hmi_commpanyname" type="text" placeholder="Company name" />

                </div>

                <div class="grid grid-cols-4 gap-5 mt-4">
                    <Select label="Batch" name="hmi_country" />
                    <Select label="Status" name="hmi_country" />
                    <Select label="Email Varified" name="hmi_country" />
                    <Select label="Country" name="hmi_country" />
                </div>

                <div class="grid grid-cols-1 mt-5">

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
import Icon from "@/components/Icon";
import Button from "@/components/Button";
import Textinput from "@/components/Textinput";
import Checkbox from "@/components/Checkbox";
import Dropdown from "@/components/Dropdown";
import Select from "@/components/Select";
import InputGroup from "@/components/InputGroup";
import { useDropzone } from "vue3-dropzone";
import { ref } from "vue";

export default {
    components: {
        Textinput,
        InputGroup,
        Dropdown,
        Checkbox,
        Select,
        Breadcrumb,
        Card,
        Icon,
        Button,
    },
    data() {
        return {
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
