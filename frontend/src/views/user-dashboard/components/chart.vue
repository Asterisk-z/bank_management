<template>
    <div>
         <apexchart
            :type="type"
            :height="height"
            :width="width"
            :class="xClass"
            :options="option"
            :series="series"
            />
    </div>
</template>
<script>
export default {
    props: {
        type: {
            type: String,
            default: 'bar',
        },
        height: {
            type: String,
            default: '120',
        },
        width: {
            type: String,
            default: '124',
        },
        xClass: {
            type: String,
            default: 'mr-8',
        },
        option: {
            type: Object,
            // default: '',
        },
        series: {
            type: Object,
            // default: '',
        },
    },
    data() {
        return {
            
        };
    },
};
</script>
<style lang=""></style>
