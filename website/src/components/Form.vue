<template>
  <div class="greetings">
    <h1>{{ "Welcome To User Register" }}</h1>
    <form @submit.prevent="submit">
        <small class="text-danger">{{ error }}</small>
        <div class="mb-2">
            <label class="label">First Name</label>
            <input type="text" class="form-control"  v-model="firstName"/>
        </div>
        <div>
            <label class="label">Last Name</label>
            <input type="text" class="form-control"  v-model="lastName"/>
        </div>
        <div>
            <button type="submit"  class="btn btn-primary float-end mt-3">Add User</button>
        </div>
    </form>

  </div>
</template>

<style scoped>
h1 {
  font-weight: 500;
  font-size: 2.6rem;
  position: relative;
  top: -10px;
}

h3 {
  font-size: 1.2rem;
}
.greetings{
   width: 500px;
}
.greetings h1,
.greetings h3 {
  text-align: center;
}

.label{
  color: #fff;
  margin-top: 5px;
}

@media (min-width: 1024px) {
  .greetings h1,
  .greetings h3 {
    text-align: left;
  }
}
</style>

<script>

import axios from 'axios';

export default {
  
  components: {
    
  },
  data() {
    return {
        firstName: "",
        lastName: "",
        users: JSON.parse(localStorage.getItem('testUsers')),
        error : "",
    }
  },
  mounted() {
    
  },
  methods: {
    submit() {

      if (!this.firstName || !this.lastName) {
        this.error = "Please provide all fields"
        return
      }

      const user = {};
      user.id = this.users.length - 1;
      user.firstName = this.firstName;
      user.lastName = this.lastName;
      this.users.push(user);
      localStorage.setItem("testUsers", JSON.stringify(this.users));
      window.location.reload()
    }
  }
}
</script>
<style lang=""></style>
