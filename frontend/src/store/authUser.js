import {defineStore} from "pinia";
import { useToast } from "vue-toastification";
import { useRouter } from "vue-router";
import axios from 'axios';
const toast = useToast();
const router = useRouter();


export const useAuthStore = defineStore('auth',{
    state: () => ({
        user: JSON.parse(localStorage.getItem('activeUser')),
        returnUrl: null
    }),
    actions: {
        async login(username, password) {
            this.user = null;
            localStorage.removeItem('activeUser');
             toast.info("Logging in", {
                timeout: 2000,
             });
            
            await axios.post(`${import.meta.env.VITE_APP_API_URL}/login`,  {
                                        email: username,
                                        password: password
            }).then(function (response) {
                localStorage.setItem('activeUser', JSON.stringify(response.data));
                console.log("response");
                if (response.data.user.status == 1) {
                    // router.push("/app/dashboard");
                    toast.success(" Login successfully", {
                        timeout: 2000,
                    });
                    if (response.data.user.user_type == 'admin') {
                         window.location.replace(import.meta.env.VITE_APP_URL+"app/dashboard")
                    }
                    if (response.data.user.user_type == 'customer') {
                         window.location.replace(import.meta.env.VITE_APP_URL+"app/user-dashboard")
                    }
                   
                    // window.history.replaceState({}, "", "/app/dashboard")
                    
                } else {
                    toast.error("User not found", {
                        timeout: 2000,
                    });
                }
            });

        },
        logout() {
            this.user = null;
            // axios.post(`${import.meta.env.VITE_APP_API_URL}/logout`);
            localStorage.removeItem('activeUser');
            // router.push('/login');
        }
    }
});
