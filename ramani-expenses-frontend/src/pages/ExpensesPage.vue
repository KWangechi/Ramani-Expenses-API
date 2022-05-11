<template>
  <q-layout view="lHh Lpr lFf">
    <q-table title="My Expenses" :columns="columns" row-key="name" :rows="expenses" separator="cell"
      :pagination="pagination">

      <!-- search functionality -->
      <template v-slot:top-right>
        <q-input outlined dense debounce="300" v-model="search" placeholder="Search">
          <template v-slot:append>
            <q-icon name="search" />
          </template>
        </q-input>
      </template>

      <template v-slot:body-cell-actions="props">
        <q-td :props="props">
          <q-btn dense round flat color="grey" @click="viewExpense(props.row)" icon="eva-eye"></q-btn>
          <q-btn dense round flat color="grey" @click="editExpense(props, props.row)" icon="edit"></q-btn>
          <q-btn dense round flat color="red" @click="deleteExpense(props)" icon="delete"></q-btn>
        </q-td>
      </template>

      <!-- display one expense -->
      <template v-slot:top-left>
        <q-dialog v-model="medium">
          <q-card style="width: 700px; max-width: 80vw;">
            <q-card-section>
              <div class="text-h6">{{ expense.employee_name }}</div>
            </q-card-section>

            <q-card-section class="q-pt-none">
              Department: {{ expense.department }}
            </q-card-section>

            <q-card-section class="q-pt-none">
              Project Number: {{ expense.project_number }}
            </q-card-section>

            <q-card-section class="q-pt-none">
              Description: {{ expense.description }}
            </q-card-section>

            <q-card-section class="q-pt-none">
              Amount: {{ expense.amount }}
            </q-card-section>

            <q-card-section class="q-pt-none">
              Currency: {{ expense.currency }}
            </q-card-section>

            <q-card-section class="q-pt-none">
              Expense Type: {{ expense.expense_type }}
            </q-card-section>

            <q-card-section class="q-pt-none">
              Transaction Type: {{ expense.transaction_type }}
            </q-card-section>

            <q-card-section class="q-pt-none">
              Receipt Photo
              <div>
                <q-img :src="`http://127.0.0.1:8000/${expense.receipt_photo_path}`"
                  style="height: 240px; max-width: 350px" />
              </div>
            </q-card-section>

            <q-card-section class="q-pt-none">
              Date Issued: {{ expense.date_issued }}
            </q-card-section>
            <q-card-actions align="right" class="bg-white text-teal">
              <q-btn flat label="OK" v-close-popup />
            </q-card-actions>
          </q-card>
        </q-dialog>
      </template>


    </q-table>

      <!-- update existing expense -->

        <q-dialog v-model="prompt">
        <q-card style="width: 550px">
        <div class="q-pa-lg" style="max-width: 600px; margin: auto">

          <q-form  class="q-gutter-lg" >
        <q-input outlined v-model="expense.employee_name" label="Employee Name" id="employee_name"
          name="employee_name" />
        <q-input outlined v-model="expense.department" label="Department" id="department" name="department" />
        <q-input outlined v-model="expense.description" label="Description" id="description" name="description" />
        <q-input outlined type="number" v-model="expense.amount" label="Amount" id="amount" name="amount" />
        <q-select outlined v-model="expense.project_no" :options="project_numbers" label="Project Number"
          id="project_no" name="project_no" />
        <q-select outlined v-model="expense.currency" :options="currency" label="Currency" id="currency"
          name="currency" />
        <q-select outlined v-model="expense.expense_type" :options="expense_types" label="Expense Type"
          id="expense_type" name="expense_type" />
        <q-select outlined v-model="expense.transaction_type" :options="transaction_types" label="Transaction Type"
          id="transaction_type" name="transaction_type" />

          <q-card-section class="q-pt-none">
              Receipt Photo
              <div>
                <q-img :src="`http://127.0.0.1:8000/${expense.receipt_photo_path}`"
                  style="height: 240px; max-width: 350px" />
              </div>
            </q-card-section>

        <q-file outlined color="primary" v-model="expense.receipt_photo" filled @change="onFileChange()" label="Change Photo" accept=".jpg, .png, .jpeg">
          <template v-slot:prepend>
            <q-icon name="cloud_upload" />
          </template>
        </q-file>

        <!-- <input type="file" name="receipt_photo" id="receipt_photo" v-on:change="onFileChange"> -->
<!-- <div class="camera-frame q-ma-md">
        <img id="myImage" :src="myPhoto" class="full-width q-mb-lg" />
      </div> -->

        <q-input outlined type="date" v-model="expense.date_issued" id="date_issued" name="date_issued" />
        <q-card-actions align="right" class="text-primary">
          <q-btn flat label="Cancel" v-close-popup />
          <q-btn flat label="Update" v-close-popup />
        </q-card-actions>
      </q-form>
      </div>
        </q-card>
        </q-dialog>
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
        { name: 'employee_name', align: 'center', label: 'Employee Name', field: 'employee_name', sortable: true },
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
      search: '',
      expenses: [],
      medium: false,
      expense: {},
      prompt: false,
      myPhoto: null,
      fileImageURL:""
    };
  },

  watch: {
    search(val) {
      this.search = val;
      this.getAllExpenses();
    }
  },

  computed: {
    // ...mapState(useExpenseStore, {
    //   expenses: "expenses"
    // }),

  },
  mounted() {
    this.getAllExpenses();
  },
  methods: {
    async viewExpense(props) {
      await api.get(`/expenses/${props.id}`)
        .then((response) => {
          this.expense = response.data.data;

          // console.log(response)
        })
        .catch((errors) => {
          console.log(errors);
        });

          this.medium = true
    },

    getAllExpenses() {
      api
        .get("/expenses", {
          params: {
            search: this.search
          }
        })
        .then(({ data: { data } }) => {
          this.expenses = data;
        })
        .catch((errors) => {
          console.log(errors);
        });
    },

    editExpense(props, expense) {
      // this.viewExpense(props)

      this.prompt = true;

      // api
      //   .patch(`/expenses/${props.id}`, expense, {
        //   headers: {
        //     "Content-Type": "multipart/form-data",
        //   },
        // })
      //   .then((response) => {
      //     if (response.data.message) {
      //       this.$q.notify({
      //         message: response.data.message,
      //         type: positive
      //       });
      //       console.log(response);
      //     } else {
      //       this.$q.notify({
      //         message: response.data.message,
      //         color: red,
      //       });
      //     }
      //   })
      //   .catch((errors) => {
      //     console.log(errors);
      //   });
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
    onFileChange(){
      const reader = new FileReader();
      reader.addEventListener(
        "load",
        async function () {
          // convert image file to base64 string
          var newImage = document.querySelector("#myImage");
          newImage.src = reader.result;
          this.fileImageURL = newImage.src;
        },
        false
      );
      if (this.expense.receipt_photo) {
        reader.readAsDataURL(this.expense.receipt_photo);
        this.photo = URL.createObjectURL(new Blob([this.fileImageURL], { type: "image/jpg" }));
      }
    }
  },
});
</script>

<style lang="scss">
.q-tabs-style {
  border-radius: 100px;
}

// .my-card{
//   z-index: -1;
// }
</style>
