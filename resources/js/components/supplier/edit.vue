<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <router-link to="/supplier" class="btn btn-primary btn-sm">All Suppliers</router-link>
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12 mx-auto">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Supplier Update</h1>
                                    </div>
                                    <form class="user" @submit.prevent="supplierUpdate" enctype="multipart/form-data">

                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                     <input type="text" class="form-control" v-model="form.name"  placeholder="Enter Your Full Name" required />
                                                     <small class="text-danger" v-if="errors.name">{{ errors.name[0] }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                     <input type="email" class="form-control" v-model="form.email"  placeholder="Enter Your Email" required />
                                                     <small class="text-danger" v-if="errors.email">{{ errors.email[0] }}</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                     <input type="text" class="form-control" v-model="form.address"  placeholder="Enter Your Address" required />
                                                     <small class="text-danger" v-if="errors.address">{{ errors.address[0] }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                     <input type="text" class="form-control" v-model="form.shopname"  placeholder="Enter Your Salary" required />
                                                     <small class="text-danger" v-if="errors.shopname">{{ errors.shopname[0] }}</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                     <input type="phone" class="form-control" v-model="form.phone"  placeholder="Enter Your Number" required />
                                                     <small class="text-danger" v-if="errors.phone">{{ errors.phone[0] }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                     
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <input type="file" class="custom-file-input" id="customFile" @change="onFileSelected">
                                                    <small class="text-danger" v-if="errors.photo">{{ errors.photo[0] }}</small>
                                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                                </div>
                                                <div class="col-md-6"  v-if="form.newphoto">
                                                     <img :src="form.newphoto" style="height: 40px; width: 40px;" alt="">
                                                </div>
                                                <div class="col-md-6" v-else>
                                                     <img :src="'/' + form.photo" style="height: 40px; width: 40px;" alt="">
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
                name: '',
                email: '',
                phone: '',
                shopname: '',
                address: '',
                photo: '',
                newphoto: '',
            },
            errors:{}
        }
    },
    created(){
        let id = this.$route.params.id;
        axios.get('/api/supplier/' + id)
        .then( ({data}) => (this.form = data) )
        .catch(console.log('error'))
    },
    methods:{
        onFileSelected(event){
            let file = event.target.files[0]; 
            if(file.size > 1048770){
                Notification.image_validation();
            }else{
                let reader = new FileReader();
                reader.onload = event => {
                    this.form.newphoto = event.target.result;
                    this.form.photo = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
        supplierUpdate(){
            let id = this.$route.params.id;
            axios.patch('/api/supplier/' + id, this.form)
            .then(() => {
                this.$router.push({name: 'supplier'});
                Notification.success();
            })
            .catch(error => this.errors = error.response.data.errors)
        },
    }
    
}
</script>

<style scoped>

</style>