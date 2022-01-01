<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <router-link to="/stock" class="btn btn-primary btn-sm">Go Back</router-link>
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12 mx-auto">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Stock Update</h1>
                                    </div>
                                    <form class="user" @submit.prevent="stockUpdate">

                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <label for="productStock">Product Stock</label>
                                                     <input type="text" class="form-control" id="productStock" v-model="form.product_quantity"  placeholder="Enter Your Product Name" required />
                                                     <small class="text-danger" v-if="errors.product_quantity">{{ errors.product_quantity[0] }}</small>
                                                </div>
                                                <div class="col-md-6">
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
                product_quantity: ''
            },
            errors:{},
        }
    },
    created(){
        let id = this.$route.params.id;
        axios.get('/api/product/' + id)
        .then( ({data}) => (this.form = data) )
        .catch(console.log('error'))
    },
    methods:{
        stockUpdate(){
            let id = this.$route.params.id;
            axios.post('/api/stock/update/' + id, this.form)
            .then(() => {
                this.$router.push({name: 'stock'});
                Notification.success();
            })
            .catch(error => this.errors = error.response.data.errors)
        },
    }
    
}
</script>

<style scoped>

</style>