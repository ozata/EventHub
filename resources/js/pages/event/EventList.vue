<template>
    <div>
        <event-modal :item="item" v-on:onSaved="refreshData" ref="eventModal"></event-modal>
        <div class="btn-group float-right">

            <button @click="fetchData" class="btn btn-info">Refresh</button>
            <button @click="createData" class="btn btn-success">New Event</button>

        </div>
            
            <h1> Events </h1>
            
            
            
            
            <div v-if="errorMessage" class="alert alert-danger">
                {{ errorMessage }}
            </div>

            


            <table class="table table-bordered table-hover" v-if="list && list.length">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Created By</th>
                    <th>When</th>
                    <th>Action</th>
                </tr>

                <tr v-for="{id, name, creator, when_is_it} in list">
                    <td>{{ id   }}</td>
                    <td>{{ name }}</td>
                    <td>{{ creator }}</td>
                    <td>{{ when_is_it }}</td>

                    <td>
                        <button @click="editData(id)" class="btn btn-success">Edit Event</button>
                        <button @click="deleteData(id)" class="btn btn-danger">Delete Event</button>
                    </td>
                </tr>

            </table>

            <p v-else> No Records Found. </p>


            <!-- Pagination başlıyor hocam dikkat etmek lazım!!!!-->
            <pagination :meta="meta" v-on:pageChange="fetchData"></pagination>


    </div>
</template>

<script>    
    import Pagination from "../../components/Pagination";
    import EventModal from "./EventModal";




    export default {
        components: {Pagination,EventModal},
        data() {
            return {
                item: {
                    name: '',
                    creator:'',
                    when_is_it: '',
                    game_id:''
                },
                list: null,
                errorMessage: {},
                meta: {}
            }
        },
        created(){
            this.fetchData();
        },
        methods: {
            fetchData( page = 1) {
                this.errorMessage = null;
                this.list = null;
                axios.get("/events", {params: { page }})
                    .then(response => {
                        this.list = response.data.data;
                        this.meta = response.data.meta;
                    })
                    .catch(error => {
                        if(error.response != null)
                            {this.errorMessage = error.response.data.message;}
                        else
                            this.errorMessage = error.message;
                    });
            },
            createData(){
                this.item = {};
                this.$refs.eventModal.errorMessage = '';
                $('#eventModal').modal('show');
            },
            refreshData(item){
                this.fetchData();
            },
            editData(id){
                axios.get("/events/"+id)
                    .then(response => {
                        this.$refs.eventModal.errorMessage = '';
                        this.item = response.data;
                        $('#eventModal').modal('show');
                    })
                    .catch(error => {
                        if(error.response != null)
                        {this.errorMessage = error.response.data.message;}
                        else
                            this.errorMessage = error.message;
                    });
            },
            deleteData(id){
                swal({
                    title: 'Are you sure?',
                    text: 'Are you sure you want to delete?',
                    type: 'warning',
                    showCancelButton: 'true',
                    cancelButtonText: 'Cancel',
                    confirmButtonText: 'Proceed'
                }).then(result => {
                    if(result.value){
                        axios.delete('/events/' + id)
                            .then(response => {
                               this.fetchData();
                               toastr.success('Record deleted', 'Event');
                            })
                            .catch(error => {
                                if(error.response != null)
                                {this.errorMessage = error.response.data.message;}
                                else
                                    this.errorMessage = error.message;
                            });
                    }
                });
            }
        }
    }
</script>




















