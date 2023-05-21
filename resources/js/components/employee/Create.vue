<template >
    <div>
      <div class="row justify-content-center">
        <div class="col-xl-12 col-lg-12 col-md-12">
          <div class="card shadow-sm ">
            <div class="card-body p-0">
              <div class="row">
                <div class="col-lg-12">
                  <div class="login-form">
                    <div class="text-center">
                      <h1 class="h4 text-gray-900 mb-4">Add Employee</h1>
                    </div>
                    <form class="user" @submit.prevent="signup">
                      <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="exampleInputFirstName"
                                  placeholder="Enter Your Name" v-model="form.name">
                            </div>
                            <div class="col-md-6">
                                <input type="email" class="form-control" id="exampleInputFirstName"
                                  placeholder="Enter Your Email" v-model="form.email">
                            </div>
                        </div>

                      </div>

                      <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="exampleInputFirstName"
                                  placeholder="Enter Address" v-model="form.address">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="exampleInputFirstName"
                                  placeholder="Enter Sallery" v-model="form.sallery">
                            </div>
                        </div>

                      </div>

                      <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <input type="date" class="form-control" id="exampleInputFirstName"
                                  placeholder="Enter Joining Date" v-model="form.joining_date">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="exampleInputFirstName"
                                  placeholder="Enter Your Nid Number" v-model="form.nid">
                            </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="exampleInputFirstName"
                                  placeholder="Enter Phone Number" v-model="form.phone">
                            </div>
                            <div class="col-md-6">

                            </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <input type="file" class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                            <div class="col-md-6">
                               <img src="form.photo" style="height:40px; width:40px;">
                            </div>
                        </div>
                      </div>


                      <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                      </div>

                    </form>
                    <hr>


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
        this.$router.push({ name: '/' })
      }
    },
    data() {
      return {
        form: {
          name:null,
          email: null,
          password: null,
          confirm_password:null

        },
        errors:{}
      }
    },

  }
  </script>

