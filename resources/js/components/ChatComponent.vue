<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Contacts</div>
                    <ul class="list-group">
                        <a @click.prevent="openChat(friend)" v-for="friend in friends" :key="friend.id">
                            <li class="list-group-item">{{friend.name}}</li>
                        </a>
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <span v-for="friend in friends" :key="friend.id">
                    <span v-if="friend.session">
                        <message-component v-if="friend.session.open" @close="close(friend)" :friend="friend"></message-component>
                    </span>
                </span>
            </div>
        </div>
    </div>
</template>

<script>
    import MessageComponent from './MessageComponent'
    export default {
        data(){
            return{
                
                friends:[]
            }
        },

        components:{MessageComponent},

        created(){
            this.getFriends()
        },

        methods:{
            getFriends(){
                axios.post('/getFriends')
                .then(res => {
                    this.friends = res.data.data
                })
            },

            openChat(friend){
                if(friend.session){
                    this.friends.forEach(friend => {
                        friend.session.open = false
                    })
                    friend.session.open = true
                }
                else{
                    this.createSession(friend)
                }
            },

            createSession(friend){
                axios.post('/session/create',{friend_id:friend.id})
                .then(res => {
                    friend.session = res.data.data
                    /* this.friends.forEach(friend => {
                        friend.session.open = false
                    }) */
                    friend.session.open = true
                })
            },

            close(friend){
                friend.session.open = false
            }
        }
    }
</script>
