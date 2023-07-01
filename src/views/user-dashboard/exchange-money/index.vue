<template>
    <div>
        <Breadcrumb />

        <div class="grid xl:grid-cols-5 grid-cols-5 gap-5">
            <div class="col-span-3">
                <Card title="Exchange Money">
                    <div class="grid md:grid-cols-1 grid-cols-1 gap-5">
                    
                        <div class="grid md:grid-cols-2 grid-cols-2 gap-5">
                            <VueSelect :options="currencies" label="Exchange From" />
                            <VueSelect :options="currencies" label="Exchange To" />
                        </div>
                    
                        <div class="grid md:grid-cols-2 grid-cols-2 gap-5">
                            <Textinput label="Amount" name="amount" type="text" placeholder="Enter Amount" />
                            <Textinput label="Exchange Amount"   disabled isReadonly placeholder="000"/>
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
