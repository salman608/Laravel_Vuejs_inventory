<template >
    <div>
        <div class="row">
            <div class="col-lg-12 mb-4">
                <router-link to="/salary" class="btn btn-warning">Go Back</router-link>
                <br>
                <br>
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Employee Salary Details</h6>
                  <input type="text" v-model="searchTerm" class="form-controll" placeholder="Search Here....">
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Name</th>
                        <th>Month</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="salary in filtersearch" :key="salary.id">
                        <td>{{ salary.name }}</td>
                        <td>{{ salary.salary_month }}</td>
                        <td>{{ salary.amount }}</td>
                        <td>{{ salary.salary_date }}</td>
                        <td>
                            <router-link :to="{name:'edit-salary', params:{id:salary.id}}" class="btn btn-sm btn-info">Edit Salary</router-link>

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
        salaries:[],
        searchTerm:''
       }
    },

    computed:{
        filtersearch(){
            return this.salaries.filter(salary =>{
                return salary.name.match(this.searchTerm)

            })
        }
    },

    mounted(){
        this.viewSalary();
    },

    methods:{
        viewSalary(){
            let id = this.$route.params.id
            axios.get('/api/salary/view/'+id)
            .then(({data}) => (this.salaries = data))
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
