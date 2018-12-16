<template>
    <div>
        <tabs>
            <tab name="Team Profile">

                <transition name="fade">
                    <div class="alert alert-info" v-if="teamUpdated">Team Updated!</div>
                </transition>

                <h2>Team: #{{ team.id }}</h2>
                <form @submit.prevent="updateTeam">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Team Name:</label>
                                <input type="text" class="form-control" v-model="teamForm.name">
                                <span class="help-block" v-show="teamForm.errors.has('name')">
                                    {{ teamForm.errors.get('name') }}
                                </span>
                            </div>
                        </div>
                    </div><br />
                    <div class="form-group">
                        <button class="btn btn-primary">Update</button>
                    </div>
                </form>
            </tab>
            <tab name="Team Files">
                <attachments :type="'team'" :id="id" :name="this.team.name"></attachments>
            </tab>
            <tab name="Team Addresses">
                <addresses :type="'team'" :id="id"></addresses>
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
                team: {},
                teamForm: new SparkForm(),
                teamUpdated: false,
            }
        },
        created() {
            axios.get('/api/teams/' + this.id, {
                headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('token')
                }
            }).then((response) => {
                this.team = response.data.data;
                this.teamForm.name = response.data.data.name;
            });
        },
        methods: {
            updateTeam() {
                Spark.put('/api/teams/' + this.id, this.teamForm, {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                    }
                }).then((response) => {
                    this.teamUpdated = true;
                    setTimeout(()=>{ this.teamUpdated = false; }, 2500);
                });
            }
        }
    }
</script>