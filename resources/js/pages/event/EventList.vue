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


        <table class="table table-bordered table-hover" align="center" v-if="list && list.length">
            <thead>
            <th>Name</th>
            <th>Created By</th>
            <th>Game</th>
            <th>When</th>
            <th>Number Of Players</th>
            <th>Participants</th>
            <th>Action</th>

            </thead>

            <tr v-for="{id, name, creator, when_is_it, game} in list">
                <td>{{ name }}</td>
                <td>{{ creator }}</td>
                <td>{{ game.name }}</td>
                <td>{{ when_is_it }}</td>

                <td> {{ participants[id].length }} / {{ total_players_in_game[game.id-1].total_number_of_players}}
                </td>
                <td>
                    <div v-for="participant in participants[id]">
                        <li> {{ participant.name}}</li>
                    </div>

                </td>
                <td v-if="$auth.check(2)">
                    <button @click="joinEvent(id)" class="btn btn-success">Join Event!</button>
                    <button @click="editData(id)" class="btn btn-info">Edit Event</button>
                    <button @click="deleteData(id)" class="btn btn-danger">Delete Event</button>
                </td>
                <td v-if="$auth.check(1)">
                    <button @click="joinEvent(id)" class="btn btn-success"
                            :disabled="participants[id].length >= total_players_in_game[game.id-1].total_number_of_players">
                        Join Event!
                    </button>
                </td>

            </tr>

        </table>

        <h3 v-else> Loading... </h3>


        <!-- Pagination başlıyor hocam dikkat etmek lazım!!!!-->
        <pagination :meta="meta" v-on:pageChange="fetchData"></pagination>


    </div>
</template>

<script>
    import Pagination from "../../components/Pagination";
    import EventModal from "./EventModal";

    export default {
        components: {Pagination, EventModal},
        data() {
            return {
                item: {
                    name: '',
                    creator: '',
                    when_is_it: '',
                    game_id: '',
                },
                list: null,
                joined: false,
                game_full: false,
                participants: null,
                event_participants: [],
                number_of_players: 0,
                clicked: false,
                errorMessage: {},
                meta: {},
                total_players_in_game: 0,
                current_players_number: [],
            }
        },
        mounted() {

        },
        created() {
            this.fetchData();
            this.getTotalPlayers();
        },
        methods: {
            getTotalPlayers() {
                axios.get('/games/')
                    .then(response => {
                        this.total_players_in_game = response.data.data.reverse();
                        console.log(this.total_players_in_game)
                        console.log("Secret Hitler ID: ");
                        console.log(this.total_players_in_game[13]);
                    })
            },
            getLength() {
                axios.post('/events/getparticipants')
                    .then(response => {
                        this.number_of_players = response.data.length;
                    });

            },
            getParticipants() {
                axios.post('/events/getparticipants')
                    .then(response => {
                        this.participants = response.data;
                    });
            },
            joinEvent(id) {
                axios.post("/events/join/" + id)
                    .then(response => {
                        this.number_of_players = response.data.length;
                    })
                    .catch(error => {
                        console.log(error);
                    });
                this.fetchData();
            },
            fetchData(page = 1) {
                this.errorMessage = null;
                this.list = null;
                this.getParticipants();
                axios.get("/events", {params: {page}})
                    .then(response => {
                        this.list = response.data.data;
                        //console.log(this.list[0].game.id);
                        console.log(this.list);
                        this.meta = response.data.meta;
                    })
                    .catch(error => {
                        if (error.response != null) {
                            this.errorMessage = error.response.data.message;
                        }
                        else
                            this.errorMessage = error.message;
                    });


            },
            createData() {
                this.item = {};
                this.$refs.eventModal.errorMessage = '';
                $('#eventModal').modal('show');
            },
            refreshData(item) {
                this.fetchData();
            },
            editData(id) {
                axios.get("/events/" + id)
                    .then(response => {
                        this.$refs.eventModal.errorMessage = '';
                        this.item = response.data;
                        $('#eventModal').modal('show');
                    })
                    .catch(error => {
                        if (error.response != null) {
                            this.errorMessage = error.response.data.message;
                        }
                        else
                            this.errorMessage = error.message;
                    });
            },
            deleteData(id) {
                swal({
                    title: 'Are you sure?',
                    text: 'Are you sure you want to delete?',
                    type: 'warning',
                    showCancelButton: 'true',
                    cancelButtonText: 'Cancel',
                    confirmButtonText: 'Proceed'
                }).then(result => {
                    if (result.value) {
                        axios.delete('/events/' + id)
                            .then(response => {
                                this.fetchData();
                                toastr.success('Record deleted', 'Event');
                            })
                            .catch(error => {
                                if (error.response != null) {
                                    this.errorMessage = error.response.data.message;
                                }
                                else
                                    this.errorMessage = error.message;
                            });
                    }
                });
            }
        }
    }
</script>