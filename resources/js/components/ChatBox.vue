<template>
  <!-- Chat Area -->
  <main class="flex-1 flex flex-col" style="height: calc(100vh - 65px);">
    <!-- Chat Messages -->
            <div class="flex items-center p-4 bg-white border-b" v-for="a in listuser" v-if="a.pivot.discussion_id === id">
                <img alt="" class="w-8 h-8 rounded-full mr-2" height="32" :src="'storage/' +a['users'][0]['avatar']" width="32"  onerror="this.src='https://icons.iconarchive.com/icons/papirus-team/papirus-status/512/avatar-default-icon.png'"/>
                <span class="font-bold capitalize">    
    {{a['users'][0]['name']}}
    </span>
            </div>
    <div class="flex-1 p-4 overflow-y-auto bg-gray-50">
      <!-- Show Messages from Discussion -->
      <div v-if="discussion && id" class="flex flex-col-reverse">
        <!-- Render existing messages -->
        <div
          v-for="message in discussion.data"
          :key="message.id"
          class="flex mb-4"
          :class="message.user.id === auth ? 'justify-end' : ''"
        >
          <!-- Sender Avatar -->
          <div
            v-if="message.user.id !== auth"
            class="flex items-center"
          >
            <img
              :src="'storage/' + message.user.avatar"
              alt="Avatar"
              class="w-5 h-5 rounded-full mr-2"
              onerror="this.src='https://icons.iconarchive.com/icons/papirus-team/papirus-status/512/avatar-default-icon.png'"
            />
          </div>

          <!-- Message Bubble -->
          <div
            :class="message.user.id === auth ? 'bg-blue-500 text-white' : 'bg-gray-100'"
            class="p-2 rounded-lg border"
          >
            <p>{{ message.content }}</p>
            <span
              :class="message.user.id === auth ? 'text-xs text-gray-200' : 'text-xs text-gray-500'"
            >
              {{ message.created_at | moment("calendar") | removeToday() }}
            </span>
          </div>
        </div>

        <!-- Render Loaded Messages -->
        <div
          v-for="message in discussionLoad"
          :key="message.id"
          class="flex mb-4"
          :class="message.user.id === auth ? 'justify-end' : ''"
        >
          <!-- Sender Avatar -->
          <div
            v-if="message.user.id !== auth"
            class="flex items-center"
          >
            <img
              :src="'storage/' + message.user.avatar"
              alt="Avatar"
              class="w-8 h-8 rounded-full mr-2"
              onerror="this.src='https://www.kindpng.com/picc/m/207-2074624_white-gray-circle-avatar-png-transparent-png.png'"
            />
          </div>

          <!-- Message Bubble -->
          <div
            :class="message.user.id === auth ? 'bg-blue-500 text-white' : 'bg-gray-100'"
            class="p-2 rounded-lg border"
          >
            <p>{{ message.content }}</p>
            <span
              :class="message.user.id === auth ? 'text-xs text-gray-200' : 'text-xs text-gray-500'"
            >
              {{ message.created_at | moment("calendar") | removeToday() }}
            </span>
          </div>
        </div>

        <!-- Load More Button -->
        <button
          v-if="page < discussion.last_page"
          @click="loadMore"
          class="bg-transparent text-blue-500 py-1 ring-1 text-sm"
        >
          Load More...
        </button>
        <span
          v-else
          class="w-full p-1 text-center text-sm text-gray-500"
        >
          No more messages!
        </span>
      </div>

      <!-- Welcome Message -->
      <div v-else class="chat-box">
        <div class="welcome text-center flex flex-col items-center gap-4">
          <i class="fas fa-comments text-blue-500 text-8xl"></i>
          <h1 class="text-3xl">Welcome to ChatApp</h1>
          <h4 class="text-2xl">Select a conversation to start chatting!</h4>
          <br />
          <p style="text-align: center; font-size: 16px;line-height:30px">
            1. Click the <b>+</b> icon to find a user you want to chat with.<br />
            2. Wait for the user to accept your chat request.
          </p>
        </div>
      </div>
    </div>

    <!-- Chat Input -->
    <div class="p-4 bg-white border-t flex items-center">
      <form
        class="flex-1 flex"
        @submit.prevent="sendMsg"
        @keypress="handleKeys($event)"
      >
        <textarea
          v-model="form.content"
          ref="content"
          type="text"
          name="content"
          placeholder="Write a message..."
          class="flex-1 p-2 border rounded resize-none"
          :class="{ 'is-invalid': form.errors.has('content') }"
        ></textarea>
        <button
          :disabled="form.busy"
          type="submit"
          class=""

        >
          <i class="fas fa-paper-plane text-blue-500 ml-2"></i>
        </button>
      </form>
    </div>
  </main>
</template>
<script>
import Form from 'vform'
export default {
  props : ['listuser', 'discussion' ,'id', 'auth'],
  data() {
    return {
      form : new Form({
        content : ''
      }),
      discussionLoad : [],
      page : 1,

    }
  },
  filters: {
    removeToday(S) {
      if(S.includes('Today at ')){
        return S.slice(9,-2)
      }
      return S
    }
  },
  methods : {
    
    loadMore(){
                
        this.page++
        axios.get('/discussions/' + this.id +'?page=' + this.page)
        .then(response => response.data.data)
        .then(data => {
          data.forEach(element => {
              this.discussionLoad.push(element)
          });
        })
    
    },
    handleKeys(event){

      if (event.keyCode == 13  && !event.shiftKey) {
        event.preventDefault();
        this.sendMsg();
      }
    }, 

       sendMsg(){

      this.form.post('/messages/'+this.id).then((response) => {
        this.form.reset()
        this.form.fill({
          content :''
        })
        this.$refs.content.focus();
        
      })
        

    }
  },
  mounted(){
  }

}
</script>

<style scoped>
.welcome {
  margin: 0 auto;
  text-align: center;
  margin-bottom: 10rem;
  color: rgba(19, 80, 138, 0.685);
  text-shadow: 0 0 2px 1px rgb(71, 71, 71);
}
  .eye {
    max-width: 1.5rem;
    margin: 0 0.2rem ;
  }
  .avatar {
    width: 1.5rem;
    height: 1.5rem;
    border-radius: 100%;
    overflow: hidden;
    box-shadow: 0 0 2px 1px rgb(100, 198, 255);
    margin: 0 0.5rem;
  }
  .avatar img {
    height: 100%;
  }
  .chat-box {
    height: 100%;
    display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: space-between;
    flex: 1;
    width: 100%;
  }
  .discussion {
    display: flex;
    flex-direction: column-reverse;
    width: 100%;
    height: 100%;
    overflow-y: scroll;
    overflow-x:hidden; 

  }
  /*.discussion::-webkit-scrollbar-track-piece {
      color: rgb(0, 0, 0);
      border-radius: 5px;
  }
   .discussion::-webkit-scrollbar-corner {
      display: none;
  }

  .discussion::-webkit-scrollbar-track {
      box-shadow: inset 0 0 5px rgb(0, 162, 255); 

      max-width: 7px;
      color: rgb(0, 132, 255);
      background-color: rgb(232, 241, 252);

  }*/
  .msg {

    margin: 0.5rem;

    max-width: 80%;
    display: flex;
    align-items: flex-end;
  }
  .msg:last-child .content::before{
    content: '';
    padding: 5rem;
  }
  .time {
    margin: 0.5rem;
    font-size: 0.7rem;
    opacity: 1;
  }
  
  .msg:hover .time{
    opacity: 0.8;
    transition:all 0.5s ease-in-out;
  }
  .msg .content {
    color: white;
    padding: 0.5rem 1rem;
    border-radius:  5px;
    min-width: 4rem;
    word-break: break-all ;
    box-shadow: 0 0 1px 1px rgb(0, 162, 255) ;
    
  }
  .send .content {
    text-align: right;
    background-color: rgb(0, 132, 255) ;

  }
  .receive .content {
    text-align: right;
        background-color: rgb(0, 162, 255) ;

  }
  .send {
    align-self: flex-end;
    text-align: right;
    flex-direction: row-reverse;
  }
  .receive {
    align-self: flex-start;


  }
  .pre {
    white-space: pre-line;
  }
  .form {
    margin-top: 10px ;
    background-color: rgb(188, 219, 255) ;
    padding: 0.5rem 1rem;
    display: flex;
    justify-content: space-between;
    align-items:  flex-end;
    box-shadow: 0 -1px 2px 1px rgb(188, 219, 255);
  }
 
  textarea {
    border: none;
    outline: none;
    border-radius: 5px;
    resize: none;
    flex: 1;

  }
  button {
      margin-left: 10px ;
      margin-bottom: 5px ;
  }

   @media(max-width: 800px) {
    
      .chat-box {
          margin-left: 3rem;
        }
   }

     @-webkit-keyframes argh-my-eyes {
    0%   { background-color: #fff; color:#1c98f7;}
    49% { background-color: #fff; color:#1c98f7;}
    50% { background-color: #1c98f7; color:#fff;}
    99% { background-color: #1c98f7; color:#fff;}
    100% { background-color: #fff; color:#1c98f7;}
  }
  @-moz-keyframes argh-my-eyes {
    0%   { background-color: #fff;color:#1c98f7; }
    49% { background-color: #fff;color:#1c98f7; }
    50% { background-color: #1c98f7;color:#fff; }
    99% { background-color: #1c98f7; color:#fff;}
    100% { background-color: #fff;color:#1c98f7; }
  }
  @keyframes argh-my-eyes {
    0%   { background-color: #fff;color:#1c98f7; }
    49% { background-color: #fff;color:#1c98f7; }
    50% { background-color: #1c98f7; color:#fff;}
    99% { background-color: #1c98f7;color:#fff; }
    100% { background-color: #fff;color:#1c98f7; }
  }

  .blink{
    animation:         argh-my-eyes 1s infinite;
    color:#fff;
    padding:5px 10px;
    border-radius:10px;
  }
</style>