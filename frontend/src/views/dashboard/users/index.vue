<template>
    <div>
        <Breadcrumb />

        <div class="grid grid-cols-12 gap-5">
            <div class="xl:col-span-12 col-span-12 m-5">
                <UsersTable class="-mx-6 -mb-6" />
            </div>
        </div>


    </div>
</template>
<script>
import Breadcrumb from "@/views/components/Breadcrumbs";
import Card from "@/components/Card";
import Icon from "@/components/Icon";
import UsersTable from "@/components/TableUsers";
import Button from "@/components/Button";

export default {
    components: {
        Breadcrumb,
        Card,
        Icon,
        Button,
        UsersTable
    },
    data() {
        return {
        }
    }
}
</script>
<style lang=""></style>
