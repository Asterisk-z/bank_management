<template>
  <table class="table table-responsive">
      <thead>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
        </tr>
      </thead>
      <tbody>
          <tr v-for="(user, index) in users">
              <td>{{ ++index }}</td>
              <td>{{ user.firstName }}</td>
              <td>{{ user.lastName }}</td>
          </tr>
      </tbody>
  </table>
</template>

<script>
import axios from 'axios';

export default {
  components: {

  },
  data() {
    return {
      users: "",
    }
  },
  mounted() {
    this.users = JSON.parse(localStorage.getItem('testUsers'));
  },
  methods: {
  }
}
</script>
