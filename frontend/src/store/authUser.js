import {defineStore} from "pinia";
import { useToast } from "vue-toastification";
import { useRouter } from "vue-router";
import axios from 'axios';
const toast = useToast();
const router = useRouter();
import defaultImage from "@/assets/images/users/default.jpg";


export const useAuthStore = defineStore('auth',{
    state: () => ({
        user: JSON.parse(sessionStorage.getItem('RoyalBankUserr')),
        returnUrl: null,
        defaultImage: defaultImage,
        email: JSON.parse(sessionStorage.getItem('login_email')),
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
                if (response.data.status) {
                    
                    if (response.data?.goto_otp) { 
                        sessionStorage.setItem('login_email', JSON.stringify(response.data.email));
                        window.location.replace(import.meta.env.VITE_APP_URL + "login-otp")
                        return;
                    }

                    if (response.data.user.status == 'active') {
                        
                        sessionStorage.setItem('RoyalBankUserr', JSON.stringify(response.data));
                        toast.success(" Login successfully", {
                            timeout: 2000,
                        });
                        if (response.data.user.user_type == 'admin') {
                            window.location.replace(import.meta.env.VITE_APP_URL+"app/dashboard")
                        }
                        if (response.data.user.user_type == 'customer') {
                            window.location.replace(import.meta.env.VITE_APP_URL+"app/user-dashboard")
                        }
                            
                    }
                    
                    
                }else {
                    toast.error("Login Failed", {
                        timeout: 2000,
                    });
                }
            }).catch(function (error) {
                toast.error("User not found", {
                    timeout: 2000,
                });
                if (error.response?.data?.error == 'Unauthorized') {
                    toast.error("Session Expired", {
                    timeout: 3000,
                    });
                    $this.$router.push({ name: 'Login' })
                }
            });

        },
        async login_otp(code) {
            this.user = null;
            let $this = this
            sessionStorage.removeItem('RoyalBankUserr');
             toast.info("Logging in", {
                timeout: 2000,
             });
            
            await axios.post(`${import.meta.env.VITE_APP_API_URL}/auth/login_otp`,  {
                                        email: $this.email,
                                        code: code
            }).then(function (response) {
                
                if (response.data.user.status == 'active') {
                    sessionStorage.removeItem('login_email');
                    sessionStorage.setItem('RoyalBankUserr', JSON.stringify(response.data));
                    toast.success(" Login successfully", {
                        timeout: 2000,
                    });
                    if (response.data.user.user_type == 'admin') {
                         window.location.replace(import.meta.env.VITE_APP_URL+"app/dashboard")
                    }
                    if (response.data.user.user_type == 'customer') {
                         window.location.replace(import.meta.env.VITE_APP_URL+"app/user-dashboard")
                    }
                   
                } else {
                    toast.error("User not found", {
                        timeout: 2000,
                    });
                }
            }).catch(function (error) {
                
                toast.error(error.response?.data?.error, {
                    timeout: 2000,
                });
                if (error.response?.data?.error == 'Unauthorized') {
                    toast.error("Session Expired", {
                    timeout: 3000,
                    });
                    $this.$router.push({ name: 'Login' })
                }
            });

        },
        async refresh() {
            await axios.post(`${import.meta.env.VITE_APP_API_URL}/auth/refresh`,{}, {
          headers: {
          "Authorization": "Bearer " + this.user.token
          },
        }).then(function (response) {
                
                
                if (response.data.user.status == 'active') {
                         sessionStorage.setItem('RoyalBankUserr', JSON.stringify(response.data));
                    
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
