<template>
    <div>
        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">POS Dashboard</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="./">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">POS</li>
                </ol>
            </div>

            <div class="row mb-3">
                <!-- Area Chart -->
                <div class="col-xl-5 col-lg-5">
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Expense Insert</h6>
                            <a class="btn btn-sm btn-info text-white">Add Customer</a>
                        </div>
                         <div class="table-responsive" style="font-size:14px">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Qty</th>
                                        <th>Unit</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><a href="#">Name</a></td>
                                        <td>qty</td>
                                        <td>unit</td>
                                        <td>total</td>
                                        <td><a href="#" class="btn btn-sm btn-primary">X</a></td>
                                    </tr>
                                    <tr>
                                        <td><a href="#">Name</a></td>
                                        <td>qty</td>
                                        <td>unit</td>
                                        <td>total</td>
                                        <td><a href="#" class="btn btn-sm btn-primary">X</a></td>
                                    </tr>
                                    <tr>
                                        <td><a href="#">Name</a></td>
                                        <td>qty</td>
                                        <td>unit</td>
                                        <td>total</td>
                                        <td><a href="#" class="btn btn-sm btn-primary">X</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Total Quantity: <strong>56</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Sub Total: <strong>566 $</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    VAT: <strong>3 %</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Total Amount: <strong>6006 $</strong>
                                </li>
                            </ul>
                            <br>
                            <form action="">
                                <div class="form-group">
                                    <label for="">Customer Name</label>
                                    <select class="form-control" v-model="customer_id" id="">
                                        <option value="">Kazi</option>
                                        <option value="">Ariyan</option>
                                        <option value="">Rohan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Pay</label>
                                    <input type="text" class="form-control" v-model="pay" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Due</label>
                                    <input type="text" class="form-control" v-model="due" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Pay By</label>
                                    <select class="form-control" v-model="customer_id" id="">
                                        <option value="HandCash">Hand Cash</option>
                                        <option value="Cheque">Cheque</option>
                                        <option value="GiftCard">Gift Card</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-sm btn-success">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Pie Chart -->
                <div class="col-xl-7 col-lg-7">
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Products Sold</h6>
                        </div>
                        <!-- category wise product -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">All Product</button>
                            </li>
                            <li class="nav-item" role="presentation" v-for="category in categories" :key="category.id">
                                <button @click="subProduct(category.id)" class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">
                                    {{ category.category_name }}
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="card-body">
                                    <input type="text" v-model="searchTerm" class="form-control col-md-12 mb-2" placeholder="search product by name">
                                    <div class="row">
                                        <div v-for="product in filterSearch" :key="product.id" class="col-lg-3 col-md-3 col-sm-6 col-6">
                                            <a href="#">
                                                <div class="card" style="width: 8.5rem; margin-botom: 5px;">
                                                    <img :src="product.image" class="card-img-top" id="em_photo">
                                                    <div class="card-body">
                                                        <h6 class="card-title">{{ product.product_name }}</h6>
                                                        <span class="badge badge-success" v-if="product.product_quantity >= 1">Available {{ product.product_quantity }}</span>
                                                        <span class="badge badge-danger" v-else>Stock Out</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- End tabs Home -->
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="card-body">
                                    <input type="text" v-model="getSearchTerm" class="form-control col-md-12 mb-2" placeholder="search product by name">
                                    <div class="row">
                                        <div v-for="getproduct in getFilterSearch" :key="getproduct.id" class="col-lg-3 col-md-3 col-sm-6 col-6">
                                            <a href="#">
                                                <div class="card" style="width: 8.5rem; margin-botom: 5px;">
                                                    <img :src="getproduct.image" class="card-img-top" id="em_photo">
                                                    <div class="card-body">
                                                        <h6 class="card-title">{{ getproduct.product_name }}</h6>
                                                        <span class="badge badge-success" v-if="getproduct.product_quantity >= 1">Available {{ getproduct.product_quantity }}</span>
                                                        <span class="badge badge-danger" v-else>Stock Out</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End category wise product -->
                    </div>
                </div>
            </div>
            <!--Row-->
        </div>
        <!---Container Fluid-->

    </div>
</template>

<script>
export default {
    created(){
        if(!User.loggedIn()){
            this.$router.push({name: '/'});
        }
    },
    created(){
        this.allProduct();
        this.allCategory();
    },
    data(){
        return{
            products:[],
            categories:'',
            getproducts: [],
            searchTerm: '',
            getSearchTerm: '',
        }
    },

    computed:{
        filterSearch(){
            return this.products.filter(product => {
                return product.product_name.match(this.searchTerm);
            });
        },
        getFilterSearch(){
            return this.getproducts.filter(getproduct => {
                return getproduct.product_name.match(this.getSearchTerm);
            });
        }
    },
    
    methods:{
        allProduct(){
            axios.get('/api/product/')
            .then( ({data}) => (this.products = data))
            .catch()
        },

        allCategory(){
            axios.get('/api/category/')
            .then( ({data}) => (this.categories = data))
            .catch()
        },
        subProduct(id){
            axios.get('/api/getting/product/' + id)
            .then( ({data}) => (this.getproducts = data))
            .catch()
        }

    }
    
}
</script>

<style scoped>
    #em_photo{
        height: 90px;
        width: 100%;
        object-fit: cover;
    }
</style>