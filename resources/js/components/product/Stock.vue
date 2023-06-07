<template >
    <div>
        <div class="row">
            <div class="col-lg-12 mb-4">

              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Stock List</h6>
                  <input type="text" v-model="searchTerm" class="form-controll" placeholder="Search Here....">


                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Photo</th>
                        <th>Category</th>
                        <th>Buying Price</th>
                        <th>Status</th>
                        <th>Quantity</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="product in filtersearch" :key="product.id">
                        <td>{{ product.product_name }}</td>
                        <td>{{ product.product_code }}</td>
                        <td><img :src="product.product_image" alt="" id="em_photo"></td>
                        <td>{{ product.category_name }}</td>
                        <td>৳ {{ product.buying_price }}</td>
                        <td v-if="product.product_quantity >= 1">
                           <span class="badge badge-success">Available</span>
                        </td>
                        <td v-else>
                           <span class="badge badge-warning">Stock Out</span>
                        </td>
                        <td>{{ product.product_quantity }}</td>
                        <td>
                            <router-link :to="{name:'edit-stock', params:{id:product.id}}" class="btn btn-sm btn-info">Edit</router-link>

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
        products:[],
        searchTerm:''
       }
    },

    computed:{
        filtersearch(){
            return this.products.filter(product =>{
                return product.product_code.match(this.searchTerm)

            })
        }
    },

    mounted(){
        this.allProduct();
    },

    methods:{
        allProduct(){
        axios.get('/api/product/')
        .then(({data}) => (this.products = data))
        .catch()
        },

    },


  }
  </script>

<style scoped>
#em_photo{
    height: 40px;
    width: 50px;
}
</style>
