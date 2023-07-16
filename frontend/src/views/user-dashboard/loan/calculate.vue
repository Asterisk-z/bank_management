<template>
    <div>
        <Breadcrumb />

        <div class="grid xl:grid-cols-1 grid-cols-1 gap-5">
            <Card title="Loan Calculator">
                <div class="grid md:grid-cols-1 grid-cols-1 gap-5">

                    <InputGroup type="text" label="Amount" placeholder="00">
                        <template v-slot:prepend>
                            <SelectCurrency />
                        </template>
                    </InputGroup>

                    <div class="grid md:grid-cols-3 grid-cols-3 gap-5">
                        <InputGroup type="text"  label="Interest Rate Per Year"
                            placeholder="00" append="%" 
                            />
                        <VueSelect :options="options" label="Interest Type" />
                    
                        <InputGroup type="text" placeholder="Term" label="Term" />
                    </div>


                    <div class="grid md:grid-cols-3 grid-cols-3 gap-5">
                        <VueSelect :options="options" label="Term Period" />
                        <FromGroup label="First Payment date " name="d2">
                            <flat-pickr v-model="dateNtim" class="form-control" placeholder="Date & Time" id="d2"
                                :config="{ enableTime: true, dateFormat: 'Y-m-d H:i' }" />
                        </FromGroup>
                         <InputGroup type="text"  label="Late Payment Penalties"
                                placeholder="00" append="%" 
                                />
                    </div>


                </div>

                <div class="grid grid-cols-1 mt-5">
                    <div class="space-y-5 m-4">
                        <Button text="Calculate" btnClass="btn-dark  float-right" />
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
