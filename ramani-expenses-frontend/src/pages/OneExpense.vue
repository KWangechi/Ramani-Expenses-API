<template>
  <q-layout>
{{expense}}
  </q-layout>
</template>

<script>
import { mapActions, mapState } from "pinia"
import { useExpenseStore } from "src/stores/example-store"
export default {
  data() {
    return {
    }
  },
computed:{
  ...mapState(useExpenseStore, {
    expense: "expense"
  }),

...mapActions(useExpenseStore, {
  getOneExpense: "getOneExpense"
})
},
  methods: {

  },
  mounted() {
    this.getOneExpense;
  },
}
</script>
