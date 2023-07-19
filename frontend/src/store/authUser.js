import {defineStore} from "pinia";
import { useToast } from "vue-toastification";
import { useRouter } from "vue-router";
import axios from 'axios';
const toast = useToast();
const router = useRouter();


export const useAuthStore = defineStore('auth',{
    state: () => ({
        user: JSON.parse(sessionStorage.getItem('RoyalBankUserr')),
        returnUrl: null
    }),
    actions: {
        async login(username, password) {
            this.user = null;
            sessionStorage.removeItem('RoyalBankUserr');
             toast.info("Logging in", {
                timeout: 2000,
             });
            
            await axios.post(`${import.meta.env.VITE_APP_API_URL}/auth/login`,  {
                                        email: username,
                                        password: password
            }).then(function (response) {
                sessionStorage.setItem('RoyalBankUserr', JSON.stringify(response.data));
                
                if (response.data.user.status == 'active') {
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
            }).catch(function (error) {
                toast.error("User not found", {
                    timeout: 2000,
                });
            });

        },
        async register(firstName, lastName, countryCode, phone, email, password, confirmPassword) {

            sessionStorage.removeItem('RoyalBankUserr');

             toast.info("Registering User", {
                timeout: 2000,
             });
            
            await axios.post(`${import.meta.env.VITE_APP_API_URL}/auth/register`,  {
                                        lname : lastName,
                                        fname : firstName,
                                        email : email,
                                        country_code : countryCode,
                                        phone : phone,
                                        password : password,
                                        password_confirmation : confirmPassword
            }).then(function (response) {
                sessionStorage.setItem('RoyalBankUserr', JSON.stringify(response.data));
                console.log(response);
                if (response.data.user.status == 'active') {
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
            // this.user = null;
            // axios.post(`${import.meta.env.VITE_APP_API_URL}/logout`);
            sessionStorage.removeItem('RoyalBankUserr');
            // router.push('/login');
        }
    }
});
