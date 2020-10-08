require('./bootstrap');

window.Vue = require('vue');

Vue.component('chat-component', require('./components/ChatComponent.vue').default);

import VueChatScroll from 'vue-chat-scroll'
Vue.use(VueChatScroll)

const app = new Vue({
    el: '#app',

    data: {
        messages: []
    },

    created() {
        this.fetchMessages();

        Echo.private('chat')
            .listen('ChatEvent', (e) => {
                this.messages.push({
                    message: e.message.message,
                    user: e.user
                });
            });
    },

    methods: {
        fetchMessages() {
            console.log(this.getChannelId());
            axios.get('/messages', {
                params: this.axiosParams
                }).then(response => {
                this.messages = response.data;
            });
        },
        addMessage(message) {
            console.log(message);
            this.messages.push(message);

            axios.post('/messages', message).then(response => {
                console.log(response.data);
            });
        },
        getChannelId() {
            const id = window.location.pathname.split("/");
            return id[id.length - 1];
        }
    },
    computed: {
        axiosParams() {
            const params = new URLSearchParams();
            params.append('channel_id', this.getChannelId());
            return params;
        }
    }
});