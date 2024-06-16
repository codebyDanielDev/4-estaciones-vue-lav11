<template>
  <div>
    <h2>Create User</h2>
    <form @submit.prevent="createUser">
      <input v-model="user.name" placeholder="Name" required />
      <input v-model="user.email" type="email" placeholder="Email" required />
      <button type="submit">Create</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user: {
        name: '',
        email: ''
      }
    };
  },
  methods: {
    createUser() {
      // Handle user creation
      console.log('User created:', this.user);
    }
  }
}
</script>
