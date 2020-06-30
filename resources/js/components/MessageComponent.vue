<template>
   <div class="card chat-box">
      <div class="card-header">
         <b :class="{'text-danger':session_block}">
            {{ friend.name }}
            <span v-if="session_block">(Blocked)</span>
         </b>
         <a href="" @click.prevent="close()">
            <i class="fas fa-times float-right"></i>
         </a>
         <div class="dropdown float-right mr-4">
            <a id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <i class="fas fa-ellipsis-v float-right mr-4"></i>
            </a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
               <a class="dropdown-item" @click.prevent="block()" v-if="!session_block">Block</a>
               <a class="dropdown-item" @click.prevent="unblock()" v-else>Unblock</a>
               <a class="dropdown-item" @click.prevent="clear()">Clear Chat</a>
            </div>
         </div>
      </div>
      <div class="card-body" v-chat-scroll>
         <p class="card-text" :class="{'text-right':chat.type == 0}" v-for="chat in chats" :key="chat.id">{{chat.content}}</p>
      </div>
      <form class="card-footer" @submit.prevent="send()">
         <div class="form-group">
               <input v-model="message" type="text" class="form-control" placeholder="Mensaje..." :disabled="session_block">
         </div>
      </form>
   </div>
</template>

<script>

   export default {
      props:['friend'],

      data(){
         return{
            message:'',
            chats:[],
            open:true,
            session_block:false
         }
      },

      created(){
         this.read()
         this.getAllMessages()

         Echo.private(`Chat.${this.friend.session.id}`)
         .listen('PrivateChatEvent', (e) => {
            this.read()
            this.chats.push({content:e.content, type:1, send_at:'Just now'})
         })
      },

      methods:{
         read(){
            axios.post(`/session/${this.friend.session.id}/read`)
         },

         getAllMessages(){
            axios.post(`/session/${this.friend.session.id}/chats`)
            .then(res => {
               this.chats = res.data.data
            })
         },

         send(){
            if(this.message){
               axios.post(`/send/${this.friend.session.id}`,{content:this.message, to_user:this.friend.id})
               .then(res => {
                  let data = {content:res.data.content, id:res.data.id, created_at:res.data.created_at, type:0}
                  this.pushToChat(data)
                  console.log(res.data)
                  this.message = ''
               })
               .catch(error => {
                  console.log(error)
               })
            }
         },

         pushToChat(data){
            this.chats.push(data)
         },

         close(){
            this.$emit('close')
         },

         clear(){
            this.chats = []
         },

         block(){
            this.session_block = true
         },

         unblock(){
            this.session_block = false
         }
      }
   }
</script>

<style lang="scss" scoped>
   .chat-box{
      height:400px;
   }

   .card-body{
      overflow:scroll;
   }
</style>