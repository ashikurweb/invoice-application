import { createRouter, createWebHistory } from 'vue-router'

import invoiceIndex from '../components/invoices/index.vue'
import createInvoice from '../components/invoices/create.vue'
import showInvoice from '../components/invoices/show.vue'
import notFound from '../components/NotFound.vue'

const routes = [
    {
        path: '/',
        component: invoiceIndex
    },

    {
        path: '/invoice/create',
        component: createInvoice
    },

    {
        path: '/invoice/show/:id',
        component: showInvoice,
        props: true
    },

    {
        path: '/:pathMatch(.*)*',
        component: notFound
    }
];


const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router