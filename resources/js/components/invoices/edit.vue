<script setup>
import { onMounted, ref } from 'vue';
import router from '../../router';

let all_customers   = ref([]);
let customer_id     = ref([]);
let list_products   = ref([]);

let form = ref({
    id: "",
});

const props = defineProps({
    id: {
        type: String,
        default: "",
    },
});

onMounted( async () => {
    getInvoice();
    getAllCustomers();
    getProducts();
});

const isModalOpen = ref(false);


const openModal = async () => {
    await getProducts();  
    isModalOpen.value = true;  
};

const closeModal = () => {
    isModalOpen.value = false;
};

const addCart = (item) => {
    const item_cart = {
        product_id: item.id,
        item_code: item.item_code,
        description: item.description,
        unit_price: item.unit_price,
        quantity: item.quantity,
    }

    // list_cart.value.push(item_cart);
    form.value.invoice_items.push(item_cart);
    closeModal();
}

const deleteInvoiceItem = (id, i) => {
    form.value.invoice_items.splice(i, 1);
    if (id != undefined) {
        axios.get(`/api/destroy_invoice_item/${id}`);
    }
}

const getInvoice = async () => {
    let response = await axios.get(`/api/edit_invoice/${props.id}`);
    console.log('Edit Invoice:', response.data.invoice);
    form.value = response.data.invoice;
}

const getAllCustomers = async () => {
    const response = await axios.get('/api/customers');
    all_customers.value = response.data.customers;
}

const getProducts = async () => {
    let response = await axios.get('/api/products');
    // console.log('Products', response);
    list_products.value = response.data.products;
}

const SubTotal = () => {
    let total = 0;  
    
    if (form.value.invoice_items) {
        form.value.invoice_items.map((data) => {
            total = total + (data.unit_price * data.quantity);
        });
    }

    return total;
}

const Total = () => {
    if (form.value.discount) {
        return SubTotal() - form.value.discount;
    }
}

const onUpdate = (id) => {
    if (form.value.invoice_items.length >= 1) {
        // alert(JSON.stringify(form.value.invoice_items));
        let subtotal = 0;
        subtotal = SubTotal();

        let total = 0;
        total = Total();

        const formData = new FormData();
        formData.append('invoice_item', JSON.stringify(form.value.invoice_items));
        formData.append('customer_id', form.value.customer_id);
        formData.append('date', form.value.date);
        formData.append('due_date', form.value.due_date);
        formData.append('number', form.value.number);
        formData.append('reference', form.value.reference);
        formData.append('terms_and_conditions', form.value.terms_and_conditions);
        formData.append('discount', form.value.discount);
        formData.append('subtotal', subtotal);
        formData.append('total', total);

        axios.post(`/api/update_invoice/${form.value.id}`, formData);

        form.value.invoice_items = [];

        router.push('/');
    }
}

</script>

<template>
    <div class="invoices mt-10 p-8 bg-white shadow-xl max-w-6xl mx-auto rounded-xl">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-4xl font-semibold text-gray-800">Edit Invoice</h2>
            </div>
        </div>

        <!-- Content -->
        <div class="">
            <!-- Customer and Date Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <!-- Customer -->
                <div>
                    <label class="my-2 text-gray-900">Customer</label>
                    <select v-model="form.customer_id" class="input w-full p-3 border text-slate-950 border-gray-300 rounded-lg outline-none focus:ring-1 focus:ring-blue-500 transition-all duration-300">
                        <option disabled>--Select Customer--</option>
                        <option :value="customer.id" v-for="customer in all_customers" :key="customer.id">
                            {{ customer.first_name }} {{ customer.last_name }}
                        </option>
                    </select>
                </div>

                <!-- Dates -->
                <div>
                    <label class="my-2 text-gray-600">Date</label>
                    <input id="date" type="date" v-model="form.date" class="input w-full p-3 border border-gray-300 rounded-lg outline-none focus:ring-1 focus:ring-blue-500 transition-all duration-300" />
                    <label class="my-2 text-gray-600">Due Date</label>
                    <input id="due_date" type="date" v-model="form.due_date" class="input w-full p-3 border border-gray-300 rounded-lg outline-none focus:ring-1 focus:ring-blue-500 transition-all duration-300" />
                </div>

                <!-- Invoice Number & Reference -->
                <div>
                    <label class="my-2 text-gray-600">Number</label>
                    <input type="text" v-model="form.number" class="input w-full p-3 border border-gray-300 rounded-lg outline-none focus:ring-1 focus:ring-blue-500 transition-all duration-300" />
                    <label class="my-2 text-gray-600">Reference (Optional)</label>
                    <input type="text" v-model="form.reference" class="input w-full p-3 border border-gray-300 rounded-lg outline-none focus:ring-1 focus:ring-blue-500 transition-all duration-300" />
                </div>
                
            </div>

            <!-- Add New Line Button -->
            <div class="mb-3">
                <button @click="openModal" class="btn btn-sm bg-blue-100 text-blue-500 border border-blue-300 hover:text-white px-6 py-3 rounded-lg hover:bg-blue-500 transition-all duration-300 cursor-pointer">
                    + Add New Line
                </button>
            </div>

            <!-- Table Section -->
            <div class="table w-full mb-8">
                <div class="flex justify-between gap-6 font-semibold text-gray-900 bg-gray-200 p-5 rounded-lg">
                    <p>Item Code</p>
                    <p>Description</p>
                    <p>Unit Price</p>
                    <p>Quantity</p>
                    <p>Total</p>
                    <p>Action</p>
                </div>

                <div v-for="(item_cart, i) in form.invoice_items" :key="item_cart.id" class="flex justify-between gap-6 items-center p-4 border-b border-gray-200">
                    <p v-if="item_cart.product">
                        #{{ item_cart.product.item_code }} {{ item_cart.product.description.slice(0, 5) }}
                    </p>

                    <p v-else>
                        {{ item_cart.item_code }} {{ item_cart.description.slice(0, 5) }}                        
                    </p>
                    
                    <p>
                        <input type="text" v-model="item_cart.unit_price" class="input w-full p-2 border border-gray-300 rounded-lg outline-none focus:ring-1 focus:ring-blue-500 transition-all duration-300" />
                    </p>
                    <p>
                        <input type="text" v-model="item_cart.quantity"  class="input w-full p-2 border border-gray-300 rounded-lg outline-none focus:ring-1 focus:ring-blue-500 transition-all duration-300" />
                    </p>
                    <p>$ {{ item_cart.quantity * item_cart.unit_price }}</p>
                    <p class="text-red-500 text-2xl cursor-pointer" @click="deleteInvoiceItem(item_cart.id, i)">&times;</p>
                </div>

            </div>

            <!-- Footer Section -->
            <div class="table__footer mt-8">
                <div class="document-footer grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Terms and Conditions -->
                    <div>
                        <label class="my-2 text-gray-600">Terms and Conditions</label>
                        <textarea cols="50" rows="3"  class="textarea w-full p-3 border border-gray-300 rounded-lg outline-none focus:ring-1 focus:ring-blue-500 transition-all duration-300">{{ form.terms_and_conditions }}</textarea>
                    </div>

                    <!-- Total Section -->
                    <div>
                        <div class="table__footer--subtotal flex justify-between mb-4">
                            <p class="text-gray-600">Sub Total</p>
                            <span class="text-gray-800">$ {{ SubTotal() }}</span>
                        </div>
                        <div class="table__footer--discount flex justify-between mb-4">
                            <p class="text-gray-600">Discount</p>
                            <input type="text" v-model="form.discount" class="input w-1/2 p-3 border border-gray-300 rounded-lg outline-none focus:ring-1 focus:ring-blue-500 transition-all duration-300" />
                        </div>
                        <div class="table__footer--total flex justify-between">
                            <p class="text-gray-600">Grand Total</p>
                            <span class="text-gray-800">$ {{ Total() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="card__header mt-10 flex justify-end">
            <button @click="onUpdate(form.id)" class="btn bg-indigo-500 text-white px-8 py-3 rounded-lg hover:bg-transparent hover:text-indigo-500 border border-indigo-500 transition-all duration-300 cursor-pointer">
                Update Invoice
            </button>
        </div>
    </div>

    <transition name="modal">
    <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center backdrop-brightness-50 bg-opacity-50" @click.self="closeModal">
        <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-3xl uppercase font-semibold">Add Item</h3>
                <button @click="closeModal" class="text-rose-500 text-3xl font-semibold cursor-pointer hover:text-rose-700">&times;</button>
            </div>

            <div class="mb-4">
                <ul class="divide-y divide-gray-200">
                    <li v-for="(item, i) in list_products" :key="item.id" class="flex items-center justify-between text-left p-2 border-b border-gray-200">
                        <p class="text-gray-700">{{ i + 1 }}.</p>
                        <a href="#" class="flex-1 px-4 text-gray-900 truncate hover:text-blue-500 hover:underline transition-all duration-300">
                            {{ item.description }}
                        </a>
                        <button @click="addCart(item)" class="bg-lime-200 text-lime-500 hover:text-white cursor-pointer px-4 py-2 rounded-lg hover:bg-lime-500 transition-all duration-300">
                            <i class="fas fa-plus"></i> Add
                        </button>
                    </li>
                </ul>
            </div>

            <div class="flex justify-end">
                <button @click="closeModal" class="btn bg-gray-100 cursor-pointer text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-all duration-300 mr-2">
                    Cancel
                </button>
                <button @click="closeModal" class="btn bg-green-200 text-green-500 hover:text-white cursor-pointer px-4 py-2 rounded-lg hover:bg-green-500 transition-all duration-300">
                    Save
                </button>
            </div>
        </div>
    </div>
</transition>

</template>

<style scoped>
/* Modal Transition */
.modal-enter-active,
.modal-leave-active {
    transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
    opacity: 0;
}
</style>