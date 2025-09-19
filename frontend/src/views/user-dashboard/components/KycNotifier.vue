<template>
    <div>


        <div class="space-y-5" v-if="kyc_status">
            <Alert
                className="bg-danger-800 bg-opacity-[14%] text-danger-800 dark:bg-danger-500 dark:bg-opacity-[14%]  dark:text-slate-300"
                type="t-info" icon="heroicons-outline:exclamation" dismissible>
                KYC Incomplete...
                <router-link to="user-profile?to=kyc"
                    class="underline text-slate-900 dark:text-slate-300 text-sm font-medium">
                    Click here to complete KYC</router-link>.
            </Alert>
        </div>

    </div>
</template>
<script>

import Alert from '@/components/Alert';
import { useToast } from "vue-toastification";
import axios from 'axios';

export default {
    mixins: [window],
    components: {
        Alert,
    },
    data() {
        return {
            kyc_status: false,
        }
    },
    mounted() {
        this.dashboard();
    },
    methods: {
        dashboard() {

            let $this = this
            const toast = useToast();

            axios.get(`${import.meta.env.VITE_APP_API_URL}/auth/user`, {
                headers: {
                    "Authorization": "Bearer " + this.$store.authStore.user.token
                }
            }).then(function (response) {



                if (response.data?.status == 'success') {
                    let userData = response.data.data
                    $this.kyc_status = userData?.kyc_status == 'yes' ? false : true
                } else {
                    let message = response.data?.message[0];
                    toast.error(message, {
                        timeout: 4000,
                    });
                }
            }).catch(function (error) {
                toast.error("Error", {
                    timeout: 5000,
                });

                if (error.response?.data?.error == 'Unauthorized') {
                    toast.error("Session Expired", {
                        timeout: 3000,
                    });
                    $this.$router.push({ name: 'Login' })
                }
            });
        }
    }
}
</script>
<style lang=""></style>
