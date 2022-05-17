<template>
  <div class="q-pa-lg" style="max-width: 600px; margin: auto">
    <q-form @submit="loginUser" class="q-gutter-md" id="register-form">
      <q-input
        outlined
        v-model="user.email"
        label="Email Address"
        id="email"
        name="email"
      />
      <q-input
        outlined
        v-model="user.password"
        label="Password"
        id="password"
        name="password"
        type="password"
      />
      <q-btn
        class="bg-primary text-center"
        type="submit"
        label="Login"
      ></q-btn>
      <a href="/register" align="right" class="text-center" style="cursor: pointer; float: right;"
        >Register an account</a>
      <p style="float: right">Don't have an account</p>
    </q-form>
  </div>
</template>

<script>
import { useAuthStore } from "src/stores/auth.js";

export default {
  data() {
    return {
      user: {
        email: "",
        password: "",
      },
    };
  },
  methods: {
    loginUser() {
      const authStore = useAuthStore();
      authStore.login(this.user);

    },
  },
  computed: {},
};
</script>
