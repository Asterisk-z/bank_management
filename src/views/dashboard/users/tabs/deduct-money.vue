<template>
         <Card title="Deduct Money">
            <div class="grid grid-cols-1 gap-5 space-y-1">
                <FromGroup label="Date & TIme" name="d2">
                    <flat-pickr
                        v-model="dateNtim"
                        class="form-control"
                        placeholder="Date & Time"
                        id="d2"
                        :config="{ enableTime: true, dateFormat: 'Y-m-d H:i' }"
                    />
                </FromGroup>

                <InputGroup type="text" label="Amount">
                    <template v-slot:prepend>
                        <SelectCurrency/>
                    </template>
                </InputGroup>
                
                <Textarea label="Note" name="pn4" placeholder="Note..." />

                <Button text="Submit" btnClass="btn-dark" />
            </div>
         </Card>
</template>
<script>
import Textinput from "@/components/Textinput";
import Checkbox from "@/components/Checkbox";
import Card from "@/components/Card";
import Button from "@/components/Button";
import Dropdown from "@/components/Dropdown";
import Icon from "@/components/Icon";
import InputGroup from "@/components/InputGroup";
import FromGroup from "@/components/FromGroup";
import Textarea from "@/components/Textarea";
import SelectCurrency from "@/views/dashboard/users/tabs/select-currency";

export default {
    components: {
        Textinput,
        Checkbox,
        Card,
        InputGroup,
        Dropdown,
        Button,
        Icon,
        FromGroup,
        Textarea,
        SelectCurrency
    },
    data() {
        return {
            dateNtim: null,
        };
    },
};
</script>
<style lang=""></style>
