<template>
    <div>
        <h1>Players</h1>

        <transition name="fade">
            <div class="alert alert-danger" v-if="playerDeleted">Player Deleted!</div>
        </transition>

        <div class="row">
            <div class="col-md-2">
                <button @click="showPlayerForm()" class="btn btn-primary">Create Player</button>
            </div>
        </div>
        <br/>

        <table class="table table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Team</th>
                <th colspan="2">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-if="loadingPlayers">
                <td colspan=100>
                    <div class="loading"><i class="fa fa-circle-o-notch fa-spin"></i></div>
                </td>
            </tr>
            <tr v-for="player in players" :key="player.id" v-if="!loadingPlayers">
                <td>{{ player.id }}</td>
                <td>{{ player.first_name }}</td>
                <td>{{ player.last_name }}</td>
                <td><span v-if="player.team[0]">{{ player.team[0].name }}</span><span v-else>N/A</span></td>
                <td><a v-bind:href="'/players/' + player.id">
                    <button class="btn btn-primary">Edit</button>
                </a></td>
                <td>
                    <button class="btn btn-danger" @click="deletePlayer(player.id)">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>

        <!-- Player Form Modal -->
        <div class="modal" id="modal-add-player" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Add New Player</h4>
                    </div>

                    <div class="modal-body">
                        <form class="form-horizontal" role="form">

                            <!-- Team Name -->
                            <div class="form-group">
                                <label>Team:</label>
                                <select class="form-control" v-model="playerForm.team">
                                    <option v-for="team in teams" :value="team.id">
                                        {{ team.name }}
                                    </option>
                                </select>
                                <div class="help-block" v-show="playerForm.errors.has('team')">
                                    {{ playerForm.errors.get('team') }}
                                </div>
                            </div>

                            <!-- First Name -->
                            <div class="form-group" :class="{'has-error': playerForm.errors.has('first_name')}">
                                <label class="col-md-4 control-label">First Name</label>

                                <div class="col-sm-6">
                                    <input type="text" class="form-control" v-model="playerForm.first_name">
                                    <span class="help-block" v-show="playerForm.errors.has('first_name')">
                                        {{ playerForm.errors.get('first_name') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Last Name -->
                            <div class="form-group" :class="{'has-error': playerForm.errors.has('last_name')}">
                                <label class="col-md-4 control-label">Last Name</label>

                                <div class="col-sm-6">
                                    <input type="text" class="form-control" v-model="playerForm.last_name">
                                    <span class="help-block" v-show="playerForm.errors.has('last_name')">
                                         {{ playerForm.errors.get('last_name') }}
                                    </span>
                                </div>
                            </div>

                        </form>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="createPlayer" :disabled="playerForm.busy">
                            <span v-if="playerForm.busy">
                                <i class="fa fa-btn fa-spinner fa-spin"></i> Adding Player
                            </span>
                            <span v-else>
                                Add Player
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                players: [],
                playerForm: new SparkForm(),
                playerDeleted: false,
                loadingPlayers: false,
                teams: {},
            }
        },
        mounted() {
            this.getPlayers();
            this.getTeams();
        },
        methods: {

            getTeams() {
                axios.get('/api/teams/', {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                    }
                }).then((response) => {
                    this.teams = response.data.data;
                });
            },

            getPlayers() {
                this.loadingPlayers = true;
                axios.get('/api/players', {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                    }
                }).then(response => {
                    this.players = response.data.data;
                    this.loadingPlayers = false;
                });
            },

            deletePlayer(id) {
                axios.delete('/api/players/' + id, {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                    }
                }).then(response => {
                    for (var i = 0; i < this.players.length; i++) {
                        if (this.players[i].id === id) {
                            this.players.splice(i, 1);
                            this.playerDeleted = true;
                            setTimeout(() => {
                                this.playerDeleted = false;
                            }, 2500);
                            break;
                        }
                    }
                });
            },


            createPlayer() {
                Spark.post('/api/players', this.playerForm, {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                    }
                }).then(() => {
                    this.getPlayers();
                    $('#modal-add-player').modal('hide');
                });
            },

            showPlayerForm() {

                this.resetPlayerForm();

                $('#modal-add-player').modal('show');
            },

            /**
             * Reset Player Form
             */
            resetPlayerForm() {
                this.playerForm.resetStatus();

                this.playerForm.first_name = '';
                this.playerForm.last_name = '';
                this.playerForm.team = '';
            }
        }
    }
</script>