<template>
    <section class="edit-contact-area hide" v-if="contact && contact.name">
        <div class="contact-list-title">
            <p>Editar Contato</p> 
        </div>

        <div class="return-btn" @click="hideMe('edit-contact-area')">
            <img src="icon/arrow.png"><p>Retornar para a tela principal</p> 
        </div>

        <div class="new-contact-form-container">

            <form @submit.prevent="changePhoto">
                 <div class="input-row">
                    <div class="input-area file-label">
                        <label for="photo">Inserir foto</label>
                        <input type="file" style="display:none" id="photo" @change="changePhoto()" @input="form.photo = $event.target.files[0]">
                    </div>
                    <div class="input-area error-area" v-if="errors" >
                        <ul>
                            <li class="error" v-for="error in errors" :key="error">{{error[0]}}</li>
                        </ul>
                    </div>
                </div>
            </form>
            

            <form @submit.prevent="editSave">
                

                <div class="input-area">
                    <label for="name">Nome do Contato</label>
                    <input type="text" id="name" name="name" :value="contact.name">
                </div>

                <div class="input-row">
                    <div class="input-area">
                        <label for="type-of-contact">Tipo de Contato</label>
                        <input type="text" id="type-of-contact" name="type" :value="contact.type_of_contact">
                    </div>
                    <div class="input-area">
                        <label for="phone">Telefone</label>
                        <input type="text" id="phone" name="phone" :value="contact.phone" v-mask="['(##) ####-####','(##) #####-####']">
                    </div>
                </div>

                <div class="input-area">
                    <label for="email">Email</label>
                    <input type="email"  id="email" name="email" :value="contact.email">
                </div>

                <div class="input-row">
                    <div class="input-area">
                        <label for="cep">CEP</label>
                        <input type="text"  id="cep" name="cep" :value="contact.cep" v-mask="'#####-###'">
                    </div>
                    <div class="input-area">
                        <label for="city">Cidade</label>
                        <input type="text"  id="city" name="city" :value="contact.city">
                    </div>
                </div>

                <div class="input-row">
                    <div class="input-area address">
                        <label for="address">Rua</label>
                        <input type="text" id="address" name="address" :value="contact.address">
                    </div>

                    <div class="input-area address_number">
                        <label for="number">Nº</label>
                        <input type="text" id="number" name="number" :value="contact.address_number" v-mask="'########'">
                    </div>
                </div>

                <div class="input-area">
                    <label for="neighb">Bairro</label>
                    <input type="text" name="neighb" id="neighb" :value="contact.neighborhood">
                </div>

                <button>Salvar</button>
            </form>
        </div>
    </section>
</template>
<script>
import {mask} from 'vue-the-mask'
export default({
    directives: {mask},
    props:{
        contactId:Number
    },
    data(){
        return{
            form:{
                photo:null
            },
            contact:null,
            errors:[],
        }
    },

    methods:{

        saveContact()
        {
            axios.post(route('contact.store'),{'edit':this.edit}).then(
                response=>{
                    
                }
            )
        },

        hideMe(className)
        {
            let section =  document.querySelector('.'+className)
                if(!section.classList.contains('hide')){
                    section.classList.add('hide');
                }
            this.$emit('cleanId')
        },

        async loadContact()
        {
            let response = await axios.get(route('get.contact',{'id':this.contactId}))
            this.contact = response.data
        },

        editSave()
        {
            const {name, type, phone, email, cep, city, address, number, neighb} = Object.fromEntries(new FormData(event.target));
            axios.put(route('contact.update',{'contact':this.contactId}),{
                name, type, phone, email, cep, city, address, number, neighb
            }).catch(error=>{
                if(error.response.status == 422){
                    this.errors = error.response.data.errors
                }
            })
            
            this.hideMe('edit-contact-area')
        },

        async changePhoto(){
            
            const formData = new FormData();

            if(this.form.photo)
            {
                formData.append('photo', this.form.photo)
                formData.append('id', this.contactId)
            }

            axios.post(route('change.photo'),formData).catch(error=>{
                if(error.response.status == 422){
                    this.errors = error.response.data.errors
                }
            })
        }
    },
    
    mounted()
    {
        this.loadContact()
    }

    
})
</script>
