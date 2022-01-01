<template>
    <div>
        <router-link to="/store-expense" class="btn btn-primary btn-sm">Add Expense</router-link>
       <br/>
       <br/>
        <div class="row">
            <div class="col-lg-12 mb-4">
                <!-- Simple Tables -->
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">All Expense List</h6>
                        <input type="text" v-model="searchTerm" class="form-control col-md-4" placeholder="search by expense date..">
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Expense Details</th>
                                    <th>Expense Amount</th>
                                    <th>Expense Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr v-for="expense in filterSearch" :key="expense.id">
                                    <td>{{ expense.id }}</td>
                                    <td>{{ expense.details }}</td>
                                    <td>{{ expense.amount }}</td>
                                    <td>{{ expense.expense_date }}</td>
                                    <!-- <td><img :src="supplier.photo" alt="" id="em_photo"></td> -->
                                    <td>
                                        <router-link :to="{name: 'edit-expense', params:{id:expense.id}}" class="btn btn-primary btn-sm">Edit</router-link>
                                        <a @click="deleteExpense(expense.id)" class="btn btn-sm btn-danger">Delete</a>
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
            expenses:[],
            searchTerm: '',
        }
    },

    computed:{
        filterSearch(){
            return this.expenses.filter(expense => {
                return expense.expense_date.match(this.searchTerm);
            });
        }
    },
    
    methods:{
        allExpense(){
            axios.get('/api/expense/')
            .then( ({data}) => (this.expenses = data))
            .catch()
        },
        deleteExpense(id){
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

                    axios.delete('/api/expense/' + id)
                    .then( () => {
                        this.categories = this.expenses.filter(expense => {
                            return expense.id != id
                        })
                    } )
                    .catch( () => {
                        this.$router.push({name: 'expense'})
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
        // this.allExpense();
        this.allExpense()
    }
    
}
</script>

<style scoped>
    #em_photo{
        height: 40px;
        width: 40px;
    }
</style>