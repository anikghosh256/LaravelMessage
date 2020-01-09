<template>
    <div class="contacts col-3">
        <ul>
        	<li v-for="contact in sortedContacts" :key="contact.id" @click="selectContact(contact)" :class="{ 'selected': contact == selected }">
        		<p class="text-nowrap" >{{ contact.name }}
                <span class="unread" v-if="contact.unread">{{ contact.unread }}</span>
                <span class="last_mess"> {{ (contact.lastMess && contact.lastMess.length > 10) ? contact.lastMess.substr(0, 10) : ''  }}... </span>
                </p>
                
        	</li>
        </ul>
    </div>
</template>

<script>
    export default {
    	data(){
    		return{
				selected: this.contacts.length ? this.contacts[0] : null
    		};
    	},
		props: {
			contacts:{
				type: Array,
				defauld: []
			}
		},
		methods:{
			selectContact(contact){
				this.selected= contact;
				this.$emit('selected', contact);
			}
		},
        computed: {
            sortedContacts() {
                return _.sortBy(this.contacts, [(contact) => {
                    if (contact == this.selected) {
                        return Infinity;
                    }

                    return contact.unread;
                }]).reverse();
            }
        }
    }
</script>
<style scoped>
    .contacts{
    	padding-bottom:10px;
    	padding-right:0px;
    	border-right: 1px solid #eee;
    	max-height: calc( 95vh - 48px);
        overflow:auto;
        scroll-behavior: smooth;
    }
    ul{
    	margin:0px;
    	padding:0px;
    }
    li{
    	list-style: none;
	    width: 100%;
	    border-bottom: 1px solid #eee;
	    padding: 10px 15px;
	    font-size: 18px;
	    font-weight: bold;
	    color: #3c3c3c;
	    background:#fbfbfb;
	    transition:.5s;
	    max-height:54px;
        overflow:hidden;
    }
    li p{
        margin-bottom: 0px;
        width:100%;
        overflow:hidden
    }
    li p span.unread{
        padding: 6px;
        background: #eee;
        border-radius: 5px;
        font-size: 13px;
        position: absolute;
        right: 4px;
    }
    li p span.last_mess{
        display: block;
        font-size: 14px;
        color: #868585;
        margin-top: -6px;
        font-weight: 300;
    }
    .selected{
    	background:#dcdcdc;
    }
    li:hover{
    	background:#dcdcdc;
    	cursor:pointer;
    }
</style>
