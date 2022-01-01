<template>
    <div>
        <router-link to="/given-salary" class="btn btn-primary btn-sm">Pay Salary</router-link>
       <br/>
       <br/>
        <div class="row">
            <div class="col-lg-12 mb-4">
                <!-- Simple Tables -->
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">All Salary Details</h6>
                        <input type="text" v-model="searchTerm" class="form-control col-md-4" placeholder="search here..">
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>Month Name</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr v-for="salary in filterSearch" :key="salary.id">
                                    <td>{{ salary.salary_month }}</td>
                                    <td>
                                        <router-link :to="{name: 'view-salary', params:{id:salary.salary_month}}" class="btn btn-primary btn-sm">Veiw Salary</router-link>
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
            salaries:[],
            searchTerm: '',
        }
    },

    computed:{
        filterSearch(){
            return this.salaries.filter(salary => {
                return salary.salary_month.match(this.searchTerm);
            });
        }
    },
    
    methods:{
        allSalary(){
            axios.get('/api/salary/')
            .then( ({data}) => (this.salaries = data))
            .catch()
        },
    },
    created(){
        this.allSalary();
    }
    
}
</script>

<style scoped>
    #em_photo{
        height: 40px;
        width: 40px;
    }
</style>