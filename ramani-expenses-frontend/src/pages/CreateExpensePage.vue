<template>
  <q-layout view="lHh Lpr lFf">
    <div class="q-pa-lg" style="max-width: 600px; margin: auto">
      <q-form @submit="createNewExpense" class="q-gutter-md">
        <q-input
          outlined
          v-model="store.user.name"
          label="Employee Name"
          id="employee_name"
          name="employee_name"
          :rules="[val => !!val || 'Field is required']"
          lazy-rules
          disable
        />
        <q-input
          outlined
          v-model="newExpense.department"
          label="Department"
          id="department"
          name="department"
          lazy-rules
          :rules="[val => !!val || 'Field is required']"
        />
        <q-input
          outlined
          v-model="newExpense.description"
          label="Description"
          id="description"
          name="description"
          :rules="[val => !!val || 'Field is required']"

        />
        <q-input
          outlined
          type="number"
          v-model="newExpense.amount"
          label="Amount"
          id="amount"
          name="amount"
          :rules="[val => !!val || 'Field is required']"

        />
        <q-select
          outlined
          v-model="newExpense.project_no"
          :options="project_numbers"
          label="Project Number"
          id="project_no"
          name="project_no"
          :rules="[val => !!val || 'Field is required']"

        />
        <q-select
          outlined
          v-model="newExpense.currency"
          :options="currency"
          label="Currency"
          id="currency"
          name="currency"
        />
        <q-select
          outlined
          v-model="newExpense.expense_type"
          :options="expense_types"
          label="Expense Type"
          id="expense_type"
          name="expense_type"

        />
        <q-select
          outlined
          v-model="newExpense.transaction_type"
          :options="transaction_types"
          label="Transaction Type"
          id="transaction_type"
          name="transaction_type"
        />

        <q-file
          outlined
          color="primary"
          v-model="newExpense.receipt_photo"
          filled
          @change="onFileChange()"
          label="Photo Receipt"
          accept=".jpg, .png, .jpeg"

        >
          <template v-slot:prepend>
            <q-icon name="cloud_upload" />
          </template>
        </q-file>

        <!-- <input type="file" name="receipt_photo" id="receipt_photo" v-on:change="onFileChange"> -->

        <q-input
          outlined
          type="date"
          v-model="newExpense.date_issued"
          id="date_issued"
          name="date_issued"
          :rules="[val => !!val || 'Field is required']"

        />
        <q-btn
          class="bg-primary text-center"
          type="submit"
          label="Create"
        ></q-btn>
        <q-btn
          class="bg-grey text-align-right"
          type="button"
          label="Cancel"
          to="/expenses"
        ></q-btn>
      </q-form>
    </div>
  </q-layout>
</template>

<script>
import { defineComponent } from "vue";
import { api } from "src/boot/axios";
import { mapState } from "pinia";
import { useExpenseStore } from "src/stores/example-store";
import { useQuasar } from "quasar";
import { useAuthStore } from "src/stores/auth";

export default defineComponent({
  name: "CreateExpensePage",
  data() {
    return {
      newExpense: {
        department: "",
        description: "",
        amount: "",
        project_no: "",
        currency: "",
        expense_type: "",
        transaction_type: "",
        receipt_photo: "",
        date_issued: "",
      },
      store: useAuthStore()
    };
  },
  computed: {
    ...mapState(useExpenseStore, {
      currency: "currency",
      expense_types: "expense_types",
      transaction_types: "transaction_types",
      project_numbers: "project_numbers",
    }),
  },

  methods: {
    async createNewExpense() {
      let formData = new FormData();
      const $q = useQuasar();

      formData.append("employee_name", this.newExpense.employee_name);
      formData.append("department", this.newExpense.department);
      formData.append("description", this.newExpense.description);
      formData.append("amount", this.newExpense.amount);
      formData.append("currency", this.newExpense.currency);
      formData.append("project_no", this.newExpense.project_no);
      formData.append("expense_type", this.newExpense.expense_type);
      formData.append("transaction_type", this.newExpense.transaction_type);
      formData.append("receipt_photo", this.newExpense.receipt_photo);
      formData.append("date_issued", this.newExpense.date_issued);

      api
        .post("/expenses/create", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
            Authorization: "Bearer " + localStorage.getItem("authToken"),
          },
        })
        .then((response) => {
          if (response.data.success) {
            this.$q.notify({
              message: response.data.message,
              textColor: "white-10",
              type: "positive",
            });
            console.log(response);
            window.location = "/expenses";
          } else {
            this.$q.notify({
              message: "Something went wrong",
              textColor: "white-10",
              type: "negative",
            });
          }
        })
        .catch((errors) => {
          console.log(errors);
        });
    },
    onFileChange(e) {
      this.newExpense.receipt_photo = e.target.files[0];
    },
  },
  mounted() {},
});
</script>
