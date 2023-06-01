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
                                    <h6 class="m-0 font-weight-bold text-primary">Expense Update</h6>
                                    <router-link to="/expense" class="btn btn-success">All Expense </router-link>
                                    </div>

                                    <form class="user" @submit.prevent="expenseUpdate" >

                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <label for="exampleFormControlTextarea1">Expense Details</label>
                                                    <textarea class="form-control" id="exampleFormControlTextarea1" v-model="form.details" rows="3"></textarea>
                                                    <small class="text-danger" v-if="errors.details"> {{ errors . details[0] }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <label for="exampleFormControlTextarea1">Expense Amount</label>
                                                    <input type="text" class="form-control"
                                                        id="exampleInputFirstName" placeholder="Enter Amount"
                                                        v-model="form.amount">
                                                    <small class="text-danger" v-if="errors.amount"> {{ errors . amount[0] }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Expense Update</button>
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
                    details: '',
                    amount: '',

                },
                errors: {}
            }
        },

        created(){
           let id =this.$route.params.id
           axios.get('/api/expense/'+id)
           .then(({data})=>(this.form=data))
            .catch(console.log('error'))
        },

        methods: {

            expenseUpdate(){
                let id = this.$route.params.id
                axios.patch('/api/expense/'+id,this.form)
                .then(() => {
                    this.$router.push({ name: 'expense'})
                    Notification.success()
                })
                .catch(error =>this.errors = error.response.data.errors)

                },
        }


    }
</script>


<style type="text/css">

</style>
