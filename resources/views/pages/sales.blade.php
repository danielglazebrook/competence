@extends('layouts.app')

@section('content')

<div id="app">
    <div class="container m-auto mt-12">
        <h1 class="text-4xl">New ☕️ Sales</h1>

        <section class="flex flex-row items-end mt-10">
             <div class="mr-5">
                <label class="block text-sm font-medium leading-6 text-gray-900" for="quantity">Product</label>
                <div class="relative mt-2 rounded-md shadow-sm">
                    <select class="block w-full rounded-md border-0 py-1.5 pl-2 pr-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" name="quantity" v-model="selectedProductIndex">
                        <option v-for="(product, index) in products" :selected="selectedProductIndex === index" :value="index" v-text="product.name"></option>
                    </select>
                </div>
            </div>

            <div class="mr-5">
                <label class="block text-sm font-medium leading-6 text-gray-900" for="quantity">Quantity</label>
                <div class="relative mt-2 rounded-md shadow-sm">
                    <input class="block w-full rounded-md border-0 py-1.5 pl-2 pr-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" type="number" name="quanitity" v-model="quantity" placeholder="0" @keypress="isNumber($event)">
                </div>
            </div>

            <div class="mr-5">
                <label class="block text-sm font-medium leading-6 text-gray-900" for="unit-cost">Unit Cost (£)</label>
                
                <div class="relative mt-2 rounded-md shadow-sm">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <span class="text-gray-500 sm:text-sm">£</span>
                    </div>

                    <input class="block w-full rounded-md border-0 py-1.5 pl-7 pr-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="0.00" type="number" min="0.00" step="0.01" v-model="unit_cost" @keypress="isNumber($event)" />
                </div>
            </div>

            <div class="mr-5">
                <p class="block text-sm font-medium leading-6 text-gray-900 mb-2">Selling Price</p>
                <p class="block w-full rounded-md border-0 py-1.5 pl-2 pr-2 text-gray-900" :style="(quantity && unit_cost) ? {'visibility': 'visible' } : {'visibility': 'hidden'}" v-text="'£' + selling_price"></p>
            </div>

            <button class="bg-indigo-600 text-white rounded-lg px-7 py-0 h-10 ml-auto" :style="(quantity && unit_cost) ? {'visibility': 'visible' } : {'visibility': 'hidden'}" @click="submitSale()">Record Sale</button>
        </section>

        <p class="my-5 text-success" v-text="successMessage"></p>

        <section class="mt-10">
            <h1 class="text-4xl">Previous Sales</h1>

            <table class="table-auto mt-5 w-full text-left border-2 border-solid border-black">
                <thead>
                    <tr class="bg-gray-300">
                        <th>Product</th>
                        <th class="border-l-2 border-black">Quantity</th>
                        <th class="border-l-2 border-black">Unit Cost</th>
                        <th class="border-l-2 border-black">Selling Price</th>
                        <th class="border-l-2 border-black">Sold at</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="sale in sales">
                        <td class="border-b-2 border-black" v-text="sale.name"></td>
                        <td class="border-l-2 border-black border-b-2" v-text="sale.quantity"></td>
                        <td class="border-l-2 border-black border-b-2" v-text="'£' + sale.unit_cost"></td>
                        <td class="border-l-2 border-black border-b-2" v-text="'£' + Math.ceil([(cost_price(sale.quantity, sale.unit_cost) / (1 - (25 / 100))) + 10.00] * 100) / 100"></td>
                        <td class="border-l-2 border-black border-b-2" v-text="sale.sale_date_time"></td>
                    </tr>
                </tbody>
            </table>
        </section>
    </div>
</div>

<script>
    var app = new Vue({
        el: '#app',
        data: {
            products: <?= $products; ?>,
            selectedProductIndex: 0,
            sales: <?= $sales; ?>,
            quantity: null,
            unit_cost: null,
            shipping_cost: 10.00,
            successMessage: '',
            failureMessage: '',
        },
        computed: {
            selling_price: function() {
                return Math.ceil([(this.cost_price() / (1 - (this.products[this.selectedProductIndex].profit_margin / 100))) + this.shipping_cost] * 100) / 100
            },
            date_format: function(date) {
                var date = new Date

                return date.format
            }
        },
        methods: {
            cost_price: function(quantity = null, unit_cost = null) {
                if (quantity !== null && unit_cost !== null) {
                    return quantity * unit_cost
                }
                return this.quantity * this.unit_cost;
            },
            isNumber: function(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                    evt.preventDefault();;
                } else {
                    return true;
                }
            },
            submitSale: function() {
                let $this = this
                axios({
                    method: 'post',
                    url: '/sales/create',
                    data: {
                        product_id: this.products[this.selectedProductIndex].id,
                        quantity: this.quantity,
                        unit_cost: this.unit_cost,
                    }
                }).then(function(request) {
                    if (request.data === 1) {
                        this.successMessage = "Sale has been recorded successfully"
                        setTimeout(() => this.failureMessage = false, 2000);
                        location.reload()
                    } else {
                        this.failureMessage = "Sale was not recorded - please try again later"
                        setTimeout(() => this.failureMessage = false, 2000);
                    }
                });
            }
        },
        mounted() {
        }
    })
</script>

@endsection

