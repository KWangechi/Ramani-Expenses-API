import { defineStore } from "pinia";
import { api } from "src/boot/axios";
import { Notify } from "quasar";

export const useAuthStore = defineStore("main", {
  state: () => ({
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
            this.errorMessage = response.data.message

            // Notify.create({
            //   message: response.data.message,
            //   textColor: "white-5",
            //   type: "negative",
            //   actions: [
            //     {
            //       label: "Dismiss",
            //       color: "white",
            //       handler: () => {
            //         /* ... */
            //       },
            //     },
            //   ],
            // });

            // console.log(this.errorMessage)
          }
        })
        .catch((errors) => {
          console.log(errors);
        });
    },
    async logout() { 
      await api
        .post("/logout", 
        null,
        {
          headers: {
            "Access-Control-Allow-Origin": "*",
            Authorization: "Bearer " + localStorage.getItem("authToken"),
          },
        }
        )
        .then((response) => {
          localStorage.removeItem("authToken");
          console.log(localStorage.getItem("authToken"))

          console.log(response);

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
            // this.$router.push('/login');

          } else {
            console.log(response);
          }
          window.location.href = "/login";
        })
        .catch((errors) => {
          console.log(errors);
        });
      localStorage.removeItem("authToken");

      console.log(localStorage.getItem("authToken"))
    },

    async getUser() {
      await api
        .get("/user", {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("authToken"),
          },
        })
        .then((response) => {
          localStorage.getItem("authToken");
          console.log(localStorage.getItem("authToken"));

          this.user = response.data;
          console.log(this.user);
        })
        .catch((errors) => {
          console.log(errors);
        });
    },

    setUser() {
      let token = localStorage.getItem("authToken");
      return token ? true : false;
    },
  },
});
