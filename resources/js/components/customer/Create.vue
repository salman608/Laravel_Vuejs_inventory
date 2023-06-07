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
                                    <h6 class="m-0 font-weight-bold text-primary">Customer Add</h6>
                                    <router-link to="/customer" class="btn btn-primary">All Customer </router-link>

                                    </div>

                                    <form class="user" @submit.prevent="CustomerInsert" enctype="multipart/form-data">

                                        <div class="form-group">

                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <label for="">Customer Name</label>
                                                    <input type="text" class="form-control"
                                                        id="exampleInputFirstName" placeholder="Enter Your Full Name"
                                                        v-model="form.customer_name">
                                                    <small class="text-danger" v-if="errors.customer_name"> {{ errors . customer_name[0] }}
                                                    </small>
                                                </div>


                                                <div class="col-md-6">
                                                    <label for="">Customer Email</label>
                                                    <input type="email" class="form-control"
                                                        id="exampleInputFirstName" placeholder="Enter Your Email"
                                                        v-model="form.customer_email">
                                                    <small class="text-danger" v-if="errors.customer_email">
                                                        {{ errors . customer_email[0] }} </small>
                                                </div>

                                            </div>
                                        </div>


                                        <div class="form-group">

                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <label for="">Customer Phone</label>
                                                    <input type="text" class="form-control"
                                                        id="exampleInputFirstName" placeholder="Enter Your phone Number"
                                                        v-model="form.customer_phone">
                                                    <small class="text-danger" v-if="errors.customer_phone">
                                                        {{ errors . customer_phone[0] }} </small>

                                                </div>

                                                <div class="col-md-6">
                                                    <label for="">Customer Address</label>
                                                    <input type="text" class="form-control"
                                                        id="exampleInputFirstName" placeholder="Enter Your Address"
                                                        v-model="form.customer_address">
                                                    <small class="text-danger" v-if="errors.customer_address">
                                                        {{ errors . customer_address[0] }} </small>
                                                </div>


                                            </div>
                                        </div>


                                        <div class="form-group">

                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <label for="">Customer Photo</label>
                                                    <input type="file" class="custom-file-input" id="customFile"
                                                        @change="onFileSelected">

                                                    <small class="text-danger" v-if="errors.customer_photo">
                                                        {{ errors . customer_photo[0] }} </small>
                                                    <label class="custom-file-label" for="customFile">Choose
                                                        file</label>
                                                </div>


                                                <div class="col-md-6">
                                                    <img :src="form.customer_photo" style="height: 40px; width: 40px;">
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</template>



<script type="text/javascript">
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
                    customer_name: null,
                    customer_email: null,
                    customer_phone: null,
                    customer_address: null,
                    customer_photo: null,
                },
                errors: {}
            }
        },

        methods: {
            onFileSelected(event) {
                let file = event.target.files[0];
                if (file.size > 1048770) {
                    Notification.image_validation()
                } else {
                    let reader = new FileReader();
                    reader.onload = event => {
                        this.form.customer_photo = event.target.result
                        console.log(event.target.result);
                    };
                    reader.readAsDataURL(file);
                }

            },
            CustomerInsert() {
                axios.post('/api/customer', this.form)
                    .then(() => {
                        this.$router.push({
                            name: 'customer'
                        })
                        Notification.success()
                    })
                    .catch(error => this.errors = error.response.data.errors)
            },
        }


    }
</script>


<style type="text/css">

</style>
