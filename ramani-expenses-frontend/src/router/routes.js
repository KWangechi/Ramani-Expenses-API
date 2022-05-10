import MainLayout from 'layouts/MainLayout.vue'
import IndexPage from 'pages/IndexPage.vue'
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
      { path: '/expenses', component: ExpensesPage},
      { path: '/calendar', component: CalendarPage},
      { path: '/create-expense', component: CreateExpensePage},
      { path: '/expenses/:id', component: OneExpense},




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
