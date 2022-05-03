<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="toggleLeftDrawer"

        />

        <q-toolbar-title>
          Ramani Application
        </q-toolbar-title>

        {{dateToday}}
      </q-toolbar>
    </q-header>

<q-footer class="bg-white small-screen-only" bordered>
        <q-tabs
        class="text-grey-10"
        active-color="primary"
        indicator-color="transparent"
      >
        <q-route-tab name="expenses" icon="money" label="Expenses" to="/expenses" />
        <q-route-tab
          name="calendar"
          icon="eva-calendar"
          label="Calendar"
          to="/calendar"
        />
      </q-tabs>
      </q-footer>


    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import { defineComponent, ref } from 'vue'
import { date } from 'quasar'

export default defineComponent({
  name: 'MainLayout',

  data(){
    return{

    }
  },
  mounted(){
    console.log('MainLayout Mounted in Laravel')
  },
  methods:{
  },
  computed:{
    dateToday(){
      let timeStamp = Date.now()

      let format = date.formatDate(timeStamp, 'ddd Do MMMM YYYY HH:mm:ss');

      return format;
    }
  }
})
</script>
