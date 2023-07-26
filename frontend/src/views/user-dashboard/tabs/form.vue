<template>
         <Card title="">
            <div class="grid grid-cols-1 gap-5 space-y-1">

                <InputGroup type="text" label="Amount">
                    <!-- <template v-slot:prepend>
                        <SelectCurrency/>
                    </template> -->
                </InputGroup>
                
                <Textarea label="Note" name="pn4" placeholder="Note..." />

                <Button text="Submit" btnClass="btn-primary" />
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
