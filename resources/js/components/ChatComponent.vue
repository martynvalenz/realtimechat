<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Contacts</div>
                    <ul class="list-group">
                        <li class="list-group-item" @click.prevent="openChat(friend)" v-for="friend in friends" :key="friend.id">
                            <a href="">
                                {{friend.name}} 
                                <i class="fas fa-circle text-success float-right" v-if="friend.online"></i>
                                <i class="far fa-circle text-secondary float-right" v-if="!friend.online"></i>
                            </a>
                        </li>
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

            Echo.channel('Chat').listen('SessionEvent', e => {
                let friend = this.friends.find(friend => friend.id == e.session_by)
                friend.session = e.session
            })

            Echo.join('Chat')
            .here((users) => {
                this.friends.forEach(friend =>{
                    users.forEach(user => {
                        if(user.id == friend.id){
                            friend.online = true
                        }
                    })
                })
            })
            .joining((user) => {
                this.friends.forEach(friend => user.id == friend.id ? friend.online = true : '')
            })
            .leaving((user) => {
                this.friends.forEach(friend => user.id == friend.id ? friend.online = false : '')
            });
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
                        friend => (friend.session ? (friend.session.open = false) : '')
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
                    this.friends.forEach(friend => {
                        if(friend.session){
                            friend.session.open = false
                        }
                    })
                    friend.session.open = true
                })
            },

            close(friend){
                friend.session.open = false
            }
        }
    }
</script>
