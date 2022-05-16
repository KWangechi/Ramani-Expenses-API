<template>
  <div class="q-pa-lg" style="max-width: 600px; margin: auto">
    <q-form @submit="registerUser" class="q-gutter-md" id="register-form">
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
      <p>Don't have an account?</p>
      <a href="/register" class="bg-secondary text-center" style="cursor: pointer"
        >Login Here</a
      >
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

      this.$q.notify({
        message: 'Registration Successful',
        textColor: "white-10",
        type: "positive",
      });

      window.location = "/login"
    },
  },
  computed: {},
};
</script>
