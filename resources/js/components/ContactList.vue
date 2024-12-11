<template>
<!-- Sidebar -->
        <aside class="w-1/4 bg-white border-r overflow-y-auto"  :class="{'compact' : compact}">
            <div class="p-4">
                <div class="relative mb-4">
                              <!-- <input class="w-full p-2 border rounded" placeholder="Search" type="text"/>
                              <i class="fas fa-search absolute top-3 right-3 text-gray-400"></i> -->
                  <div class="bg-white border shadow-sm  rounded-lg flex items-center gap-1">
                      <a href="/profile" class="hover:bg-blue-500 p-2 px-4 transition-all duration-300 text-center group hover:rounded-l-lg rounded-l-lg  icn">
                          <font-awesome-icon class="text-blue-400 group-hover:text-white" icon="cog" />
                      </a> 
                      <div class="hover:bg-blue-500 p-2 px-4 transition-all duration-300 text-center group icn"   :class="{'bg-blue-500':menu==='search'}" @click="setMenu('search')">
                      <font-awesome-icon class="text-blue-400 group-hover:text-white icn" icon="search" :class="{'text-white':menu==='search'}"/>
                      </div>
                      <div class="hover:bg-blue-500 p-2 px-4 transition-all duration-300 text-center group icn  hover:rounded-r-lg rounded-r-lg" :class="{'bg-blue-500':menu==='add'}" @click="setMenu('add')">
                      <font-awesome-icon  class="text-blue-400 group-hover:text-white" icon="plus" :class="{'text-white':menu==='add'}"/>
                      </div>
            <!--<div class="hover:bg-blue-500 p-2 px-4 transition-all duration-300 text-center group  hover:rounded-r-lg icn">
                      <font-awesome-icon @click="collapse()" class="text-blue-400 group-hover:text-white" icon="bars" />
                      </div>-->
                  </div>
                      <form v-if="menu==='add'" class="bg-blue-100 p-4 mt-[10px] rounded-lg flex flex-col" @submit.prevent="addContact" @keydown="form.onKeydown($event)">
                        <div class="flex gap-2">
                          <input v-model="form.uname" ref="add" id="username" type="text" name="uname" placeholder="Enter a username" autocomplete="off"
                            class="py-1 px-3  w-full" :class="addContactClass">
                          <button v-if="form.busy" disabled class="!m-0 font-bolder text-sm bg-gray-800 text-white p-2 hover:ring-2 hover:ring-2-green-500 outline-none rounded">Loading...</button>
                          <button v-else type="submit" class="!m-0 font-bolder bg-green-500 text-sm text-white p-2 hover:ring-2 hover:ring-2-green-500 outline-none rounded">Add</button>
                        </div>
                        <div class="mt-3">
                        <div v-if="form.errors.has('uname')" class="text-sm text-red-500"> 
                            {{form.errors.get('uname')}}
                        </div>
                        <div v-else-if="form.errors.any()" class="text-sm text-red-500"> 
                            {{formResponse}}
                        </div>
                        <div v-else-if="form.successful" class="text-sm text-red-500"> 
                            {{formResponse}}
                        </div>
                        </div>
                    </form>


                    <div v-if="menu==='search'" class="bg-blue-100 p-4 mt-[10px] rounded-lg" >
                      <input @keydown="filterDiscussions()" ref="search" type="text" class="py-1 px-3" v-model="searchQuery" placeholder="Search for a discussion">
                    </div>
                </div>
                <div class="k max-h-[480px]" style="overflow:auto" >
                    <h2 class="font-bold mb-2">Chats</h2>
                    <div v-if="discussions && discussions.length > 0">
                      <div v-for="discussion in discussions"  :key="discussion.index"  @click="selectDiscussion(discussion)" >
                      <div class="p-2  mb-4 rounded-lg border hover:ring-1 hover:ring-1-blue-800 outline-none transition-all duration-300" v-if="discussion.users.length && (discussion.users[0].requests_in[0] || discussion.users[0].requests_out[0])" :class="discussionItemClass(discussion)" >
                            <div class="flex items-center rounded">
                              <img :src="'storage/'+discussion.users[0].avatar" alt=""  class="w-8 h-8 rounded-full mr-2" height="32"  srcset="" onerror="this.src='https://icons.iconarchive.com/icons/papirus-team/papirus-status/512/avatar-default-icon.png'">

                            <span class="flex-1 font-bold text-sm" style="text-transform:capitalize">{{discussion.users[0].name}}</span>


                            <div class="unreadCount text-sm rounded-full w-5 h-5 text-center !p-0" v-if="discussion.unreadCount"> {{discussion.unreadCount}}</div>
              

                            </div>
                            <div class="flex justify-between mt-2">
                                        <div class="text-sm" v-if="discussion.messages[0]">{{ discussion.messages[0].content | max30() }}</div>
                                      <div class="text-sm" v-if="discussion.messages[0]">{{discussion.messages[0].created_at | moment("from", "now")}}</div>
                                    </div>

                            <div v-if="!discussion.users[0].pivot.contact && discussion.pivot.contact" class="w-full flex justify-between">
                            
                              <span class="text-sm text-gray-500 text-yellow-700">Request pending ... </span>
                              <button class="!m-0 font-bolder bg-yellow-500 capitalize text-sm text-white px-2 py-1 hover:ring-2 hover:ring-2-green-500 outline-none rounded" @click="deleteRequest(discussion.users[0].uname)">cancel</button>
                            </div>

                            
                            <div v-if="!discussion.pivot.contact && discussion.users[0].pivot.contact" class="flex justify-between items-center" > 
                              <span class="text-sm text-blue-500 font-bold">Request chat ... </span>
                              <div class="flex gap-2">
                              <button class="!m-0 font-bolder bg-green-500 capitalize text-sm text-white px-2 py-1 hover:ring-2 hover:ring-2-green-500 outline-none rounded w-full" @click="acceptRequest(discussion.users[0].uname,discussion.id)">accept</button>
                              <button class="!m-0 font-bolder bg-red-500 capitalize text-sm text-white px-2 py-1 hover:ring-2 hover:ring-2-green-500 outline-none rounded w-full" @click="deleteRequest(discussion.users[0].uname)">delete</button>
                              </div>
                            </div>                 

                      </div>
                      </div>
                    </div>
                    <div v-else class="text-center py-2 mb-4 rounded-lg transition-all duration-300 border bg-gray-50">
                      <h1> No Chat Found</h1>
                    </div>
                </div>
            </div>
        </aside>
</template>

<script>
// import moment from 'moment'
import Form from 'vform'
export default {
  props : ['discussions', 'auth' , 'selected'],
  data() {
    return {
      form : new Form({
        uname : '',
      }),
      compact :false ,
      searchQuery : '',
      search : '' ,
      menu : 'none',
      formResponse : '',
    }
  },
  computed : {
    addContactClass(){
      if(this.form.errors.any()) {
        return 'is-invalid'
      }else if (this.form.successful){
        return 'is-valid'
      }
    }
  },
  // filters: {
  //   moment: function (date) {
  //     return moment(date).fromNow();
  //   }
  // },

  methods : {
    setMenu(menu){
      if(this.menu === menu) {
        this.menu = 'none'
      }else {

        this.menu = menu
       
        setTimeout(() => this.$refs[menu].focus(), 1);
      }
      

    },
    collapse(){
      this.compact = !this.compact
      this.menu = 'none'
    },
    filterDiscussions(){
        this.$emit('search-discussions' , this.searchQuery)
    },
    moment() {
      return moment("from" , "now");
    },
    selectDiscussion(el){
      if(el.pivot.contact && el.users[0].pivot.contact) {
          this.$emit('discussion-selected' , el.id)
          if(window.innerWidth < 801) {
            this.collapse()
          }
      }
    },
    addContact(){
      
      this.form.post('/contacts')
      .then(response => this.form.reset())
      
        
        
    },
    acceptRequest(uname,id){
      axios.post('/contacts/'+uname+'/'+id)

    },
    deleteRequest(uname){
      axios.delete('/contacts/'+uname)

    },
 discussionItemClass(discussion) {
    let classes = [];  // Use an array to store class names

    // Add background color classes based on contact status
    if (!discussion.users[0].pivot.contact && discussion.pivot.contact) {
      classes.push('bg-orange-100');  // Request received (no contact established)
    } else {
      classes.push('bg-gray-50');  // Request sent (contact exists but not confirmed)
    }

    // Check if the discussion is selected
    if (discussion.id === this.selected) {
      classes.push('selected');
    }

    // Add conditional classes based on contact status
    if (!discussion.pivot.contact) {
      classes.push('requestReceived');
    } else if (discussion.pivot.contact && discussion.users[0].pivot.contact === 0) {
      classes.push('requestSent');
    }

    // Return the final string of class names joined by spaces
    return classes.join(' ');
  }
  },
  filters : {
    max30(s) {
      if(s.length > 30) {
        return s.slice(0 , 31) + ' ...'
      }
      else {
        return s
      }
    }
  },
  
  
  mounted() {
    window.addEventListener('resize', () => {
       this.compact =  window.innerWidth > 800 ? false : true
           
      });
  }
}
</script>

<style scoped>
.compact {
  display: absolute;
  width: 3rem !important; 
  min-width: unset !important; 
  background-color: rgb(182, 220, 255) !important;
}
.compact .icn:not(:last-child) {
  display: none;
}
.compact .icn {

}
.compact .discussion,
.compact .k {
  display: none;
  
}

.nav {
  padding: 0.5rem 1rem;
  display: flex;
  background-color: rgb(182, 220, 255);
}
.nav > *:last-child {
  margin-left: auto ;
}
.icon {
  color: #3490dc;
  margin: 0 0.3rem;
  cursor: pointer;
}
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.status  {
  font-weight: 500;
  font-size: 0.8rem;
  color: rgba(255, 121, 44, 0.836);
}
.selected .header .status {
  color: rgb(255, 58, 58);
}
.contactList{
      box-shadow : 1px 0 2px 1px rgb(182, 220, 255);
      height: 100%;
      width: 30%;
      min-width: 20rem;
}

  .discussion {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem 1rem;
    font: 1.1rem;
    box-shadow: 0 1px 1px 1px rgb(188, 219, 255);
  }
  .content {
    flex: 100%;
  }
  .avatar {
    width: 4rem;
    height: 4rem;
    border-radius: 100%;
    box-shadow: 0 0 2px 1px rgb(171, 208, 250);
    margin-right: 1rem ;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    flex-shrink:0 ;
  }
  .avatar > img {
    max-height:100%;
  }
  .discussion:hover {
    background-color: rgb(171, 208, 250);
    color: black;
    cursor: pointer;
  }
  .discussion.selected {
    background-color: rgba(44, 146, 255, 0.836);
    color: white;
  }
  .form {
    background-color: rgb(188, 219, 255) ;
    padding: 0.5rem 1rem;
    display: flex;
    justify-content: space-between;
    align-items:  flex-start;
    box-shadow: 0 1px 2px 1px rgb(188, 219, 255);
  }
  .error {
    padding-top: 5px;
    padding-left: 5px;
    color: rgb(231, 56, 56);
  }
  input {
    border: none;
    outline: none;
    border-radius: 5px;
    resize: none;
    
    flex: 1;

  }
  .group {
    width: 100%;
  }
  button {
      margin-left: 10px ;
  }
  .username {
        padding: 0.5rem 0;
        font-size: 1.1rem;
        font-weight: 500;

  }
  .unreadCount {
    box-shadow: 0 0 2px 1px white;
    color: white;
    border-radius: 10px;
    padding: 0.3rem 0.6rem;
    background-color: rgba(253, 71, 39, 0.836) ;
  }
  .meta {
    display: flex;
    justify-content: space-between;
    padding-bottom: 0.2rem;
  }

  .lastMessage {
    flex: 60%;
  }
  .createdAt {
    flex: 40%;
  }
  @media(max-width: 1000px) {
    .meta {
    flex-direction: column;
    justify-content: unset;
  }
   

  .lastMessage {
    flex: unset;
  }
  .createdAt {
        flex: unset;

    font-size: 0.8rem;
    justify-self: flex-end;
  }
  }
   @media(max-width: 800px) {
    .contactList {
      position: absolute;
      z-index: 555;
      backface-visibility: hidden;
      background-color: white;
    }
   }
</style>