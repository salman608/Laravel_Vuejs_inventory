
let Login=require('./components/auth/Login.vue').default;
let Register=require('./components/auth/Register.vue').default;
let Forget=require('./components/auth/Forget.vue').default;
let Logout=require('./components/auth/Logout.vue').default;

let home=require('./components/home.vue').default;

//Employee Routes
let storeemployee=require('./components/employee/Create.vue').default;
let employee=require('./components/employee/Index.vue').default;
let editemployee=require('./components/employee/Edit.vue').default;

//Supplier Routes
let storesupplier=require('./components/supplier/Create.vue').default;
let supplier=require('./components/supplier/Index.vue').default;
let editsupplier=require('./components/supplier/Edit.vue').default;

//category Routes
let storecategory=require('./components/category/Create.vue').default;
let category=require('./components/category/Index.vue').default;
let editcategory=require('./components/category/Edit.vue').default;




export const routes = [
  { path: '/', component: Login, name:'/' },
  { path: '/register', component: Register , name:'/register' },
  { path: '/forget', component: Forget , name:'/forget' },
  { path: '/logout', component: Logout , name:'/logout' },
  { path: '/home', component: home , name:'home' },

  //Employee Route
  { path: '/store-employee', component: storeemployee , name:'store-employee' },
  { path: '/employee', component: employee , name:'employee' },
  { path: '/edit-employee/:id', component: editemployee , name:'edit-employee' },

  //Supplier Route
  { path: '/store-supplier', component: storesupplier , name:'store-supplier' },
  { path: '/supplier', component: supplier , name:'supplier' },
  { path: '/edit-supplier/:id', component: editsupplier , name:'edit-supplier' },

  //Category Route
  { path: '/store-category', component: storecategory , name:'store-category' },
  { path: '/category', component: category , name:'category' },
  { path: '/edit-category/:id', component: editcategory , name:'edit-category' }
]
