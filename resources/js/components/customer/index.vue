<template>
    <div>
        <router-link to="/store-customer" class="btn btn-primary btn-sm">Add Customer</router-link>
       <br/>
       <br/>
        <div class="row">
            <div class="col-lg-12 mb-4">
                <!-- Simple Tables -->
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Customer List</h6>
                        <input type="text" v-model="searchTerm" class="form-control col-md-4" placeholder="search by name">
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Photo</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr v-for="customer in filterSearch" :key="customer.id">
                                    <td>{{ customer.name }}</td>
                                    <td><img :src="customer.photo" alt="" id="em_photo"></td>
                                    <td>{{ customer.email }}</td>
                                    <td>{{ customer.phone }}</td>
                                    <td>{{ customer.address }}</td>
                                    <td>
                                        <router-link :to="{name: 'edit-customer', params:{id:customer.id}}" class="btn btn-primary btn-sm">Edit</router-link>
                                        <a @click="deleteCustomer(customer.id)" class="btn btn-sm btn-danger">Delete</a>
                                    </td>
                                </tr>
                               
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
        <!--Row-->
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
        return{
            customers:[],
            searchTerm: '',
        }
    },

    computed:{
        filterSearch(){
            return this.customers.filter(customer => {
                return customer.name.match(this.searchTerm);
            });
        }
    },
    
    methods:{
        allCustomer(){
            axios.get('/api/customer/')
            .then( ({data}) => (this.customers = data))
            .catch()
        },
        deleteCustomer(id){
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {

                    axios.delete('api/customer/' + id)
                    .then( () => {
                        this.customers = this.customers.filter(customer => {
                            return customer.id != id
                        })
                    } )
                    .catch( () => {
                        this.$router.push({name: 'customer'})
                    } )

                    Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                    )
                }
            })
        }
    },
    created(){
        this.allCustomer();
    }
    
}
</script>

<style scoped>
    #em_photo{
        height: 40px;
        width: 40px;
    }
</style>