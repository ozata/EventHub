<template>
    <div>
        <game-modal :item="item" v-on:onSaved="refreshData" ref="gameModal"></game-modal>
        <div class="btn-group float-right">

            <button @click="fetchData" class="btn btn-info">Refresh</button>
            <button @click="createData" class="btn btn-success">New Game</button>

        </div>

        <h1> Games </h1>




        <div v-if="errorMessage" class="alert alert-danger">
            {{ errorMessage }}
        </div>




        <table class="table table-bordered table-hover" v-if="list && list.length">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Max. Players</th>
                <th>Action</th>
            </tr>

            <tr v-for="{id, name, description, total_number_of_players} in list">
                <td>{{ id   }}</td>
                <td>{{ name }}</td>
                <td>{{ description }}</td>
                <td>{{ total_number_of_players }}</td>
                <td>
                    <button @click="editData(id)" class="btn btn-success">Edit</button>
                    <button @click="deleteData(id)" class="btn btn-danger">Delete</button>
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
    import GameModal from "./GameModal";

    export default {
        components: {Pagination,GameModal},
        data() {
            return {
                item: {

                },
                list: null,
                errorMessage: {},
                meta: {}
            }
        },
        // Component oluştuğu an created çalışacak.
        created(){
            this.fetchData();
        },
        methods: {
            fetchData( page = 1) {
                this.errorMessage = null;
                this.list = null;
                axios.get("/games", {params: { page }})
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
                // gameModal component'ındaki errorMessage'a ulaşmak için yukarıda
                // game-modal component'ı içerisindeki ref değerinden
                // gameModal'daki errorMessage'a ulaşıp onu burada sıfırlayabiliyoruz.
                this.$refs.gameModal.errorMessage = '';
                $('#gameModal').modal('show');
            },
            refreshData(item){
                this.fetchData();
            },
            editData(id){
                axios.get("/games/"+id)
                    .then(response => {
                        this.$refs.gameModal.errorMessage = '';
                        this.item = response.data;
                        $('#gameModal').modal('show');
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
                        axios.delete('/games/' + id)
                            .then(response => {
                                this.fetchData();
                                toastr.success('Record deleted', 'Game');
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




















