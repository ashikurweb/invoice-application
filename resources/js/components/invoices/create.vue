<template>
    <div class="invoices mt-10 p-8 bg-white shadow-xl max-w-6xl mx-auto rounded-xl">
    <!-- Header -->
    <div class="card__header flex justify-between items-center mb-8">
        <div>
            <h2 class="invoice__title text-4xl font-semibold text-gray-800">
                New Invoice
            </h2>
        </div>
    </div>

    <!-- Content -->
    <div class="card__content">
        <!-- Customer and Date Section -->
        <div class="card__content--header grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <!-- Customer -->
            <div>
                <label class="my-2 text-gray-600">Customer</label>
                <select class="input w-full p-3 border border-gray-300 rounded-lg outline-none focus:ring-1 focus:ring-blue-500 transition-all duration-300">
                    <option value="">Customer 1</option>
                </select>
            </div>

            <!-- Dates -->
            <div>
                <label class="my-2 text-gray-600">Date</label>
                <input id="date" type="date" class="input w-full p-3 border border-gray-300 rounded-lg outline-none focus:ring-1 focus:ring-blue-500 transition-all duration-300" />
                <label class="my-2 text-gray-600">Due Date</label>
                <input id="due_date" type="date" class="input w-full p-3 border border-gray-300 rounded-lg outline-none focus:ring-1 focus:ring-blue-500 transition-all duration-300" />
            </div>

            <!-- Invoice Number & Reference -->
            <div>
                <label class="my-2 text-gray-600">Invoice Number</label>
                <input type="text" class="input w-full p-3 border border-gray-300 rounded-lg outline-none focus:ring-1 focus:ring-blue-500 transition-all duration-300" />
                <label class="my-2 text-gray-600">Reference (Optional)</label>
                <input type="text" class="input w-full p-3 border border-gray-300 rounded-lg outline-none focus:ring-1 focus:ring-blue-500 transition-all duration-300" />
            </div>
        </div>

        <!-- Table Section -->
        <div class="table mb-8">
            <div class="table--heading2 grid grid-cols-5 gap-4 font-semibold text-gray-900 bg-gray-200 p-4 rounded-lg">
                <p>Item Description</p>
                <p>Unit Price</p>
                <p>Quantity</p>
                <p>Total</p>
                <p></p>
            </div>

            <!-- Item Row -->
            <div class="table--items2 grid grid-cols-5 gap-4 items-center p-4 border-b border-gray-200">
                <p>#093654 jkvjxckvjkx</p>
                <input type="text" class="input w-full p-2 border border-gray-300 rounded-lg outline-none focus:ring-1 focus:ring-blue-500 transition-all duration-300" />
                <input type="text" class="input w-full p-2 border border-gray-300 rounded-lg outline-none focus:ring-1 focus:ring-blue-500 transition-all duration-300" />
                <p>$ 10,000</p>
                <p class="text-red-500 text-2xl cursor-pointer">&times;</p>
            </div>

            <!-- Add New Line Button -->
            <div class="p-4">
                <button class="btn btn-sm bg-blue-100 text-blue-500 border border-blue-300 hover:text-white px-6 py-3 rounded-lg hover:bg-blue-500 transition-all duration-300 cursor-pointer">
                    Add New Line
                </button>
            </div>
        </div>

        <!-- Footer Section -->
        <div class="table__footer mt-8">
            <div class="document-footer grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Terms and Conditions -->
                <div>
                    <label class="my-2 text-gray-600">Terms and Conditions</label>
                    <textarea cols="50" rows="3" class="textarea w-full p-3 border border-gray-300 rounded-lg outline-none focus:ring-1 focus:ring-blue-500 transition-all duration-300"></textarea>
                </div>

                <!-- Total Section -->
                <div>
                    <div class="table__footer--subtotal flex justify-between mb-4">
                        <p class="text-gray-600">Sub Total</p>
                        <span class="text-gray-800">$ 1,000</span>
                    </div>
                    <div class="table__footer--discount flex justify-between mb-4">
                        <p class="text-gray-600">Discount</p>
                        <input type="text" class="input w-1/2 p-3 border border-gray-300 rounded-lg outline-none focus:ring-1 focus:ring-blue-500 transition-all duration-300" />
                    </div>
                    <div class="table__footer--total flex justify-between">
                        <p class="text-gray-600">Grand Total</p>
                        <span class="text-gray-800">$ 1,200</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Save Button -->
    <div class="card__header mt-10 flex justify-end">
        <button class="btn bg-purple-500 text-white px-8 py-3 rounded-lg hover:bg-transparent hover:text-purple-500 border border-purple-500 transition-all duration-300 cursor-pointer">
            Save Invoice
        </button>
    </div>
</div>

</template>
