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
          @click="toggleLeftDrawer = !toggleLeftDrawer"
        />

        <q-toolbar-title> Ramani Expense </q-toolbar-title>

        {{ dateToday }}
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="toggleLeftDrawer"
      show-if-above
      :width="200"
      :breakpoint="400"
    >
      <q-scroll-area
        style="
          height: calc(100% - 150px);
          margin-top: 150px;
          border-right: 1px solid #ddd;
        "
      >
        <q-list padding>
          <q-item active clickable v-ripple>
            <q-item-section avatar>
              <q-icon name="dashboard" />
            </q-item-section>

            <q-item-section> Dashboard </q-item-section>
          </q-item>

          <q-item clickable v-ripple>
            <q-item-section avatar>
              <q-icon name="inbox" />
            </q-item-section>

            <q-item-section> Inbox </q-item-section>
          </q-item>

          <q-item clickable v-ripple>
            <q-item-section avatar>
              <q-icon name="report" />
            </q-item-section>

            <q-item-section> Reports </q-item-section>
          </q-item>

          <q-item clickable v-ripple @click="logout">
            <q-item-section avatar>
              <q-icon name="logout" />
            </q-item-section>

            <q-item-section> Logout </q-item-section>
          </q-item>
        </q-list>
      </q-scroll-area>

      <q-img
        class="absolute-top"
        src="https://cdn.quasar.dev/img/material.png"
        style="height: 150px"
      >
        <div class="absolute-bottom bg-transparent">
          <q-avatar size="56px" class="q-mb-sm">
            <img src="https://cdn.quasar.dev/img/boy-avatar.png" />
          </q-avatar>
          <div class="text-weight-bold">{{store.user.name}}</div>
          <div>{{ store.user.email }}</div>
        </div>
      </q-img>
    </q-drawer>

    <q-footer class="bg-white small-screen-only" bordered>
      <q-tabs
        class="text-grey-10"
        active-color="primary"
        indicator-color="transparent"
        align="justify"
        :breakpoint="0"
      >
        <q-route-tab
          name="expenses"
          icon="money"
          label="Expenses"
          to="/expenses"
        />
      </q-tabs>
    </q-footer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import { defineComponent } from "vue";
import { date } from "quasar";
import { useAuthStore } from "src/stores/auth";
import { mapState, mapActions } from "pinia";

export default defineComponent({
  name: "MainLayout",

  data() {
    return {
      toggleLeftDrawer: false,
      store: useAuthStore(),
    };
  },

  computed: {
    // ...mapState(useAuthStore, {
    //   user: "user",
    // }),

    // ...mapActions(useAuthStore, {
    //   getUser: "getUser",
    // }),
  },
  created() {
    this.getUser();
    console.log(this.store.user);
  },
  methods: {
    logout() {
      const store = useAuthStore();
      store.logout();
    },

    async getUser() {
      const store = useAuthStore();
      return store.getUser();
    },
  },
  computed: {
    dateToday() {
      let timeStamp = Date.now();
      let format = date.formatDate(timeStamp, "ddd Do MMMM YYYY HH:mm:ss");

      return format;
    },
  },
});
</script>
