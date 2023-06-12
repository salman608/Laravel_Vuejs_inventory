<template>
<div>
    <div class="row justify-content-center">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card shadow-sm my-1 ">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Order Details</h6>
                    <router-link to="/order" class="btn btn-primary">All Order </router-link>
                </div>
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <br>
                            <!-- Simple Tables -->
                            <div class="card">

                                <div class="table-responsive">
                                    <ul class="list-group">
                                        <li class="list-group-item"><b>Name :</b> {{ orders.customer_name }}</li>
                                        <li class="list-group-item"><b>Phone :</b> {{ orders.customer_phone }}</li>
                                        <li class="list-group-item"><b>Address :</b> {{ orders.customer_address }}</li>
                                        <li class="list-group-item"><b>Date :</b> {{ orders.order_date }}</li>
                                        <li class="list-group-item"><b>Pay Through :</b> {{ orders.payby }}</li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <br>
                            <!-- Simple Tables -->
                            <div class="card">

                                <div class="table-responsive">
                                    <ul class="list-group">
                                        <li class="list-group-item"><b>Sub Total :</b> {{ orders.sub_total }} $</li>
                                        <li class="list-group-item"><b>Vat :</b> {{ orders.vat }} %</li>
                                        <li class="list-group-item"><b>Total :</b> {{ orders.total }} $</li>
                                        <li class="list-group-item"><b>Pay Amount :</b> {{ orders.pay }} $</li>
                                        <li class="list-group-item"><b>Due Amount :</b> {{ orders.due }} $</li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12 mb-4">

                            <div class="card">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Order List</h6>

                                </div>
                                <div class="table-responsive">
                                    <table class="table align-items-center table-flush">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Product Code</th>
                                                <th>Image</th>
                                                <th>Qty</th>
                                                <th>Unit Price</th>
                                                <th>Total Proce</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="detail in details" :key="detail.id">
                                                <td>{{ detail.product_name }}</td>
                                                <td>{{ detail.product_code }}</td>
                                                <td><img :src="'/'+detail.product_image" alt="" id="em_photo"></td>
                                                <td>{{ detail.product_quantity }}</td>
                                                <td>{{ detail.product_price }}$</td>
                                                <td>৳ {{ detail.sub_total }}$</td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
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

    data() {
        return {

            errors: {},
            orders: {},
            details: {},
        }
    },

    created() {
        let id = this.$route.params.id
        axios.get('/api/orders/details/' + id)
            .then(({
                data
            }) => (this.orders = data))
            .catch(console.log('error'))

        axios.get('/api/order/orderdetails/' + id)
            .then(({
                data
            }) => (this.details = data))
            .catch(console.log('error'))
    },

    methods: {

    },

    mounted() {

    }

}
</script>

<style>
#em_photo {
    width: 40px;
    height: 40px;
}
</style>
