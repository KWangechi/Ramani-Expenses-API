import { defineStore } from "pinia";
import axios, { api } from "src/boot/axios";
import { Notify, useQuasar } from 'quasar'
import {ElMessage} from 'element-plus'


export const useAuthStore = defineStore("main", {
  state: () => ({
    authToken: "",
    user: {},
    errorMessage: ''
  }),

  mutations: {},

  actions: {
    register(user) {
      api
        .post("/register", user)
        .then((response) => {
          // console.log(response)

          if (response.data.success) {
            localStorage.setItem("authToken", response.data.access_token);

          //   ElMessage({
          //     type: 'success',
          //     message: 'Registration successful'
          // })

          // window.location.href = "/login"

            this.user = response.data.data;

            axios.defaults.headers.common["Authorization"] =
              "Bearer " + response.data.access_token;

          } else {
            this.errorMessage = response.data.message;
            localStorage.clear();
          }

          console.log(response)
        })
        .catch((errors) => {
          console.log(errors);
        });
    },
    login(user) {
      api
        .post("/login", user)
        .then((response) => {
          console.log(response);

          ElMessage({
            type: 'success',
            message: 'Successfully logged in!'
        })

        })
        .catch((errors) => {
          console.log(errors);
        });
    },
    logout() {
      axios.defaults.headers.common["Authorization"] =
              "Bearer " + localStorage.getItem('authToken');

      api
        .post("/logout", user)
        .then((response) => {
          localStorage.removeItem("authoken");

          if (response.data.success) {
            window.location.href = "/login";
            ElMessage({
                message: "Successfully logged out",
                type: "success",
            });
        } else {
            console.log(response);
        }

        })
        .catch((errors) => {
          console.log(errors);
        });
    },
  },
});
