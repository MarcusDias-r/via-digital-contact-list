<template>

    <div class="modal-container" id="modal-container">
        <div class="modal">
            <div class="contact-info" v-if="contact">

                <div class="contact-info-header">
                    <div class="contact-info-photo" v-if="contact.photo">
                        <img :src="'storage/contact/'+contact.photo" alt="">
                    </div>

                    <div class="contact-info-name" v-if="contact.name">
                        <h2>{{contact.name}}</h2>
                    </div>
                </div>
                <div class="contact-info-body">

                    <div class="information-row">
                         <div class="information-box" v-if="contact.phone">
                            <span>Telefone</span>
                            <p>{{contact.phone}}</p>
                        </div>
                    </div>
                    <div class="information-row">
                        <div class="information-box" v-if="contact.email">
                            <span>Email</span>
                            <p>{{contact.email}}</p>
                        </div>
                        
                    </div>

                    <div class="information-row">
                        <div class="information-box" v-if="contact.cep">
                            <span>Cep</span>
                            <p>{{contact.cep}}</p>
                        </div>
                        <div class="information-box" v-if="contact.city">
                            <span>Cidade</span>
                            <p>{{contact.city}}</p>
                        </div>

                        <div class="information-box" v-if="contact.neighborhood">
                            <span>Bairro</span>
                            <p>{{contact.neighborhood}}</p>
                        </div>
                    </div>

                    <div class="information-row">
                        <div class="information-box" v-if="contact.address">
                            <span>Rua</span>
                            <p>{{contact.address}}</p>
                        </div>

                        <div class="information-box" v-if="contact.address">
                            <span>Número</span>
                            <p>{{contact.address_number}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
<script>


export default ({
    data(){
        return{
            contact:null,
        }
    },

    props:{
        selectedContact:Number
    },

    methods:{
        async loadContact()
        {
            let response = await axios.get(route('get.contact',{'id':this.selectedContact}))
            this.contact = response.data
        },
    },
    mounted()
    {
        this.loadContact();
    }
})
</script>

<style>
    .contact-info-body{
        padding: 10px 20px;
        border-radius: 20px;
        box-shadow: inset 0px 0px 10px #E5E7EB;
    }
    .modal-container{
        width: 100vw;
        height: 100vh;
        background-color: rgba(20, 20, 20, 0.5);
        position: fixed;
        top:  0px;
        left: 0px;
        z-index: 3000;
        justify-content: center;
        align-items: center;
        overflow-y:auto;
        display: flex;
    }
    
    .show-modal{
        display: flex;
    }

    .modal{
        display: flex;
        position: relative;
        align-items: flex-start;
        padding: 20px 10px;
        border-radius: 20px;
        box-shadow: 1px 1px 40px rgb(39, 39, 39);
        min-width: 500px;
        background-color: #F3F4F6;
        
    }
    .modal .contact-info{
        display: flex;
        flex-direction: column;
        padding: 25px;
        width: 100%;
    }
    .contact-info-header{
        display: flex;
        justify-content: flex-start;
        width: 100%;
        align-items: center;
    }
    .contact-info-photo{
        display: flex;
        justify-content: center;
        align-items: center;
        height: 150px;
        width: 150px;
        border-radius: 50%;
        background: teal;
        overflow: hidden;
    }
    .contact-info-photo img{
        height: 100%;
    }
    .contact-info-name{
        margin-left: 20px;
    }
    .contact-info-body{
        display: flex;
        flex-direction: column;
        margin-top: 20px;
        width: 100%;
        justify-content: flex-start;
    }
    .information-row{
        display: flex;
    }
    .information-box{
        flex: 1;
        padding: 15px;
    }
    .information-box span{
        font-weight: 600;
    }
    .information-box p{
        margin-top: 10px;
    }
    

</style>