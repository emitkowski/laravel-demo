<template>
    <div>
        <h1>Teams</h1>

        <transition name="fade">
            <div class="alert alert-danger" v-if="teamDeleted">Team Deleted!</div>
        </transition>

        <div class="row">
            <div class="col-md-2">
                <button @click="showTeamForm()" class="btn btn-primary">Create Team</button>
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
            <tr v-if="loadingTeams">
                <td colspan=100>
                    <div class="loading"><i class="fa fa-circle-o-notch fa-spin"></i></div>
                </td>
            </tr>
            <tr v-for="team in teams" :key="team.id" v-if="!loadingTeams">
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

        <!-- Team Form Modal -->
        <div class="modal" id="modal-add-team" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Add New Team</h4>
                    </div>

                    <div class="modal-body">
                        <form class="form-horizontal" role="form">

                            <!-- Name -->
                            <div class="form-group" :class="{'has-error': teamForm.errors.has('name')}">
                                <label class="col-md-4 control-label">Name</label>

                                <div class="col-sm-6">
                                    <input type="text" class="form-control" v-model="teamForm.name">
                                    <span class="help-block" v-show="teamForm.errors.has('name')">
                                        {{ teamForm.errors.get('name') }}
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary"  @click="createTeam" :disabled="teamForm.busy">
                            <span v-if="teamForm.busy">
                                <i class="fa fa-btn fa-spinner fa-spin"></i> Adding Team
                            </span>
                            <span v-else>
                                Add Team
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
                teams: [],
                teamForm: new SparkForm(),
                teamDeleted: false,
                loadingTeams: false
            }
        },
        mounted() {
           this.getTeams();
        },
        methods: {

            getTeams() {
                this.loadingTeams = true;
                axios.get('/api/teams', {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                    }
                }).then(response => {
                    this.teams = response.data.data;
                    this.loadingTeams = false;
                });
            },

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
            },

            createTeam() {
                Spark.post('/api/teams', this.teamForm, {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                    }
                })
                    .then(() => {
                        this.getTeams();
                        $('#modal-add-team').modal('hide');
                    });
            },

            showTeamForm() {

                this.resetTeamForm();

                $('#modal-add-team').modal('show');
            },

            /**
             * Reset Team Form
             */
            resetTeamForm() {
                this.teamForm.resetStatus();

                this.teamForm.name = '';
            }
        }
    }
</script>