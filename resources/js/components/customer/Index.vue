<template >
    <div>
        <div class="row">
            <div class="col-lg-12 mb-4">
                <router-link to="/store-customer" class="btn btn-warning">Add Customer</router-link>
                <br>
                <br>
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Customer List</h6>
                  <input type="text" v-model="searchTerm" class="form-controll" placeholder="Search Here....">


                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Customer Name</th>
                        <th>Customer Photo</th>
                        <th>Customer Email</th>
                        <th>Customer Phone</th>
                        <th>Customer Address</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="customer in filtersearch" :key="customer.id">
                        <td>{{ customer.customer_name }}</td>
                        <td><img :src="customer.customer_photo" alt="" id="em_photo"></td>
                        <td>{{ customer.customer_email }}</td>
                        <td>{{ customer.customer_phone }}</td>
                        <td>{{ customer.customer_address }}</td>
                        <td>
                            <router-link :to="{name:'edit-customer', params:{id:customer.id}}" class="btn btn-sm btn-info">Edit</router-link>
                            <a @click="deleteCustomer(customer.id)" class="btn btn-sm btn-danger text-white">Delete</a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="card-footer"></div>
              </div>
            </div>
          </div>
     </div>
  </template>

  <script type="text/javascript">
  export default {
    created() {
      if (!User.loggedIn()) {
        this.$router.push({ name: '/' })
      }
    },

    data(){
       return{
        customers:[],
        searchTerm:''
       }
    },

    computed:{
        filtersearch(){
            return this.customers.filter(customer =>{
                return customer.customer_phone.match(this.searchTerm)

            })
        }
    },

    mounted(){
        this.allCustomer();
    },

    methods:{
        allCustomer(){
        axios.get('/api/customer/')
        .then(({data}) => (this.customers = data))
        .catch()
        },

        deleteCustomer(id){
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {

                axios.delete('/api/customer/'+id)
                .then(()=>{
                    this.customers=this.customers.filter(customer=>{
                        return customer.id != id
                    })
                })
                .catch(() =>{
                    this.$router.push({name:'customer'})
                })

                Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
                )
            }
        })
      }
    },


  }
  </script>

<style scoped>
#em_photo{
    height: 40px;
    width: 50px;
}
</style>
