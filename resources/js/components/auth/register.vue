<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-8 mx-auto">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Register</h1>
                                    </div>
                                    <form class="user" @submit.prevent="signup">
                                        <div class="form-group">
                                            <input type="text" class="form-control" v-model="form.name"  placeholder="Enter Your Full Name" required />
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control" v-model="form.email" placeholder="Enter Email Address" required />
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" v-model="form.password" placeholder="Password" required />
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" v-model="form.password_confirmation" placeholder="Confirm Password" required />
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                                        </div>
                                    </form>
                                    <hr />
                                    <div class="text-center">
                                        <router-link to="/">Already have an account?</router-link>
                                    </div>
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
        if(User.loggedIn()){
            this.$router.push({name: 'home'});
        }
    },
    data(){
        return {
            form: {
                name: null,
                email: null,
                password: null,
                password_confirmation: null,
            },
            errors:{}
        }
    },
    methods: {
        signup(){
            axios.post('/api/signup', this.form)
            .then(response => {
                User.responseAfterLogin(response)
                Toast.fire({
                    icon: 'success',
                    title: 'Signed in successfully'
                })
                this.$router.push({name: 'home'})
            })
            .catch(error => this.errors = error.response.data.errors)
        }
    }
}
</script>

<style scoped>

</style>