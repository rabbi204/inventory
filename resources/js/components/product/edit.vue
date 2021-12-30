<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <router-link to="/product" class="btn btn-primary btn-sm">All Product</router-link>
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12 mx-auto">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Product Update</h1>
                                    </div>
                                    <form class="user" @submit.prevent="productUpdate" enctype="multipart/form-data">

                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <label for="productName">Product Name</label>
                                                     <input type="text" class="form-control" id="productName" v-model="form.product_name"  placeholder="Enter Your Product Name" required />
                                                     <small class="text-danger" v-if="errors.product_name">{{ errors.product_name[0] }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="productCode">Product Code</label>
                                                     <input type="text" class="form-control" id="productCode" v-model="form.product_code"  placeholder="Enter Your Product Code" required />
                                                     <small class="text-danger" v-if="errors.product_code">{{ errors.product_code[0] }}</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                     <label for="productCategory">Product Category</label>
                                                    <select class="form-control" v-model="form.category_id" id="productCategory">
                                                        <option v-for="category in categories" :value="category.id" :key="category.id">{{ category.category_name }}</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                     <label for="productSupplier">Product Supplier</label>
                                                    <select class="form-control" v-model="form.supplier_id" id="productSupplier">
                                                        <option v-for="supplier in suppliers" :value="supplier.id" :key="supplier.id">{{ supplier.name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-4">
                                                    <label for="productRoot">Product Root</label>
                                                     <input type="text" class="form-control" id="productRoot" v-model="form.root"  required />
                                                     <small class="text-danger" v-if="errors.root">{{ errors.root[0] }}</small>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="productBuyingPrice">Product Buying Price</label>
                                                     <input type="text" class="form-control" id="productBuyingPrice" v-model="form.buying_price" required />
                                                     <small class="text-danger" v-if="errors.buying_price">{{ errors.buying_price[0] }}</small>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="productSellingPrice">Product Selling Price</label>
                                                     <input type="text" class="form-control" id="productSellingPrice" v-model="form.selling_price" required />
                                                     <small class="text-danger" v-if="errors.selling_price">{{ errors.selling_price[0] }}</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <label for="productBuyingDate">Product Buying Date</label>
                                                     <input type="date" class="form-control" id="productBuyingDate" v-model="form.buying_date" required />
                                                     <small class="text-danger" v-if="errors.buying_date">{{ errors.buying_date[0] }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="productQuantity">Product Quantity</label>
                                                     <input type="text" class="form-control" id="productQuantity" v-model="form.product_quantity" required />
                                                     <small class="text-danger" v-if="errors.product_quantity">{{ errors.product_quantity[0] }}</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <input type="file" class="custom-file-input" id="customFile" @change="onFileSelected">
                                                    <small class="text-danger" v-if="errors.image">{{ errors.image[0] }}</small>
                                                    <label class="custom-file-label" for="customFile">Product Image</label>
                                                </div>
                                                <div class="col-md-6"  v-if="form.newimage">
                                                     <img :src="form.newimage" style="height: 40px; width: 40px;" alt="">
                                                </div>
                                                <div class="col-md-6" v-else>
                                                     <img :src="'/' + form.image" style="height: 40px; width: 40px;" alt="">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    created(){
        if(!User.loggedIn()){
            this.$router.push({name: '/'});
        }
    },
    data(){
        return {
            form: {
                product_name: '',
                product_code: '',
                category_id: '',
                supplier_id: '',
                root: '',
                buying_price: '',
                selling_price: '',
                product_quantity: '',
                image: '',
                newimage: ''
            },
            errors:{},
            categories: {},
            suppliers: {},
        }
    },
    created(){
        let id = this.$route.params.id;
        axios.get('/api/product/' + id)
        .then( ({data}) => (this.form = data) )
        .catch(console.log('error'))

        //category collected
        axios.get('/api/category/')
       .then( ({data}) => (this.categories = data) ) 
        //supplier collected
       axios.get('/api/supplier/')
       .then( ({data}) => (this.suppliers = data) )
    },
    methods:{
        onFileSelected(event){
            let file = event.target.files[0]; 
            if(file.size > 1048770){
                Notification.image_validation();
            }else{
                let reader = new FileReader();
                reader.onload = event => {
                    this.form.newimage = event.target.result;
                    this.form.image = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
        productUpdate(){
            let id = this.$route.params.id;
            axios.patch('/api/product/' + id, this.form)
            .then(() => {
                this.$router.push({name: 'product'});
                Notification.success();
            })
            .catch(error => this.errors = error.response.data.errors)
        },
    }
    
}
</script>

<style scoped>

</style>