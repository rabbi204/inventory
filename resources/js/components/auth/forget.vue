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
                                        <h1 class="h4 text-gray-900 mb-4">Forget Password</h1>
                                    </div>
                                    <form class="user">
                                        <div class="form-group">
                                            <input type="email" class="form-control" placeholder="Enter Existing Email Address" />
                                        </div>
                                        
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Forget Password</button>
                                        </div>
                                    </form>
                                    <hr />
                                    <div class="text-center">
                                         <router-link to="/">Back to Login</router-link>
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
    
}
</script>

<style scoped>

</style>