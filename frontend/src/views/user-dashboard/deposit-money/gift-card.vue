<template>
    <div>
        <Breadcrumb />

        <div class="grid xl:grid-cols-1 grid-cols-1 gap-5">
            <Card title="Redeem Gift Card">
                <div class="grid md:grid-cols-1 grid-cols-1 gap-5">

                    <InputGroup type="text" label="Gift Card Code" placeholder="Code">
                    </InputGroup>

                </div>

                <div class="grid grid-cols-1 mt-5">
                    <div class="space-y-5 m-4">
                        <Button text="Redeem" btnClass="btn-primary  float-right" />
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
import InputGroup from "@/components/InputGroup";
import VueSelect from "@/components/Select/VueSelect";
import Textarea from "@/components/Textarea";
import SelectCurrency from "@/views/dashboard/components/select-currency";

export default {
    components: {
        InputGroup,
        Textarea,
        Breadcrumb,
        Card,
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

    },
}
</script>
<style lang=""></style>
