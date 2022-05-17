import { defineStore } from "pinia";
import axios, { api } from "src/boot/axios";
import { Notify, useQuasar } from "quasar";
// import { ElMessage } from 'element-plus'

export const useAuthStore = defineStore("main", {
  state: () => ({
    authToken: "",
    user: {},
    errorMessage: "",
  }),

  mutations: {},

  actions: {
    register(user) {
      api
        .post("/register", user)
        .then((response) => {
          if (response.data.success) {
            localStorage.setItem("authToken", response.data.access_token);

            Notify.create({
              message: "Registration successful!!",
              textColor: "white-5",
              type: "positive",
              actions: [
                {
                  label: "Dismiss",
                  color: "white",
                  handler: () => {
                    /* ... */
                  },
                },
              ],
            });

            window.location.href = "/login";

            this.user = response.data.data;

            // axios.defaults.headers.common["Authorization"] =
            //   "Bearer " + response.data.access_token;
          } else {
            this.errorMessage = response.data.message;
            localStorage.clear();
          }
          console.log(response);
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

          if (response.data.success) {
            localStorage.setItem("authToken", response.data.access_token);

            Notify.create({
              message: response.data.message,
              textColor: "white-5",
              type: "positive",
              actions: [
                {
                  label: "Dismiss",
                  color: "white",
                  handler: () => {
                    /* ... */
                  },
                },
              ],
            });

            window.location.href = "/expenses";
          } else {
            Notify.create({
              message: response.data.message,
              textColor: "white-5",
              type: "negative",
              actions: [
                {
                  label: "Dismiss",
                  color: "white",
                  handler: () => {
                    /* ... */
                  },
                },
              ],
            });
          }
        })
        .catch((errors) => {
          console.log(errors);
        });
    },
    logout() {
      api
        .post("/logout")
        .then((response) => {
          localStorage.removeItem("authoken");
          if (response.data.success) {

            Notify.create({
              message: response.data.message,
              textColor: "white-5",
              type: "positive",
              actions: [
                {
                  label: "Dismiss",
                  color: "white",
                  handler: () => {
                    /* ... */
                  },
                },
              ],
            });

            window.location.href = "/login";
          } else {
            console.log(response);
          }
        })
        .catch((errors) => {
          console.log(errors);
        });
    },

    getUser() {
      api
        .get("/user", {
          headers: {
            "Authorization": "Bearer " + localStorage.getItem("authToken"),
          },
        })
        .then((response) => {
          // console.log(response.data)

          this.user = response.data;
          // console.log(this.user);
        })
        .catch((errors) => {
          console.log(errors);
        });
    },
  },
});
