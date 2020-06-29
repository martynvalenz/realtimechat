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
         <p class="card-text" v-for="chat in chats" :key="chat.message">{{chat.message}}</p>
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
         this.chats.push(
            { message:'hey arnold' },
            { message:'supudamadre' },
            { message:'dejame en paz pendeja' },
            { message:'dejame en paz pendejas' },
            { message:'dejame fuck you' },
            { message:'dejame asfasdf' },
            { message:'dejame easdfadfadf a' },
            { message:'dejame en pazasdasdf asdja' },
            { message:'dejame asdfasdfeja' },
            { message:'dejame asdfasdf' },
            { message:'dejame asdq3' },
            { message:'dejame asdfad adsfasdf' },
            { message:'dejame asdflasdf p9u a' },
         )
      },

      methods:{
         send(){
            console.log('yeah')
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