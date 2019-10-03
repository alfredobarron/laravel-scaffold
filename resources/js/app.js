
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


// Dependencies --------------------------------------

import Toasted from 'vue-toasted'
import VueClip from 'vue-clip'
import Multiselect from 'vue-multiselect'
import swal from 'sweetalert'
import VueContentPlaceholders from 'vue-content-placeholders'
//import { CalendarView, CalendarViewHeader } from "vue-simple-calendar"
import { FunctionalCalendar } from 'vue-functional-calendar'

Vue.use(require('vue-moment'))
Vue.use(Toasted)
Vue.toasted.register('error', message => message, {
    position : 'bottom-center',
    duration : 1000
})
Vue.use(VueClip)
Vue.component('multiselect', Multiselect)
Vue.use(VueContentPlaceholders)
//Vue.component('calendar-view', CalendarView)
//Vue.component('calendar-view-header', CalendarViewHeader)
Vue.component('FunctionalCalendar', FunctionalCalendar)



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 // Layout
 Vue.component('sidebar', require('./components/layout/Sidebar.vue'));

// Dashboard
Vue.component('users-count', require('./components/dashboard/UsersCount.vue'));
Vue.component('roles-count', require('./components/dashboard/RolesCount.vue'));

// Profile
Vue.component('profile', require('./components/profile/Profile.vue'));
Vue.component('profile-password', require('./components/profile/Password.vue'));

// Users
Vue.component('users-index', require('./components/users/Index.vue'));
Vue.component('users-create', require('./components/users/Create.vue'));
Vue.component('users-edit', require('./components/users/Edit.vue'));

// Roles
Vue.component('roles-index', require('./components/roles/Index.vue'));
Vue.component('roles-create', require('./components/roles/Create.vue'));
Vue.component('roles-edit', require('./components/roles/Edit.vue'));

// Events
Vue.component('events-index', require('./components/events/Index.vue'));

// Quotes Companies
Vue.component('quotes-companies-index', require('./components/quotesCompanies/Index.vue'));
Vue.component('quotes-companies-create', require('./components/quotesCompanies/Create.vue'));
Vue.component('quotes-companies-edit', require('./components/quotesCompanies/Edit.vue'));

// Quotes
Vue.component('quotes-index', require('./components/quotes/Index.vue'));
Vue.component('quotes-create', require('./components/quotes/Create.vue'));
Vue.component('quotes-edit', require('./components/quotes/Edit.vue'));

const app = new Vue({
    el: '#app'
});
