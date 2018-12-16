<template>
    <div>
        <tabs>
            <tab name="Player Profile">

                <transition name="fade">
                    <div class="alert alert-info" v-if="playerUpdated">Player Updated!</div>
                </transition>

                <h2>Player: #{{ player.id }}</h2>
                <form @submit.prevent="updatePlayer" class="needs-validation">
                    <div class="row">
                        <div class="col-md-6">
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
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>First Name:</label>
                                <input type="text" class="form-control" v-model="playerForm.first_name">
                            </div>
                            <span class="help-block" v-show="playerForm.errors.has('first_name')">
                                {{ playerForm.errors.get('first_name') }}
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Last Name:</label>
                                <input type="text" class="form-control" v-model="playerForm.last_name">
                            </div>
                            <span class="help-block" v-show="playerForm.errors.has('last_name')">
                                {{ playerForm.errors.get('last_name') }}
                            </span>
                        </div>
                    </div><br />
                    <div class="form-group">
                        <button class="btn btn-primary">Update</button>
                    </div>
                </form>
            </tab>
            <tab name="Player Files">
                <attachments :type="'player'" :id="id" :name="this.player.first_name + ' ' + this.player.last_name"></attachments>
            </tab>
            <tab name="Player Addresses">
                <addresses :type="'player'" :id="id"></addresses>
            </tab>
        </tabs>
    </div>
</template>

<script>
    export default {
        props: {
            'id': Number
        },

        data() {
            return {
                player: {},
                playerForm: new SparkForm(),
                playerUpdated: false,
                teams: {},
            }
        },
        created() {
            axios.get('/api/players/' + this.id, {
                headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('token')
                }
            }).then((response) => {
                this.player = response.data.data;
                this.playerForm.first_name = response.data.data.first_name;
                this.playerForm.last_name = response.data.data.last_name;

                if (response.data.data.team[0]) {
                    this.playerForm.team = response.data.data.team[0].id;
                }
            });

            axios.get('/api/teams/', {
                headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('token')
                }
            }).then((response) => {
                this.teams = response.data.data;
            });
        },
        methods: {
            updatePlayer() {
                Spark.put('/api/players/' + this.id, this.playerForm, {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                    }
                }).then((response) => {
                    this.playerUpdated = true;
                    setTimeout(()=>{ this.playerUpdated = false; }, 2500);
                });
            }
        }
    }
</script>