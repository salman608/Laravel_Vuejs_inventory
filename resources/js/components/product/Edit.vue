<template>
<div>
    <div class="row justify-content-center">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card shadow-sm my-1 ">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="login-form">
                                <div class="py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Product Update</h6>
                                    <router-link to="/product" class="btn btn-primary">All Product </router-link>

                                </div>

                                <form class="user" @submit.prevent="productUpdate" enctype="multipart/form-data">

                                    <div class="form-group">

                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter Your product Name" v-model="form.product_name">
                                                <small class="text-danger" v-if="errors.product_name"> {{ errors . product_name[0] }}
                                                </small>
                                            </div>

                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter Your product code" v-model="form.product_code">
                                                <small class="text-danger" v-if="errors.product_code">
                                                    {{ errors . product_code[0] }} </small>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <label for="exampleFormControlSelect1">Product Category</label>
                                                <select class="form-control" id="exampleFormControlSelect1" v-model="form.category_id">
                                                    <option :value="category.id" v-for="category in categories">
                                                        {{ category.category_name }}
                                                    </option>

                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="exampleFormControlSelect2">Product Supplier</label>
                                                <select class="form-control" id="exampleFormControlSelect2" v-model="form.supplier_id">
                                                    <option :value="supplier.id" v-for="supplier in suppliers">
                                                        {{ supplier.name }}
                                                    </option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">

                                        <div class="form-row">
                                            <div class="col-md-4">

                                                <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter Your product root" v-model="form.root">
                                                <small class="text-danger" v-if="errors.root">
                                                    {{ errors . root[0] }} </small>

                                            </div>
                                            <div class="col-md-4">

                                                <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter Your Buying price" v-model="form.buying_price">
                                                <small class="text-danger" v-if="errors.buying_price">
                                                    {{ errors . buying_price[0] }} </small>

                                            </div>

                                            <div class="col-md-4">
                                                <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter Your Selling price" v-model="form.selling_price">
                                                <small class="text-danger" v-if="errors.selling_price"> {{ errors . selling_price[0] }}
                                                </small>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="form-group">

                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <label for="exampleInputDate">Buying Date</label>
                                                <input type="date" class="form-control" id="exampleInputDate" placeholder="Enter Your Joining Date" v-model="form.buying_date">
                                                <small class="text-danger" v-if="errors.buying_date">
                                                    {{ errors . buying_date[0] }} </small>

                                            </div>

                                            <div class="col-md-6">
                                                <label for="exampleInputQuantity">Product Quantity</label>
                                                <input type="text" class="form-control" id="exampleInputQuantity" placeholder="Enter Product Quantity" v-model="form.product_quantity">
                                                <small class="text-danger" v-if="errors.product_quantity"> {{ errors . product_quantity[0] }}
                                                </small>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="form-group">

                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <input type="file" class="custom-file-input" id="customFile" @change="onFileSelected">

                                                <small class="text-danger" v-if="errors.product_image">
                                                    {{ errors . product_image[0] }} </small>
                                                <label class="custom-file-label" for="customFile">Choose
                                                    file</label>
                                            </div>

                                            <div class="col-md-6">
                                                <img :src="form.product_image" style="height: 40px; width: 40px;">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block">Update Product</button>
                                    </div>

                                </form>
                                <hr>
                                <div class="text-center">

                                </div>
                                <div class="text-center">
                                </div>
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
            form: {
                product_name: '',
                product_code: '',
                category_id: '',
                supplier_id: '',
                root: '',
                buying_price: '',
                selling_price: '',
                buying_date: '',
                product_quantity: '',
                product_image: '',
                new_product_image: '',
            },
            errors: {},
            categories: {},
            suppliers: {},
        }
    },

    created() {
        let id = this.$route.params.id
        axios.get('/api/product/' + id)
            .then(({
                data
            }) => (this.form = data))
            .catch(console.log('error'))
    },

    methods: {
        onFileSelected(event) {
            let file = event.target.files[0];
            if (file.size > 1048770) {
                Notification.image_validation()
            } else {
                let reader = new FileReader();
                reader.onload = event => {
                    this.form.new_product_image = event.target.result

                };
                reader.readAsDataURL(file);
            }

        },
        productUpdate() {
            let id = this.$route.params.id
            axios.patch('/api/product/' + id, this.form)
                .then(() => {
                    this.$router.push({
                        name: 'product'
                    })
                    Notification.success()
                })
                .catch(error => this.errors = error.response.data.errors)

        },
    },

    mounted() {
        axios.get('/api/category')
            .then(({
                data
            }) => (this.categories = data))

        axios.get('/api/supplier')
            .then(({
                data
            }) => (this.suppliers = data))
    }

}
</script>

<style type="text/css">

</style>
