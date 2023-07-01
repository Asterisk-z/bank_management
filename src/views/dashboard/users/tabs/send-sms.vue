<template>
    <Card title="Send SMS">
        <div class="grid grid-cols-1 gap-5 space-y-1">
            <Textarea label="Message" name="pn4" placeholder="Message..." />
            <Button text="Send SMS" btnClass="btn-primary" />
        </div>
    </Card>
</template>
<script>
import Card from "@/components/Card";
import Button from "@/components/Button";
import Textarea from "@/components/Textarea";

export default {
    components: {
        Card,
        Button,
        Textarea,
    },
    data() {
        return {
            dateNtim: null,
        };
    },
};
</script>
<style lang=""></style>
