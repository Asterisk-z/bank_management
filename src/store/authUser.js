import {defineStore} from "pinia";
import { useToast } from "vue-toastification";
const toast = useToast();


export const useAuthStore = defineStore('auth',{
    state: () => ({
        user: JSON.parse(localStorage.getItem('activeUser')),
        returnUrl: null
    }),
    actions: {
        async login(username, password) {
            // localStorage.getItem('activeUser')
            // const user = await fetchWrapper.post(`${baseUrl}/authenticate`, { username, password });

            // update pinia state
            // this.user = user;

            // store user details and jwt in local storage to keep user logged in between page refreshes
            // localStorage.setItem('user', JSON.stringify(user));

            // redirect to previous url or default to home page
            // router.push(this.returnUrl || '/');
        },
        logout() {
            this.user = null;
            localStorage.removeItem('activeUser');
            router.push('/login');
        }
    }
});
