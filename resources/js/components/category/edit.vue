<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-8 col-md-8">
                <router-link to="/category" class="btn btn-primary btn-sm">All Category</router-link>
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-8 mx-auto">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Category Update</h1>
                                    </div>
                                    <form class="user" @submit.prevent="categoryUpdate">

                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                     <input type="text" class="form-control" v-model="form.category_name"  placeholder="Update category name" required />
                                                     <small class="text-danger" v-if="errors.category_name">{{ errors.category_name[0] }}</small>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- <div class="form-group">
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
                                        </div> -->


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
                category_name: '',
                // photo: '',
                // newphoto: '',
            },
            errors:{}
        }
    },
    created(){
        let id = this.$route.params.id;
        axios.get('/api/category/' + id)
        .then( ({data}) => (this.form = data) )
        .catch(console.log('error'))
    },
    methods:{
        // onFileSelected(event){
        //     let file = event.target.files[0]; 
        //     if(file.size > 1048770){
        //         Notification.image_validation();
        //     }else{
        //         let reader = new FileReader();
        //         reader.onload = event => {
        //             this.form.newphoto = event.target.result;
        //             this.form.photo = event.target.result;
        //         };
        //         reader.readAsDataURL(file);
        //     }
        // },
        categoryUpdate(){
            let id = this.$route.params.id;
            axios.patch('/api/category/' + id, this.form)
            .then(() => {
                this.$router.push({name: 'category'});
                Notification.success();
            })
            .catch(error => this.errors = error.response.data.errors)
        },
    }
    
}
</script>

<style scoped>

</style>