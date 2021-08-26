<template>

    <section class="main-area">
        <main class="container">
            <div class="contact-list-title">
                <p>Contatos</p> 
            </div>

            <div class="list-header">
                <form action="">
                    <input class="search-input" v-model="search" type="search" placeholder="Pesquisar ... ">
                </form>

                <div class="header-btn" @click="newContactWindow('new-contact-area')">
                    <img src="icon/plus.png" alt="">
                </div>
            </div>

            <div class="contact-list" v-if="contacts">

                <div class="contact" v-for="c in contacts" :key="c.id">
                    <div class="contact-header">
                        <div class="contact-info" @click="openContact(c.id)">
                            <div class="contact-photo-frame">
                                <img :src="'storage/contact/'+c.photo" alt="">
                            </div>
                            <p>{{c.name}}</p>
                        </div>

                        <div class="btn-area">
                            <a class="btn-edit" href="javascript:" @click="editContact(c.id)"><img src="icon/pencil.png" alt=""></a>
                            <a class="btn-destroy" href= "javascript:" @click="deleteContact(c.id)"><img src="icon/bin.png" alt=""></a>
                        </div>

                    </div> 
                </div>
               
            </div>
                <template v-if="openedWindow === 'new-contact-area'">
                    <contact-new @cleanId="cleanId"></contact-new>
                </template>

                <template v-if="contactId !== null">
                    <contact-edit :contactId="contactId" @cleanId="cleanId"></contact-edit>
                </template>

                <div id="contactModal" style="display:none">
                    <contact-show v-if="selectedContact !== null" :selectedContact="selectedContact"></contact-show>
                </div>

        </main>
    </section>
    

</template>
<script>
import ContactNew  from '@/Components/ContactNew'
import ContactEdit from '@/Components/ContactEdit'
import ContactShow from '@/Components/ContactShow'


    export default ({
        components:{
            ContactNew,
            ContactEdit,
            ContactShow,
        },

        data(){
            return{
                contacts:null,
                contactId:null,
                openedWindow:null,
                dropdown:null,
                modal:false,
                selectedContact:null,
                search:'',
            }
        },

        methods:{
            newContactWindow(classname)
            {
               this.openedWindow = classname;
               setTimeout(()=>{
                   this.showPage(classname)
               },300) 
            },

            getContacts(){
                axios.get(route('get.contacts')).then(
                    response=>{
                        this.contacts = response.data
                    }
                )
            },

            showPage(className){
               this.openedWindow = className;
               let section =  document.querySelector('.'+className)
             
                if(section.classList.contains('hide')){
                    section.classList.remove('hide');
                }
            },

            editContact(id){
              
                this.contactId = id;
                if(this.contactId !== null)
                {
                    setTimeout(()=>{
                        this.showPage('edit-contact-area')
                    },400)
                }
            },

            cleanId()
            { 
                if(this.contactId !== null){
                    setTimeout(()=>{
                        this.contactId = null;
                        this.openedWindow = null;
                    },500)
                }

                if(this.openedWindow === 'new-contact-area'){
                    setTimeout(()=>{
                        this.openedWindow = null;
                    },500)
                }
                
                this.getContacts();
            },


            deleteContact(id)
            {
                // console.log(id);
                var result = confirm('Esse contato será removido da lista');
                if(result === true){
                    axios.delete(route('contact.destroy',{'contact':id})).then(
                        response=>{
                            this.getContacts();
                        }
                    )
                }
            },

            openContact(id)
            {
                this.selectedContact = id
                
                const modal = document.getElementById('contactModal');
                modal.style.display = 'flex'

                modal.addEventListener('click',(event)=>{

                    if(event.target.id === "modal-container"){
                        modal.style.display = 'none';
                        this.selectedContact = null
                    }
                })
            }
        },
        
        watch:{
            search:function(val)
            { 
                if(String(val).length >= 1)
                { 
                    axios.post(route('search.contact'),{'contact':val})
                    .then(
                        response =>{
                            this.contacts = response.data
                    }).catch(
                        error =>{
                    })
                
                }else{
                    setTimeout(()=>{
                        this.getContacts();
                    },300)
                }
            },
        },

        mounted(){
            this.getContacts();
        }
    })


</script>

<style>
    .btn-area{
        display: flex;
    }
    .btn-area a{
        display: flex;
        justify-content: center;
        align-items: center;
        height: 25px;
        width: 25px;
        border-radius: 5px;
        text-decoration: none;
        box-shadow: 0px 0px 5px rgb(114, 114, 114);
    }
    .btn-edit{
        background: rgb(3, 156, 3);
    }
    .btn-destroy{
        background: rgb(190, 20, 20);
    }
    .btn-area a:nth-child(1)
    {
        margin-right: 10px;
    }

    .btn-area img{
        height: 70%;
    }
    
</style>