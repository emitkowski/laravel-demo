<template>
    <div>
        <tabs>
            <tab name="Player Profile">

                <transition name="fade">
                    <div class="alert alert-info" v-if="playerUpdated">Player Updated!</div>
                </transition>

                <h2>Player: ID #{{ player.id }}</h2>
                <form @submit.prevent="updatePlayer">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>First Name:</label>
                                <input type="text" class="form-control" v-model="player.first_name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Last Name:</label>
                                <input type="text" class="form-control" v-model="player.last_name">
                            </div>
                        </div>
                    </div><br />
                    <div class="form-group">
                        <button class="btn btn-primary">Update</button>
                    </div>
                </form>
            </tab>
            <tab name="Player Files">
                <attachments :type="'player'" :id="id" :name="'My Player'"></attachments>
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
                playerUpdated: false,
            }
        },
        created() {
            axios.get('/api/players/' + this.id, {
                headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('token')
                }
            }).then((response) => {
                this.player = response.data.data;
                this.playerForm = response.data.data;
            });
        },
        methods: {
            updatePlayer() {
                axios.put('/api/players/' + this.id, this.playerForm, {
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