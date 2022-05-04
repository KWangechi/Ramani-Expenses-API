<template>
  <q-layout view="lHh Lpr lFf">
    <div class="q-pa-lg" style="max-width: 600px; margin: auto;">
<q-form
      @submit="createExpense"
      class="q-gutter-md"
    >
 <q-input outlined v-model="newExpense.name" label="Field Agent Name"/>
 <q-input outlined v-model="newExpense.department" label="Department"/>
 <q-input outlined type="number" v-model="newExpense.amount" label="Amount"/>
 <q-select outlined v-model="newExpense.project_no" :options="project_numbers" label="Project Number"/>
 <q-select outlined v-model="newExpense.currency" :options="currency" label="Currency" />
 <q-select outlined v-model="newExpense.expense_type" :options="expense_types" label="Expense Type" />
 <q-select outlined v-model="newExpense.transaction_type" :options="transaction_types" label="Transaction Type" />
<q-file outlined color="primary" filled v-model="newExpense.photo" label="Photo Receipt">
        <template v-slot:prepend>
          <q-icon name="cloud_upload" />
        </template>
      </q-file>

 <q-input outlined type="date" v-model="newExpense.date_issued" label="Date Issued"/>
 <q-btn class="bg-primary text-center" type="submit" label="Create"></q-btn>

</q-form>
</div>
  </q-layout>

</template>

<script>
import { useExpenseStore } from "src/stores/example-store";
import { defineComponent } from "vue";

export default defineComponent({
name: 'CreateExpensePage',
data(){
  return{
    newExpense:{
      name:'',
      department:'',
      amount:'',
      project_no:'',
      currency:'',
      expense_type:'',
      transaction_type:'',
      photo:'',
      date_issued:'',
    },
    currency:[
      'KES', 'USD', 'UGX', 'TZS', 'GBP', 'EUR'
    ],
    expense_types:[
      'Per Diem', 'Accommodation', 'Materials', 'Casual Labour', 'Security', 'Military Costs', 'Fuel Logistics', 'Onsite Travel'
    ],
    transaction_types:[
      'Money In', 'Money Out'
    ],
    project_numbers:[
      39999, 32856
    ]
  }
},
computed:{

},

methods:{
  createExpense(){
    console.log(this.newExpense)
  }
},
mounted(){

}
})
</script>
