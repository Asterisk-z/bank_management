
import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.min.css'
// import './assets/main.css'

import { createApp } from 'vue'
import App from './App.vue'

createApp(App).mount('#app')

if (localStorage.testUsers === undefined) {
    let users = [
        {
            id: 1,
            firstName: "Daniel",
            lastName: "Olang",
        },
    ];
    localStorage.setItem("testUsers", JSON.stringify(users));
}