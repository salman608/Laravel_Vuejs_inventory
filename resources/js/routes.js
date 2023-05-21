
let Login=require('./components/auth/Login.vue').default;
let Register=require('./components/auth/Register.vue').default;
let Forget=require('./components/auth/Forget.vue').default;
let Logout=require('./components/auth/Logout.vue').default;

let home=require('./components/home.vue').default;
//employee
let storeemployee=require('./components/employee/Create.vue').default;

export const routes = [
  { path: '/', component: Login, name:'/' },
  { path: '/register', component: Register , name:'/register' },
  { path: '/forget', component: Forget , name:'/forget' },
  { path: '/logout', component: Logout , name:'/logout' },
  { path: '/home', component: home , name:'home' },
  //employee
  { path: '/store-employee', component: storeemployee , name:'store-employee' }
]
