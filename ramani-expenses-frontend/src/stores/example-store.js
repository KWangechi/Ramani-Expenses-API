import { defineStore } from "pinia";
import { api } from "src/boot/axios";

export const useExpenseStore = defineStore("expense", {
  state: () => ({
    expense: {},
    expenses: [],
    filters:[],
    currency: ["KES", "USD", "UGX", "TZS", "GBP", "EUR"],
      expense_types: [
        "Per Diem",
        "Accommodation",
        "Materials",
        "Casual Labour",
        "Security",
        "Military Costs",
        "Fuel Logistics",
        "Onsite Travel",
      ],
      transaction_types: ["Money In", "Money Out"],
      project_numbers: [39999, 32856],
  }),

  getters: {
    newExpense: (state) => state.expense,
    allExpenses: (state) => state.expenses,
  },

  mutations:{
GET_ONE_EXPENSE(state, id){
  api
  .get(`/expenses/${id}`)
  .then((response) => {
    this.expense = response.data.data;

  })
  .catch((errors) => {
    console.log(errors);
  });
},
},

  actions: {
    getAllExpenses() {
      api
        .get("/expenses", {params: {
          search: this.filters
        }})
        .then(({ data: { data } }) => {
          this.expenses = data;

          console.log("Get all expenses");
          console.log(this.expenses);
        })
        .catch((errors) => {
          console.log(errors);
        });
    },

    editExpense(id) {
      api
        .patch("/expenses")
        .then((response) => {
          if (response.data.message) {
            this.$q.notify({
              message: response.data.message,
              color: light - green,
            });
            console.log(response);
          } else {
            this.$q.notify({
              message: response.data.message,
              color: red,
            });
          }
        })
        .catch((errors) => {
          console.log(errors);
        });
    },
    deleteExpense(id) {
      api.delete("/expenses/" + id).then((response) => {
        console.log(response);

        if (response.data.message) {
          this.$q.notify({
            message: response.data.message,
            color: light - green,
          });
          console.log(response);
        } else {
          this.$q.notify({
            message: response.data.message,
            color: red,
          });
        }
      });
    },
  },
});
