<template>
    <div class="mess-feed" ref="feed">
         <div v-if="contact == null"><h2>{{ contact ? null: 'Select a contact' }} </h2></div>
         <ul class="messages">
           <li v-for="message in messages" :class="`message ${message.to == contact.id ? 'sent' : 'recived'}`">
             <p class="text"> {{ message.text }} </p>
           </li>
         </ul>
      
    </div>
</template>

<script>
    export default {
       props: {
       		messages:{
            type: Array,
            default: []
          },
          contact:{
            type: Object
          }
       },
       methods: {
        scrollToBottom() {
                setTimeout(() => {
                    this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight;
                }, 30);
            }
       },
        watch: {
            contact(contact) {
                this.scrollToBottom();
            },
            messages(messages) {
                this.scrollToBottom();
            }
        }
    }
</script>
<style scoped>
   
    .mess-feed{
        max-height: calc( 75vh - 102px );
        margin-bottom:8px;
        overflow:auto;
        scroll-behavior: smooth;
    }

    ul{
      padding: 5px;
    }
    li{
      list-style: none;
      padding: 5px;
      width: 100%;
      overflow: hidden;
    }
    .message .text{
      max-width:200px;
    }
    
    .recived .text{
      float:left;
    }
    .text{
      padding: 5px 25px;
      border-radius: 6px;
      background: #eee;
      font-size: 20px;
      margin-bottom: 2px;
    }
    .sent .text{
      float: right;
      background: #000000;
      color: white;
      line-height: 25px;
    }
    div h2 {
      text-align: center;
      margin-top: 25vh;
      color: #b5b5b5;
      text-shadow: 1px 1px 1px #656565;
      font-weight: 400;
    }
</style>
