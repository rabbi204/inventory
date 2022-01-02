<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <router-link to="/customer" class="btn btn-primary btn-sm">All Customer</router-link>
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12 mx-auto">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Customer Update</h1>
                                    </div>
                                    <form class="user" @submit.prevent="customerUpdate" enctype="multipart/form-data">

                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <label for="cusotmerName"><b>Enter Your Name</b></label>
                                                     <input type="text" class="form-control" v-model="form.name" id="cusotmerName" required />
                                                     <small class="text-danger" v-if="errors.name">{{ errors.name[0] }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="cusotmerEmail"><b>Enter Your Email</b></label>
                                                     <input type="email" class="form-control" v-model="form.email" id="cusotmerEmail" required />
                                                     <small class="text-danger" v-if="errors.email">{{ errors.email[0] }}</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                     <label for="cusotmerPhone"><b>Enter Your Phone Number</b></label>
                                                     <input type="text" class="form-control" v-model="form.phone" id="cusotmerPhone" required />
                                                     <small class="text-danger" v-if="errors.phone">{{ errors.phone[0] }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="cusotmerAddress"><b>Enter Your Address</b></label>
                                                     <input type="text" class="form-control" v-model="form.address" id="cusotmerAddress" required />
                                                     <small class="text-danger" v-if="errors.address">{{ errors.address[0] }}</small>
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
                address: '',
                photo: '',
                newphoto: ''
            },
            errors:{}
        }
    },
    created(){
        let id = this.$route.params.id;
        axios.get('/api/customer/' + id)
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
        customerUpdate(){
            let id = this.$route.params.id;
            axios.patch('/api/customer/' + id, this.form)
            .then(() => {
                this.$router.push({name: 'customer'});
                Notification.success();
            })
            .catch(error => this.errors = error.response.data.errors)
        },
    }
    
}
</script>

<style scoped>

</style>