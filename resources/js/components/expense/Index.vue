<template >
    <div>
        <div class="row">
            <div class="col-lg-12 mb-4">
                <router-link to="/store-expense" class="btn btn-warning">Add Expense</router-link>
                <br>
                <br>
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">All Expense</h6>
                  <input type="date" v-model="searchTerm" class="form-controll" placeholder="Search Here....">


                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Expense Details</th>
                        <th>Expense Amount</th>
                        <th>Expense date</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="expense in filtersearch" :key="expense.id">
                        <td>{{ expense.details }}</td>
                        <td>{{ expense.amount }}</td>
                        <td>{{ expense.expense_date }}</td>
                        <td>
                            <router-link :to="{name:'edit-expense', params:{id:expense.id}}" class="btn btn-sm btn-info">Edit</router-link>
                            <a @click="deleteExpense(expense.id)" class="btn btn-sm btn-danger text-white">Delete</a>
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
        expenses:[],
        searchTerm:''
       }
    },

    computed:{
        filtersearch(){
            return this.expenses.filter(expense =>{
                return expense.expense_date.match(this.searchTerm)

            })
        }
    },

    mounted(){
        this.allExpense();
    },

    methods:{
        allExpense(){
        axios.get('/api/expense/')
        .then(({data}) => (this.expenses = data))
        .catch()
        },

        deleteExpense(id){
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

                axios.delete('/api/expense/'+id)
                .then(()=>{
                    this.expenses=this.expenses.filter(expense=>{
                        return expense.id != id
                    })
                })
                .catch(() =>{
                    this.$router.push({name:'expense'})
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
