<template>
    <div class="container">
        <div class="row justify-content-center" >
            <div class="col-md-12">
                <div class="card" style="min-height: 75vh; overflow:hidden; background:#dcdcdc;">
                    <div class="card-header">Messenger</div>
                    <div class="row">
                        <Contacts :contacts="contacts" @selected="startConversationWith"/>
                        <Messages :contact="selectedContact" :messages="messages" @newMess="addMessage"/>
                    </div>
                    <notifications group="notification" position="bottom right"/>
                    
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    
    import Contacts from './contacts'
    import Messages from './messages'
    export default {
        props: {
            user: {
                type: Object,
                required: true
            }
        },
        data(){
            return{
                selectedContact: null,
                contacts:[],
                messages:[]
            }
        },
        mounted() {

            
            Echo.private(`messages.${this.user.id}`)
                .listen('NewMessage', (e) => {
                    this.hanleIncoming(e.message);
                    this.updateLassMess(e.message);
                });

            axios.get('./contacts')
                .then((responce) => {
                    this.contacts = responce.data;
                });
        },
        components: {
            Contacts,Messages
        },
        methods: {
            startConversationWith(contact){
                
                axios.get(`./getMessages/${contact.id}`)
                    .then((responce) => {
                        this.messages= responce.data.slice().reverse();
                        this.selectedContact = contact;
                    });
                this.updateUnreadCount(contact, true);
            },
            addMessage(message){
                this.messages.push(message);
                this.updateLassMessForCU(message);
            },
            hanleIncoming(message){
                if( this.selectedContact && message.from == this.selectedContact.id){
                    if (document.hasFocus()) {
                        this.addMessage(message);
                        return;
                    } else {
                        this.playalert('./incoming.mp3');
                        this.addMessage(message);
                        return;
                    }    
                }
                
                this.playalert('./incoming.mp3');
                this.updateUnreadCount(message.from_contact, false);
                this.$notify({
                  group: 'notification',
                  title: message.from_contact.name,
                  text: message.text
                });
            },
            updateUnreadCount(contact, reset) {
                this.contacts = this.contacts.map((single) => {
                    if (single.id !== contact.id) {
                        return single;
                    }

                    if (reset)
                        single.unread = 0;
                    else
                        single.unread += 1;

                    return single;
                });
            },
            updateLassMess(message) {
                this.contacts = this.contacts.map((single) => {
                    if (single.id !== message.from_contact.id) {
                        return single;
                    }
                    single.lastMess = message.text;
                    return single;
                });
            },
            updateLassMessForCU(message) {
                this.contacts = this.contacts.map((single) => {
                    if (single.id === this.selectedContact.id) {
                        this.selectedContact.lastMess = message.text;
                        return single;
                    }
                    
                    return single;
                });
            },
            playalert (sound) {
              if(sound) {
                var audio = new Audio(sound);
                audio.play();
              }
            }
        }
    }
</script>
<style>
    .card-header{
        background:#797979;
    }
/* width */
    ::-webkit-scrollbar {
      transition:.5s;
      width: 6px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
      background: #f1f1f1; 
    }
     
    /* Handle */
    ::-webkit-scrollbar-thumb {
      background: #888; 
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
      background: #555; 
    }
    .vue-notification{
        background:#797979;
        color: #fff;
        border-left: black;
    }
</style>

