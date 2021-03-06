
let login = require('./components/auth/login.vue').default;
let register = require('./components/auth/register.vue').default;
let forget = require('./components/auth/forget.vue').default;
let logout = require('./components/auth/logout.vue').default;
//End Authentication
let home = require('./components/home.vue').default;
// Employee Component
let storeemployee = require('./components/employee/create.vue').default;
let employee = require('./components/employee/index.vue').default;
let editemployee = require('./components/employee/edit.vue').default;

// Supplier Component
let storesupplier = require('./components/supplier/create.vue').default;
let supplier = require('./components/supplier/index.vue').default;
let editsupplier = require('./components/supplier/edit.vue').default;

// Category Component
let storecategory = require('./components/category/create.vue').default;
let category = require('./components/category/index.vue').default;
let editcategory = require('./components/category/edit.vue').default;

// product component
let storeproduct = require('./components/product/create.vue').default;
let product = require('./components/product/index.vue').default;
let editproduct = require('./components/product/edit.vue').default;

// Expense component
let storeexpense = require('./components/expense/create.vue').default;
let expense = require('./components/expense/expense.vue').default;
let editexpense = require('./components/expense/edit.vue').default;

// Salary component
let salary = require('./components/salary/all_employee.vue').default;
let paySalary = require('./components/salary/create.vue').default;
let allSalary = require('./components/salary/index.vue').default;
let viewSalary = require('./components/salary/view.vue').default;
let editSalary = require('./components/salary/edit.vue').default;

//stock component
let stock = require('./components/product/stock.vue').default;
let editStock = require('./components/product/edit-stock.vue').default;

// Employee Component
let storeCustomer = require('./components/customer/create.vue').default;
let customer = require('./components/customer/index.vue').default;
let editCustomer = require('./components/customer/edit.vue').default;

// Pos component
let pos = require('./components/pos/pointofsale.vue').default;

export const routes = [
    { path: '/', component: login, name: '/' },
    { path: '/register', component: register, name:'register' },
    { path: '/forget', component: forget, name:'forget' },
    { path: '/logout', component: logout, name:'logout' },
    { path: '/home', component: home, name:'home' },
    // All employee route
    { path: '/store-employee', component: storeemployee, name:'store-employee' },
    { path: '/employee', component: employee, name:'employee' },
    { path: '/edit-employee/:id', component: editemployee, name:'edit-employee' },
    // all supplier route
    { path: '/store-supplier', component: storesupplier, name: 'store-supplier' },
    { path: '/supplier', component: supplier, name: 'supplier' },
    { path: '/edit-supplier/:id', component: editsupplier, name: 'edit-supplier' },
    // all category route
    { path: '/store-category' , component: storecategory, name: 'store-category' },
    { path: '/category' , component: category, name: 'category' },
    { path: '/category-edit/:id' , component: editcategory, name: 'edit-category' },
    // all Product route
    { path: '/store-product' , component: storeproduct, name: 'store-product' },
    { path: '/product' , component: product, name: 'product' },
    { path: '/product-edit/:id' , component: editproduct, name: 'edit-product' },
    // all expense route
    { path: '/store-expense' , component: storeexpense, name: 'store-expense' },
    { path: '/expense' , component: expense, name: 'expense' },
    { path: '/expense-edit/:id' , component: editexpense, name: 'edit-expense' },
      
    // all salary route
    { path: '/given-salary' , component: salary, name: 'given-salary' },
    { path: '/pay-salary/:id' , component: paySalary, name: 'pay-salary' },
    { path: '/salary' , component: allSalary, name: 'salary' },
    { path: '/view-salary/:id' , component: viewSalary, name: 'view-salary' },
    { path: '/edit-salary/:id' , component: editSalary, name: 'edit-salary' },
    
    // stock route
    { path: '/stock' , component: stock, name: 'stock' },    
    { path: '/edit-stock/:id' , component: editStock, name: 'edit-stock' },    

    // Customer Route
    { path: '/store-customer', component: storeCustomer, name:'store-customer' },
    { path: '/customer', component: customer, name:'customer' },
    { path: '/edit-customer/:id', component: editCustomer, name:'edit-customer' },

    // POS Route
    { path: '/pos', component: pos, name:'pos' },

]