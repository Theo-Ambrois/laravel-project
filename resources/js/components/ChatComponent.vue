
<template>
   <div class="row">

       <div class="col-8">
           <div class="card card-default">
               <div class="card-header">{{channelName}}</div>
               <div class="card-body p-0">
                   <ul class="list-unstyled" style="height:300px; overflow-y:scroll" v-chat-scroll>
                       <li class="p-2" v-for="(message, index) in messages" :key="index" >
                           <strong>{{ message.user.name }}</strong>
                           {{ message.message }}
                       </li>
                   </ul>
               </div>

               <input
                    @keydown="sendTypingEvent"
                    @keyup.enter="sendMessage"
                    v-model="newMessage"
                    type="text"
                    name="message"
                    placeholder="Enter your message..."
                    class="form-control">
           </div>
            <span class="text-muted" v-if="activeUser" >{{ activeUser.name }} is typing...</span>
       </div>

        <div class="col-4">
            <div class="card card-default">
                <div class="card-header">Active Users</div>
                <div class="card-body">
                    <p class="py-2" v-for="(user, index) in users" :key="index">
                        {{ user.name }}
                    </p><br>
                </div>
            </div>
        </div>

   </div>
</template>

<script>
    export default {
        props:['user'],
        data() {
            return {
                messages: [],
                newMessage: '',
                users:[],
                activeUser: false,
                typingTimer: false,
                channelName: '',
            }
        },
        created() {
            this.fetchMessages();
            this.fetchUsers();
            this.getChannelName();
            Echo.join('chat')
                .here(user => {
                    this.users = user;
                })
                .joining(user => {
                    this.users.push(user);
                })
                .leaving(user => {
                    this.users = this.users.filter(u => u.id !== user.id);
                })
                .listen('ChatEvent',() => {
                    this.fetchMessages();
                })
                .listenForWhisper('typing', user => {
                   this.activeUser = user;
                    if(this.typingTimer) {
                        clearTimeout(this.typingTimer);
                    }
                   this.typingTimer = setTimeout(() => {
                       this.activeUser = false;
                   }, 1000);
                })
        },
        methods: {
            fetchMessages() {
                axios.get(`/messages`, {
                params: this.axiosParams
                })
                .then(response => {
                    this.messages = response.data
                })
            },
            fetchUsers() {
                axios.get('/users').then(response => {
                    this.users = response.data;
                })
            },
            sendMessage() {
                this.messages.push({
                    user: this.user,
                    message: this.newMessage
                });
                this.$emit('messagesent', {
                    user: this.user,
                    message: this.newMessage,
                    channel_id: this.getChannelId()
                });
                this.newMessage = '';
            },
            sendTypingEvent() {
                Echo.join('chat')
                    .whisper('typing', this.user);
                console.log(this.user.name + ' is typing now')
            },
            getChannelId() {
                const id = window.location.pathname.split("/");
                return id[id.length - 1];
            },
            getChannelName() {
                axios.get(`/channel-name`, {
                    params: this.axiosParams
                })
                .then(response => {
                    console.log('channelname', response.data);
                    this.channelName = response.data[0];
                });
            }
        },
        computed: {
            axiosParams() {
                const params = new URLSearchParams();
                params.append('channel_id', this.getChannelId());
                return params;
            }
        }
    }
</script> 