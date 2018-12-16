<template>
    <div>
        <h1>Players</h1>

        <transition name="fade">
            <div class="alert alert-danger" v-if="playerDeleted">Player Deleted!</div>
        </transition>

        <div class="row">
            <div class="col-md-2">
                <!--<td><a v-bind:href="'/players/'"><button class="btn btn-primary">Create Player</button></a></td>-->
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
            <tr v-for="player in players" :key="player.id">
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
    </div>
</template>

<script>
    export default {

        data() {
            return {
                players: [],
                playerDeleted: false
            }
        },
        created() {
            axios.get('/api/players', {
                headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('token')
                }
            }).then(response => {
                this.players = response.data.data;
            });
        },
        methods: {
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
                            setTimeout(()=>{ this.playerDeleted = false; }, 2500);
                            break;
                        }
                    }
                });
            }
        }
    }
</script>