<template>
    <div class="chatapp">
        <div class="chat">
            <div class="msg" v-for="msg in messages">
                <div class="myself" v-if="msg.user === myself">
                    <span class="user">{{ msg.user }}</span>
                    <span class="created_at">{{ formatDate(msg.created_at) }}</span>
                    <span class="message">{{ msg.message }}</span>
                </div>
                <div class="others" v-else>
                    <span class="user">{{ msg.user }}</span>
                    <span class="message">{{ msg.message }}</span>
                    <span class="created_at">{{ formatDate(msg.created_at) }}</span>
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
import axios from 'axios'
import dayjs from "dayjs"

export default {
    props: {
        myself: String,
        chats: Array,
    },
    data() {
        return {
            message: "",
            messages: this.chats,
        }
    },
    methods: {
        async sendMessage() {
            if(this.message === ""){
                return
            }
            try{
                const res = await axios.post("/home", {message: this.message});
                // console.log(res.data)
                this.message = ""

            }catch(err){
                console.error("ERROR!: " + err)
            }
        },
        formatDate(date){
            const day = dayjs(date)
            const formattedDate = day.format("HH:mm")
            return formattedDate
        }
    },
    mounted() {
        Echo.channel("chatroom").listen("Message", (e) => {
            console.log(e)
            this.messages.push({
                id: e.id,
                user: e.user,
                message: e.message,
                created_at: e.created_at,
                updated_at: e.updated_at,
            })
        })
    },
}
</script>

<style lang="scss">
.chatapp {
    width: 600px;
    background-color: rgb(106, 255, 141);
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    padding: 50px 0;
    
    .chat {
        background-color: rgb(194, 242, 255);
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
            .created_at {
                font-size: 0.7rem;
                margin-right: 5px;
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
            .created_at {
                font-size: 0.7rem;
                margin-left: 5px;
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