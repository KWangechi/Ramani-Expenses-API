import { defineStore } from "pinia";
import { api } from "src/boot/axios";
import { store } from "quasar/wrappers";

export const useExpenseStore = defineStore("expense", {
  state: () => ({
    expense: {},
    expenses: [],
  }),

  getters: {
    newExpense: (state) => state.expense,
    allExpenses: (state) => state.expenses,
  },

  actions: {
    async createExpense(newExpense) {
      api
        .post("/expenses/create", newExpense)
        .then((response) => {
          console.log(response);
        })
        .catch((errors) => {
          console.log(errors);
        });
    },

    getAllExpenses() {
      api
        .get("/expenses")
        .then(({ data: { data } }) => {
          this.expenses = data;

          console.log("Get all expenses");
          console.log(this.expenses);
        })
        .catch((errors) => {
          console.log(errors);
        });
    },
  },
});
