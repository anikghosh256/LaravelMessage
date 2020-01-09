<template>
      <div class="mess-composer">
          <textarea v-model="message"  @keydown.enter="send" placeholder="Message..."></textarea>
          <button @click="btnSend">Send</button>
      </div>
</template>

<script>
    export default {
       data() {
        return{
          message: ''
        }
       },
       methods:{
        send(e){
            e.preventDefault();
                
            if (this.message == '') {
                return;
            }
            this.$emit('send', this.message);
            this.message = '';
        },
        btnSend(){
          if (this.message == '') {
                return;
            }
            this.$emit('send', this.message);
            this.message = '';
        }
       }
    }
</script>
<style scoped>
    
    .mess-composer{
        margin-bottom:8px;
        overflow:hidden;
    }
    textarea{
        width: 86%;
        float: left;
        height: 50px;
        resize: none;
        padding: 5px;
        padding-top: 12px;
        border-radius: 5px;
        margin-left: 3px;
    }
    button{
        width:12%;
        float:right;
        height: 50px;
        margin-right:1%;
    }
    @media screen and (max-width: 600px) {
      button{
        width: 17%;
        font-size: 13px;
      }
      textarea{
        width: 81%;
      }
    }
    @media screen and (max-width: 430px) {
      button{
        width: 18%;
        font-size: 11px;
      }
      textarea{
        width: 78%;
      }
    }
</style>
