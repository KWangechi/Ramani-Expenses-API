import MainLayout from 'layouts/MainLayout.vue'
import IndexPage from 'pages/IndexPage.vue'
import LoginPage from 'pages/LoginPage.vue'
import RegisterPage from 'pages/RegisterPage.vue'
import CalendarPage from 'pages/CalendarPage.vue'

import ExpensesPage from 'pages/ExpensesPage.vue'
import CreateExpensePage from 'pages/CreateExpensePage.vue'
import OneExpense from 'pages/OneExpense.vue'

const routes = [
  {
    path: '/',
    component: MainLayout,
    children: [
      { path: '', component: IndexPage },
      { path: '/login', component: LoginPage, meta:{
        middleware:"auth"
    }, },
      { path: '/register', component: RegisterPage, meta:{
        middleware:"auth"
    }, },
      { path: '/expenses', component: ExpensesPage, meta:{
        middleware:"auth"
    },},
      { path: '/calendar', component: CalendarPage, meta:{
        middleware:"auth"
    },},
      { path: '/create-expense', component: CreateExpensePage, meta:{
        middleware:"auth"
    },},
      { path: '/expenses/:id', component: OneExpense, meta:{
        middleware:"auth"
    },},

    ]
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue')
  }
]

export default routes
