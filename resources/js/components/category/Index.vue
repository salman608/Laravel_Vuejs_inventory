<template >
    <div>
        <div class="row">
            <div class="col-lg-12 mb-4">
                <router-link to="/store-category" class="btn btn-warning">Add Category</router-link>
                <br>
                <br>
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">All Category</h6>
                  <input type="text" v-model="searchTerm" class="form-controll" placeholder="Search Here....">


                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Category Name</th>
                        <th>Time</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="category in filtersearch" :key="category.id">
                        <td>{{ category.category_name }}</td>
                        <td>{{ category.created_at }}</td>
                        <td>
                            <router-link :to="{name:'edit-category', params:{id:category.id}}" class="btn btn-sm btn-info">Edit</router-link>
                            <a @click="deleteCategory(category.id)" class="btn btn-sm btn-danger text-white">Delete</a>
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
        categories:[],
        searchTerm:''
       }
    },

    computed:{
        filtersearch(){
            return this.categories.filter(category =>{
                return category.category_name.match(this.searchTerm)

            })
        }
    },

    mounted(){
        this.allCategory();
    },

    methods:{
        allCategory(){
        axios.get('/api/category/')
        .then(({data}) => (this.categories = data))
        .catch()
        },

        deleteCategory(id){
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

                axios.delete('/api/category/'+id)
                .then(()=>{
                    this.categories=this.categories.filter(category=>{
                        return category.id != id
                    })
                })
                .catch(() =>{
                    this.$router.push({name:'category'})
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
