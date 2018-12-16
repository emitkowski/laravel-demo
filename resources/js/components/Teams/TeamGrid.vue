<template>
    <div>
        <h1>Teams</h1>

        <transition name="fade">
            <div class="alert alert-danger" v-if="teamDeleted">Team Deleted!</div>
        </transition>

        <div class="row">
            <div class="col-md-2">
                <!--<td><a v-bind:href="'/teams/'"><button class="btn btn-primary">Create Team</button></a></td>-->
            </div>
        </div>
        <br/>

        <table class="table table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Team Name</th>
                <th colspan="2">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="team in teams" :key="team.id">
                <td>{{ team.id }}</td>
                <td>{{ team.name }}</td>
                <td><a v-bind:href="'/teams/' + team.id">
                    <button class="btn btn-primary">Edit</button>
                </a></td>
                <td>
                    <button class="btn btn-danger" @click="deleteTeam(team.id)">Delete</button>
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
                teams: [],
                teamDeleted: false
            }
        },
        created() {
            axios.get('/api/teams', {
                headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('token')
                }
            }).then(response => {
                this.teams = response.data.data;
            });
        },
        methods: {
            deleteTeam(id) {
                axios.delete('/api/teams/' + id, {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                    }
                }).then(response => {
                    for (var i = 0; i < this.teams.length; i++) {
                        if (this.teams[i].id === id) {
                            this.teams.splice(i, 1);
                            this.teamDeleted = true;
                            setTimeout(()=>{ this.teamDeleted = false; }, 2500);
                            break;
                        }
                    }
                });
            }
        }
    }
</script>