<template>
<div>
    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">POS Dashboard</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">POS</li>
            </ol>
        </div>

        <div class="row mb-3">

            <!-- Area Chart -->
            <div class="col-xl-5 col-lg-5">
                <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Expense Insert </h6>
                        <a class="btn btn-sm btn-info text-white">Add Customer</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush" style="font-size:12px;">
                            <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Qty</th>
                                    <th>Unit</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="cart in carts" :key="cart.id" class="mr-5">
                                    <td>{{ cart.pro_name }}</td>
                                    <td class="qty"><input type="text" readonly :value="cart.pro_quantity" style="width:15px">
                                        <button @click.prevent="increment(cart.id)" class="btn btn-sm btn-success">+</button>
                                        <button @click.prevent="decrement(cart.id)" class="btn btn-sm btn-danger" v-if="cart.pro_quantity>=2">-</button>
                                        <button v-else class="btn btn-sm btn-danger" disabled>-</button>
                                    </td>
                                    <td>{{ cart.product_price }}</td>
                                    <td>{{ cart.sub_total }}</td>
                                    <td><a @click="removeItem(cart.id)" class="btn btn-sm btn-primary text-white">X</a></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Total Quantity: <strong>{{ qty }}</strong>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Sub Total: <strong>{{ subtotal }} $</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Vat: <strong>{{ vats.vat }} %</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Total Amount: <strong>{{ subtotal*vats.vat /100 + subtotal }} $</strong>
                            </li>
                        </ul>
                        <br>

                        <form @submit.prevent="Order">
                            <label for="">Customer Name</label>
                            <select class="form-control" v-model="customer_id">
                                <option :value="customer.id" v-for="customer in customers" :key="customer.id">{{ customer.customer_name }}</option>

                            </select>

                            <label for="">Pay Amount</label>
                            <input type="text" class="form-control" v-model="pay">

                            <label for="">Due Amount</label>
                            <input type="text" class="form-control" v-model="due">

                            <label for="">Pay By</label>
                            <select class="form-control" v-model="payby">
                                <option value="HandCash">HandCash</option>
                                <option value="Cheaqe">Cheaqe</option>
                                <option value="GiftCard">GiftCard</option>
                            </select>
                            <br>
                            <button type="submit" class="btn btn-success ">Submit</button>
                        </form>
                    </div>

                </div>
            </div>
            <!-- Pie Chart -->
            <div class="col-xl-7 col-lg-7">
                <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Products Sold</h6>
                        <input type="text" v-model="searchTerm" class="form-control w-50" placeholder="Search Here....">
                    </div>

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">All Product</button>
                        </li>
                        <li class="nav-item" role="presentation" v-for="category in categories" :key="category.id">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false" @click="subProduct(category.id)">{{ category.category_name }}</button>
                        </li>

                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <!-- Start all product tabs -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="cl-lg-3 col-md-3 col-sm-6 col-6" v-for="product in filtersearch" :key="product.id">
                                        <button class="btn btn-sm" @click.prevent="AddToCart(product.id)">
                                            <div class="card mb-2" style="width:8.5rem">
                                                <img :src="product.product_image" alt="" id="em_photo" class="card-img-top">
                                                <div class="card-body">
                                                    <h6 class="">{{ product.product_name }}</h6>
                                                    <td v-if="product.product_quantity >= 1">
                                                        <span class="badge badge-success">Available {{ product.product_quantity }}</span>
                                                    </td>
                                                    <td v-else>
                                                        <span class="badge badge-warning">Stock Out </span>
                                                    </td>
                                                </div>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End all product tabs -->
                        <div class="tab-pane fade mt-2" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="row">
                                <input type="text" v-model="getSearchTerm" class="form-control catSearch" placeholder="Search Here....">
                                <div class="cl-lg-3 col-md-3 col-sm-6 col-6" v-for="getproduct in getfiltersearch" :key="getproduct.id">
                                    <button class="btn btn-sm" @click.prevent="AddToCart(getproduct.id)">
                                        <div class="card mt-2 mb-2 " style="width:8.5rem">
                                            <img :src="getproduct.product_image" alt="" id="em_photo" class="card-img-top">
                                            <div class="card-body">
                                                <h6 class="">{{ getproduct.product_name }}</h6>
                                                <td v-if="getproduct.product_quantity >= 1">
                                                    <span class="badge badge-success">Available {{ getproduct.product_quantity }}</span>
                                                </td>
                                                <td v-else>
                                                    <span class="badge badge-warning">Stock Out </span>
                                                </td>
                                            </div>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
        <!--Row-->

    </div>

</div>
</template>

<script>
export default {
    created() {
        if (!User.loggedIn()) {
            this.$router.push({
                name: '/'
            })
        }
    },

    mounted() {
        this.allProduct();
        this.allCategory();
        this.allCustomer();
        this.cartProduct();
        this.vat();
        Reload.$on('AfterAdd', () => {
            this.cartProduct();
        })
    },

    data() {
        return {
            //order field
            customer_id: '',
            pay: '',
            due: '',
            payby: '',

            products: [],
            categories: '',
            getproducts: [],
            searchTerm: '',
            getSearchTerm: '',
            customers: '',
            errors: '',
            carts: [],
            vats: [],
        }
    },

    computed: {
        filtersearch() {
            return this.products.filter(product => {
                return product.product_name.match(this.searchTerm)

            })
        },
        getfiltersearch() {
            return this.getproducts.filter(getproduct => {
                return getproduct.product_name.match(this.getSearchTerm)

            })
        },

        qty() {
            let sum = 0;
            for (let i = 0; i < this.carts.length; i++) {
                sum += (parseFloat(this.carts[i].pro_quantity));
            }
            return sum;
        },
        subtotal() {
            let sum = 0;
            for (let i = 0; i < this.carts.length; i++) {
                sum += (parseFloat(this.carts[i].pro_quantity) * parseFloat(this.carts[i].product_price));
            }
            return sum;
        },
    },

    methods: {
        //add to cart
        AddToCart(id) {
            axios.get('/api/addToCart/' + id)
                .then(() => {
                    Reload.$emit('AfterAdd');
                    Notification.cart_success()
                })
                .catch()
        },
        cartProduct() {
            axios.get('/api/cart/product/')
                .then(({
                    data
                }) => (this.carts = data))
                .catch()
        },

        removeItem(id) {
            axios.get('/api/remove/cart/' + id)
                .then(() => {
                    Reload.$emit('AfterAdd');
                    Notification.cart_delete()
                })
                .catch()
        },
        increment(id) {
            axios.get('/api/increment/' + id)
                .then(() => {
                    Reload.$emit('AfterAdd');
                    Notification.success()
                })
                .catch()
        },
        decrement(id) {
            axios.get('/api/decrement/' + id)
                .then(() => {
                    Reload.$emit('AfterAdd');
                    Notification.success()
                })
                .catch()
        },
        vat() {
            axios.get('/api/vats/')
                .then(({
                    data
                }) => (this.vats = data))
                .catch()
        },
        allProduct() {
            axios.get('/api/product/')
                .then(({
                    data
                }) => (this.products = data))
                .catch()
        },

        allCategory() {
            axios.get('/api/category/')
                .then(({
                    data
                }) => (this.categories = data))
                .catch()
        },

        allCustomer() {
            axios.get('/api/customer/')
                .then(({
                    data
                }) => (this.customers = data))
                .catch(console.log('error'))
        },

        subProduct(id) {
            axios.get('/api/getting/product/' + id)
                .then(({
                    data
                }) => (this.getproducts = data))
                .catch()
        },

        Order() {
            let total = this.subtotal * this.vats.vat / 100 + this.subtotal;
            var data = {
                qty: this.qty,
                subtotal: this.sub_total,
                customer_id: this.customer_id,
                pay: this.pay,
                payby: this.payby,
                vat: this.vats.vat,
                due: this.due,
                total: total
            }

            axios.post('/api/order/complete',data)
                    .then(() => {
                        Notification.success()
                        this.$router.push({name:'home'});
                    })
        },


    },

}
</script>

<style scoped>
#em_photo {
    height: 90px;
    width: 135px;
}

.catSearch {
    width: 95%;
    margin: auto;
}
</style>
