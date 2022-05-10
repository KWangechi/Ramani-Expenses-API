<template>
  <q-layout>
    <div class="q-pa-md q-mt-xl q-gutter-md">
      <div v-if="expense">
        <q-card flat bordered class="my-card">
          <q-card-section>
            <div class="text-h6">Expense {{ expense }}</div>
          </q-card-section>

          <q-card-section class="q-pt-none">
            {{expense.employee_name}}
          </q-card-section>

          <q-separator inset />

          <q-card-section>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua.
          </q-card-section>
        </q-card>
      </div>

      <div v-else>
        No data available for that expense
      </div>
    </div>
  </q-layout>

</template>

<script>
import { mapActions, mapWritableState } from "pinia"
import { useExpenseStore } from "src/stores/example-store"
import { api } from "src/boot/axios"
export default {
  data() {
    return {
      expense: {}
    }
  },
  computed: {
    // ...mapWritableState(useExpenseStore, {
    //   expenses: "expenses"
    // }),

    ...mapActions(useExpenseStore, {
      getAllExpenses: "getAllExpenses",
    })
  },
  methods: {
    getOneExpense(id) {
      api
  .get(`/expenses/${id}`)
  .then((response) => {
    // this.expense = response.data.data;
    console.log(response);
  })
  .catch((errors) => {
    console.log(errors);
  });
    }
  },
  mounted() {
    this.getOneExpense();
    this.getAllExpenses;

  },
}
</script>
<style lang="scss">
.my-card {

  width: 100%;
  max-width: 500px;
  margin: auto
}
</style>
