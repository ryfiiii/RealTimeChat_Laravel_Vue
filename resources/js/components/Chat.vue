<template>
    <div class="chatapp">
        <div class="chat">
            <div class="msg" v-for="msg in messages">
                <div class="myself" v-if="msg.user === myself">
                    <span class="user">{{ msg.user }}</span>
                    <span class="message">{{ msg.message }}</span>
                </div>
                <div class="others" v-else>
                    <span class="user">{{ msg.user }}</span>
                    <span class="message">{{ msg.message }}</span>
                </div>
            </div>
        </div>
        <div class="form">
            <input type="text" v-model="message" @keyup.enter="sendMessage">
            <button @click="sendMessage">送信</button>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        myself: String,
    },
    data() {
        return {
            message: "",
            messages: [],
        }
    },
    methods: {
        async sendMessage() {
            if(this.message === ""){
                return
            }
            try{
                const res = await axios.post("/home", {message: this.message});
                console.log(res.data)
                this.message = ""

            }catch(err){
                console.error("ERROR!: " + err)
            }
        },
    },
    mounted() {
        Echo.channel("chatroom").listen("Message", (e) => {
            console.log(e)
            this.messages.push({
                user: e.user,
                message: e.message,
            })
        })
    },
}
</script>

<style lang="scss">
.chatapp {
    width: 600px;
    background-color: rgb(170, 237, 255);
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    padding: 50px 0;
    
    .chat {
        background-color: white;
        width: 500px;
        height: 400px;
        border-radius: 10px;
        margin-bottom: 15px;
        overflow: auto;

        .myself {
            text-align: end;
            margin: 35px 5px;
            position: relative;
            .user {
                position: absolute;
                font-size: 0.9rem;
                top: -25px;
                right: 5px;
            }
            .message {
                font-size: 1.2rem;
                background-color: #b9ff93;
                padding: 7px 12px;
                border-radius: 15px;
            }
        }

        .others {
            text-align: start;
            margin: 35px 5px;
            position: relative;
            .user {
                position: absolute;
                font-size: 0.9rem;
                top: -25px;
                left: 5px;
            }
            .message {
                font-size: 1.2rem;
                background-color: #e3e3e3;
                padding: 7px 12px;
                border-radius: 15px;
            }
        }
    }

    .form {
        width: 500px;
        input {
            width: 450px;
            height: 50px;
        }
        button {
            width: 50px;
            height: 50px;
        }
    }
}
</style>