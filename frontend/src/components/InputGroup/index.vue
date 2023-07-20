<template>
    <div>
        <Breadcrumb />

            <div class="grid xl:grid-cols-5 grid-cols-5 gap-5">
                <div class="col-span-3">
            <Card title="Wire Transfer">
                <div class="grid md:grid-cols-1 grid-cols-1 gap-5">
                
                    <VueSelect :options="currencies" label="Banks" />

                    <div class="grid md:grid-cols-2 grid-cols-2 gap-5">
                        <Textinput label="Swift Code" name="amount" type="text"  disabled isReadonly placeholder="000" />
                        <Textinput label="Currency" type="text"  disabled isReadonly placeholder="000"/>
                    </div>

                    
                    <div class="grid md:grid-cols-2 grid-cols-2 gap-5">
                        <Textinput label="Account Number" name="amount" type="text"  placeholder="000" />
                        <Textinput label="Account Holder Name" type="text"  placeholder="000"/>
                    </div>

                
                    <div class="">
                        <Textinput label="Amount" name="amount" type="text"  placeholder="000" description="Transfer Limit (USD 50.00 - USD 100000.00)" />
                        
                        <p class="text-sm font-light text-slate-600 dark:text-slate-300">
                            Transaction Fee USD 0.00 + 1.00%
                        </p>
                    </div>

                    <Textarea label="Note" name="pn4" placeholder="Note..." />

                </div>

                <div class="grid grid-cols-1 mt-5">
                    <div class="space-y-5 m-4">
                        <Button text="Exchange Money" btnClass="btn-primary  float-right" />
                    </div>
                </div>
            </Card>
            

                </div>
                <div class="col-span-2">
                    <Card>
                    
                    </Card>
                
                </div>
            </div>
    </div>
</template>
<script>
import Breadcrumb from "@/views/components/Breadcrumbs";
import Card from "@/components/Card";
import Button from "@/components/Button";
import InputGroup from "@/components/InputGroup";
import VueSelect from "@/components/Select/VueSelect";
import Textarea from "@/components/Textarea";
import Textinput from "@/components/Textinput";
import SelectCurrency from "@/views/dashboard/components/select-currency";

export default {
    components: {
        InputGroup,
        Textarea,
        Breadcrumb,
        Textinput,
        Card,
        Button,
        VueSelect,
        SelectCurrency
    },
    data() {
        return {
            currencies: [
                {
                    value: "USD",
                    label: "USD",
                },
                {
                    value: "AUD",
                    label: "AUD",
                },
                {
                    value: "EUR",
                    label: "EUR",
                },
            ],
        }
    },
    setup() {

    },
}
</script>
<style lang=""></style>
