<script setup>
import { onMounted, ref } from "vue";
import router from "../../router";
import moment from 'moment-timezone';


let form = ref({ id: "" });

const props = defineProps({
    id: {
        type: String,
        default: "",
    },
});

onMounted( async () => {
    getInvoices();
});

const getInvoices = async () => {
    let response = await axios.get(`/api/show_invoice/${props.id}`);
    // console.log('Form:', response.data.invoice);
    form.value = response.data.invoice;
}

const printInvoice = () => {
    window.print();
    router.push('/').catch(() => {});
}


const onEdit  = () => {
    router.push('/invoice/edit/'+props.id);
}


const deleteInvoice = (id) => {
    axios.get(`/api/destroy_invoice/${id}`);
    router.push('/');
}

const formatDate = (dateString) => {
    return moment(dateString)
        .tz('Asia/Dhaka')
        .format("YY-MM-DD HH:mm:ss A");
}

const downloadPDF = (id) => {
    const link = document.createElement('a');
    link.href = `/invoice/pdf/${id}`;
    link.download = `invoice-${id}.pdf`; 
    document.body.appendChild(link); 
    link.click(); 
    document.body.removeChild(link);
};

const downloadReceipt = (id) => {
    const link = document.createElement('a');
    link.href = `/invoices/${id}/download-receipt`;
    link.download = `receipt-${id}.pdf`; 
    document.body.appendChild(link); 
    link.click(); 
    document.body.removeChild(link);
};

</script>

<template>
    <div class="bg-white max-w-6xl p-10 mx-auto rounded-lg shadow-lg mt-6">
        <div
            class="text-center mb-6 p-4"
        >
            <p class="text-4xl font-bold uppercase tracking-wide">Invoice</p>
        </div>

        <!-- Invoice To and Details -->
        <div class="flex justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold">Invoice To:</h2>
                <p v-if="form.customer" class="text-gray-600 text-sm font-semibold uppercase">
                    {{ form.customer.first_name }} {{ form.customer.last_name }}
                </p>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <p class="text-gray-500 font-bold">Invoice: <span class="text-slate-800">{{ form.number }}</span></p>
                </div>
                <div class="flex justify-between">
                    <p class="text-gray-500 font-bold">Date: <span class="text-slate-800">{{ form.date }}</span></p>
                </div>
                <div class="flex justify-between">
                    <p class="text-gray-500 font-bold">Due Date: <span class="text-slate-800">{{ form.due_date }}</span></p>
                </div>
                <div class="flex justify-between">
                    <p class="text-gray-500 font-bold">Reference: <span class="text-slate-800">{{ form.reference }}</span></p>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="mb-6  bg-white rounded-lg">
            <div
                class="grid grid-cols-5 gap-4 font-bold text-slate-200 border-b border-slate-500 bg-slate-600 p-2 pb-2"
            >
                <p>#</p>
                <p>Item Description</p>
                <p>Unit Price</p>
                <p>Qty</p>
                <p>Total</p>
            </div>

            <!-- Item 1 -->
            <div 
                v-for="(item, i) in form.invoice_items" :key="item.id"
                class="grid grid-cols-5 gap-4 hover:bg-slate-100 p-2 border-b border-slate-300 transition-all duration-300"
            >
                <p class="text-gray-700">{{ i+1 }}</p>
                <p class="text-gray-700">{{ item.product.description.slice(0, 20) }}...</p>
                <p class="text-gray-700">${{ item.unit_price }}</p>
                <p class="text-gray-700">{{ item.quantity }}</p>
                <p class="text-gray-700">$ {{ item.unit_price * item.quantity }}</p>
            </div>
        </div>

        <!-- Subtotal -->
        <div class="flex justify-between mb-6">
            <div>
                <h2 class="text-lg font-bold">Thank you for your business</h2>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <p class="text-gray-500">Sub Total: <span class="font-bold text-slate-800">$ {{ form.sub_total }}</span></p>
                </div>
                <div class="flex justify-between">
                    <p class="text-gray-500">Discount: <span class="font-bold text-slate-800">$ {{ form.discount }}</span></p>
                </div>
            </div>
        </div>

        <!-- Grand Total and Terms -->
        <div class="flex justify-between">
            <div>
                <h2 class="text-lg font-bold">Terms and Conditions</h2>
                <p class="text-gray-500">
                    {{ form.terms_and_conditions }}
                </p>
            </div>
            <div>
                <div class="flex justify-between">
                    <p class="text-lg font-bold">Grand Total: <span class="font-bold text-slate-800 ">$ {{ form.total }}</span></p>
                </div>
            </div>
        </div>


        <!-- Invoice Details -->
        <div class="flex justify-between items-center mb-6 p-4 mt-8 rounded-lg">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">#{{ form.id }}</h1>
                <p class="text-gray-500 text-sm">{{ formatDate(form.created_at) }}</p>
            </div>
            <div>
                <ul class="flex space-x-4">
                    <li>
                        <button 
                            @click="printInvoice()"
                            class="bg-slate-200 text-slate-600 hover:text-white cursor-pointer px-4 py-2 rounded-lg hover:bg-slate-600 transition-all duration-300 flex items-center space-x-2"
                        >
                            <i class="fas fa-print"></i>
                            <span>Print</span>
                        </button>
                    </li>

                    <li>
                        <button
                            @click="downloadPDF(form.id)"
                            class="bg-slate-200 text-slate-600 hover:text-white cursor-pointer px-4 py-2 rounded-lg hover:bg-slate-600 transition-all duration-300 flex items-center space-x-2"
                        >
                            <i class="fas fa-download"></i>
                            <span>Download PDF</span>
                        </button>
                    </li>

                    <li>
                        <button
                            @click="downloadReceipt(form.id)"
                            class="bg-slate-200 text-slate-600 hover:text-white cursor-pointer px-4 py-2 rounded-lg hover:bg-slate-600 transition-all duration-300 flex items-center space-x-2"
                        >

                            <i class="fas fa-download"></i>
                            <span>Download Receipt</span>
                        </button>
                    </li>

                    <li>
                        <button
                            @click="onEdit(form.id)"
                            class="bg-slate-200 text-slate-600 px-4 py-2 rounded-lg hover:text-white cursor-pointer hover:bg-slate-600 transition-all duration-300 flex items-center space-x-2"
                        >
                            <i class="fas fa-edit"></i>
                            <span>Edit</span>
                        </button>
                    </li>
                    <li>
                        <button
                            @click="deleteInvoice(form.id)"
                            class="bg-slate-200 text-slate-600 hover:text-white px-4 py-2 rounded-lg hover:bg-slate-600 cursor-pointer transition-all duration-300 flex items-center space-x-2"
                        >
                            <i class="fas fa-trash"></i>
                            <span>Delete</span>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
