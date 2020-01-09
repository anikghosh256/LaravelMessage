<template>
    <div class="messages col-9">
       <div class="m-head">
           <h2>{{ contact ? contact.name : 'Select a contact' }} </h2>
       </div>
       <MessFeed  :contact="contact" :messages="messages"/>
       <MessComposer v-if="contact" @send="sendMessage"/>
    </div>
</template>

<script>
    import MessFeed from './mess_feed'
    import MessComposer from './mess_composer'
    export default {
       props: {
       		messages:{
       			type: Array,
       			default: []
       		},
            contact:{
                type: Object,
                default: null
            }
       },
       components:{
            MessFeed, MessComposer
       },
       methods:{
        sendMessage(text){
            if(!this.contact){
                return;
            }
            axios.post('/message/send', {
                    contact_id: this.contact.id,
                    text: text
                }).then((response) => {
                    this.$emit('newMess', response.data);
                })
        }
       }
    }
</script>
<style scoped>
    .messages{
        padding-left:0px;
        background:#797979;
    }
    .m-head h2{
        padding: 10px;
        background: gainsboro;
        font-weight: bold;
        margin-bottom:0px;
    }
    .mess-feed{
        min-height: calc( 75vh - 102px );
        margin-bottom:8px;

    }
    
</style>
