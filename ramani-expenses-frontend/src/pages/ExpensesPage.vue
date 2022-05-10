<template>
  <q-layout view="lHh Lpr lFf">
    <q-table title="My Expenses" :columns="columns" row-key="name" :rows="expenses" separator="cell"
      :pagination="pagination">


      <template v-slot:body-cell-actions="props">
        <q-td :props="props">
          <q-btn dense round flat color="grey" @click="viewExpense(props)" icon="eva-eye"></q-btn>
          <q-btn dense round flat color="grey" @click="editExpense(props)" icon="edit"></q-btn>
          <q-btn dense round flat color="red" @click="deleteExpense(props)" icon="delete"></q-btn>
        </q-td>
      </template>
    </q-table>

<!-- <q-input outlined dense debounce="300" v-model="filter" placeholder="Search"/> -->

    <div class="q-pa-lg">
      <q-tabs align="right">
        <q-route-tab class="bg-primary text-white border-round" exact icon="add" to="/create-expense" />
      </q-tabs>
    </div>
  </q-layout>
</template>

<script>
import { defineComponent } from "vue";
import { useExpenseStore } from "src/stores/example-store";
import { mapActions, mapState } from "pinia";
import Swal from 'sweetalert2'
import { api } from "src/boot/axios";

export default defineComponent({
  name: "ExpensesPage",

  data() {
    return {
      columns: [
        {
          name: 'ID',
          required: true,
          label: 'ID',
          field: 'id',
          align: 'center',
          sortable: true
        },
        { name: 'employee_name', align: 'center', label: 'Field Agent Name', field: 'employee_name', sortable: true },
        { name: 'department', align: 'center', label: 'Department', field: 'department', sortable: true },
        { name: 'project_no', align: 'center', label: 'Project number', field: 'project_no' },
        { name: 'description', align: 'center', label: 'Description', field: 'description' },
        { name: 'amount', align: 'center', label: 'Amount', field: 'amount' },
        { name: 'currency', align: 'center', label: 'Currency', field: 'currency', sortable: true, sort: (a, b) => parseInt(a, 10) - parseInt(b, 10) },
        { name: 'expense_type', align: 'center', label: 'Expense Type', field: 'expense_type', sortable: true, sort: (a, b) => parseInt(a, 10) - parseInt(b, 10) },
        { name: 'transaction_type', align: 'center', label: 'Transaction Type', field: 'transaction_type', sortable: true, sort: (a, b) => parseInt(a, 10) - parseInt(b, 10) },
        { name: 'actions', align: 'center', label: 'Actions', field: 'actions' },

      ],

      pagination: {
        rowsPerPage: 7,
      },
      confirm: false,
      search: ''
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
    viewExpense(props) {
      window.location = `/expenses/${props.row.id}`

    },

    editExpense(props, expense) {
      api
        .patch(`/expenses/${props.row.id}`, expense)
        .then((response) => {
          if (response.data.message) {
            this.$q.notify({
              message: response.data.message,
              type: positive
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
    deleteExpense(props) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          api.delete("/expenses/" + props.row.id).then((response) => {
            console.log(response);

            window.location = "/expenses"
            // this.getAllExpenses
            if (response.data.message) {
              this.$q.notify({
                message: response.data.message,
                type: 'positive'
              });

              this.getAllExpenses
              console.log(response);
            } else {
              this.$q.notify({
                message: response.data.message,
                type: 'negative'
              });
            }
          });


        }
      })

    },

    displayExpenses(){

    }
  },
});
</script>

<style lang="scss">
.q-tabs-style {
  border-radius: 100px;
}
</style>
