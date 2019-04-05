<template>
    <div id="chat">
        <div id="messages">
            <div v-for="message in messages">
                <div><strong>{{ message.user.name }}</strong></div>
                <div>{{ message.body }}</div>
            <hr>
            </div>
        </div>
        <div class="form-group">
            <input class="form-control" placeholder="Say something..." @keyup.enter="send" v-model="currentMessage" />
        </div>
    </div>
</template>
<script>
    export default {

        data(){
            return {
                messages: '',
                currentMessage: null,
            }
        },

        mounted(){

            console.log('Chat is on')

            Echo.channel('chat')
                .listen('.MessageSent', (e) => {
                    this.getAllMessages();
                });


            this.getAllMessages();
        },

        methods: {
            send(){
                axios.post('/messages', {body: this.currentMessage}).then((response) => {
                    this.currentMessage = null
                })
            },

            getAllMessages() {
                axios.get('/messages').then((response) => {
                    this.messages = response.data
                })
            }
        }
    }
</script>
