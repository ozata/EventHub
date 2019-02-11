<template>
    <div class="modal fade" tabindex="-1" role="dialog" id="eventModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-text="item.id>0?'Edit Event':'New Event'"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div v-if="errorMessage" class="alert alert-danger" v-html="errorMessage"></div>


                    <form @submit.prevent="true">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" v-model="item.name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Game</label>
                            <select v-model="selectedGame">
                                <option v-for="game in games">
                                    {{ game.name }}
                                </option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Created By</label>
                            <div class="col-sm-9">
                                <input type="text" v-model="item.creator" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">When (YYYY-MM-DD HH:MM:SS) </label>
                            <div class="col-sm-9">
                                <input type="text" v-model="item.when_is_it" class="form-control">
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" v-text="item.id>0?'Update':'Save'" @click="saveItem"></button>
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    export default {
        props: ['item'],
        data() {
            return {
                games: {},
                selectedGame : '',
                errorMessage: ''
            }
        },
        mounted() {
            axios.get('/games/')
                .then(response => {
                    this.games = response.data.data;
                })
        },
        methods: {
            saveItem() {
                if (this.item.id > 0) {
                    axios.put('/events/'+this.item.id ,this.item)
                        .then(response => {
                            if (response.data.success) {

                                //alert(response.data.message);
                                this.$emit('onSaved', this.item);
                                $('#eventModal').modal('hide');
                                toastr.success('Record Updated', 'Event');
                            }
                        })
                        .catch(error => {
                            //alert(response.data.message);
                            this.errorMessage = error.response.data.message;
                            if (error.response.data.errors) {
                                //console.log(response.data.errors);
                                this.errorMessage += "<ul>";
                                Object.keys(error.response.data.errors).forEach((key) => {
                                    this.errorMessage += "<li>" + error.response.data.errors[key][0] + "</li>";
                                });
                                this.errorMessage += "</ul>";
                            }
                        });
                } else {
                    this.item.game_id = this.games.find(
                        obj => obj.name === this.selectedGame
                    ).id;
                    axios.post('/events', this.item)
                        .then(response => {
                            if (response.data.success) {
                                //alert(response.data.message);
                                this.$emit('onSaved', this.item);
                                $('#eventModal').modal('hide');
                                toastr.success('Record added', 'Event');
                            }
                        })
                        .catch(error => {
                            //alert(response.data.message);
                            this.errorMessage = error.response.data.message;
                            if (error.response.data.errors) {
                                //console.log(response.data.errors);
                                this.errorMessage += "<ul>";
                                Object.keys(error.response.data.errors).forEach((key) => {
                                    this.errorMessage += "<li>" + error.response.data.errors[key][0] + "</li>";
                                });
                                this.errorMessage += "</ul>";
                            }
                        });
                }
            }
        }
    };
</script>