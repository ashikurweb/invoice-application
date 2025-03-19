<script setup>
import {onMounted, ref} from 'vue'

let invoices = ref([])

onMounted(() => {
    getInvoices()
})


const getInvoices = async () => {
    let response = await axios.get('/api/get_all_invoice');
    invoices.value = response.data.invoices
};
</script>

<template>
    <!-- ===== INVOICE LIST ===== -->
    <div class="max-w-5xl mt-5 mx-auto p-6 bg-white shadow-xl rounded-xl border border-gray-200 dark:bg-gray-900 dark:border-gray-800 transition">
        <!-- Header -->
        <div class="flex justify-between items-center border-b pb-4">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200">Invoices</h2>
            <button class="bg-gradient-to-r from-blue-500 to-purple-500 text-white px-5 py-2 rounded-lg shadow-md transition cursor-pointer">
                + New Invoice
            </button>
        </div>

        <!-- Filter & Search Section -->
        <div class="flex flex-col md:flex-row justify-between items-center mt-6 space-y-4 md:space-y-0">
            <!-- Filter -->
            <div class="relative">
                <button class="p-3 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 transition">
                    <i class="fas fa-ellipsis-h"></i>
                </button>
                <ul class="absolute left-0 mt-2 w-36 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-md hidden">
                    <li class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">All</li>
                    <li class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">Paid</li>
                </ul>
            </div>

            <!-- Search & Select -->
            <div class="flex items-center space-x-4">
                <select class="px-4 py-2 border rounded-lg text-gray-600 dark:text-gray-300 bg-gray-50 dark:bg-gray-800 focus:ring-blue-500">
                    <option>Filter</option>
                </select>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400 dark:text-gray-500"></i>
                    <input type="text" placeholder="Search invoice"
                        class="pl-10 pr-4 py-2 border rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-300 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>
            </div>
        </div>

        <!-- Table Heading -->
        <div class="grid grid-cols-6 font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 p-4 mt-6 rounded-lg">
            <p>ID</p>
            <p>Date</p>
            <p>Number</p>
            <p>Customer</p>
            <p>Due Date</p>
            <p>Total</p>
        </div>

        <!-- Invoice Item -->
        <div v-for="item in invoices" :key="item.id" v-if="invoices.length > 0" class="grid grid-cols-6 items-center p-4 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
            <a href="#" class="text-blue-500 dark:text-blue-400 hover:underline">#{{ item.id }}</a>
            <p class="text-gray-600 dark:text-gray-300">{{ item.date }}</p>
            <p class="text-gray-600 dark:text-gray-300">{{ item.number }}</p>
            <p v-if="item.customer" class="text-gray-800 dark:text-gray-200">
                {{ item.customer.first_name }} 
            </p>
            <p v-else class="text-gray-800 dark:text-gray-200">
                N/A
            </p>
            <p class="text-gray-600 dark:text-gray-300">{{ item.due_date }}</p>
            <p class="font-semibold text-green-600 dark:text-green-400">${{ item.total }}</p>
        </div>

        <div v-else class="grid grid-cols-6 items-center p-4 border-b border-gray-200 dark:border-gray-700">
            <p>Invoice Not Found</p>
        </div>
    </div>
</template>