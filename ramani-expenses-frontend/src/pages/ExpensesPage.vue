<template>
  <q-layout view="lHh Lpr lFf">
    <q-table title="My Expenses" :columns="columns" row-key="name" :rows="expenses" separator="cell">
    </q-table>
    <div class="q-pa-lg">
      <q-tabs align="right">
      <q-route-tab class="bg-primary text-white" exact icon="add" to="/create-expense" />
      </q-tabs>
    </div>
  </q-layout>
</template>

<script>
import { defineComponent } from "vue";
import { useExpenseStore } from "src/stores/example-store";
import { mapActions, mapState } from "pinia";


export default defineComponent({
  name: "ExpensesPage",

  data() {
    return {
      columns: [
        {
          name: 'ID',
          required: true,
          label: 'ID',
          field:'id',
          align: 'left',
          sortable: true
        },
        { name: 'field_member_name', align: 'center', label: 'Field Agent Name', field: 'name', sortable: true },
        { name: 'department', align: 'center', label: 'Department', field: 'department', sortable: true },
        { name: 'project_no', align: 'center', label: 'Project number', field: 'project_no' },
        { name: 'description', align: 'center', label: 'Description', field: 'description' },
        { name: 'amount', align: 'center', label: 'Amount', field: 'amount' },
        { name: 'currency', align: 'center', label: 'Currency', field: 'currency', sortable: true, sort: (a, b) => parseInt(a, 10) - parseInt(b, 10) },
        { name: 'expense_type', align: 'center', label: 'Expense Type', field: 'expense_type', sortable: true, sort: (a, b) => parseInt(a, 10) - parseInt(b, 10) },
        { name: 'transaction_type', align: 'center', label: 'Transaction Type', field: 'transaction_type', sortable: true, sort: (a, b) => parseInt(a, 10) - parseInt(b, 10) }

      ],
    };
  },
  computed: {
    ...mapState(useExpenseStore, {
      expenses: "expenses"
    }),

    ...mapActions(useExpenseStore, {
      getAllExpenses: "getAllExpenses"
    }),

  },
  mounted() {
    this.getAllExpenses;

  },
  methods: {
  
  },
});
</script>

<style lang="scss">
.q-tabs-style{
border-radius: 100px;
}
</style>
