<template>
    <section class="new-contact-area hide">
        <div class="contact-list-title">
            <p>Criar Contato</p> 
        </div>

        <div class="return-btn" @click="hideMe('new-contact-area')">
            <img src="icon/arrow.png"><p>Retornar para a tela principal</p> 
        </div>

        <div class="new-contact-form-container">
            
            <form @submit.prevent="saveContact">
                <div class="input-row">
                    <div class="input-area file-label">
                        <label for="photo">Inserir foto</label>
                        <input type="file" style="display:none" id="photo"  @input="form.photo = $event.target.files[0]">
                    </div>
                    <div class="input-area error-area" v-if="errors" >
                        <ul>
                            <li class="error" v-for="error in errors" :key="error">{{error[0]}}</li>
                        </ul>
                    </div>
                </div>
               
                <div class="input-area">
                    <label for="name">Nome do Contato</label>
                    <input type="text" id="name" v-model="form.name">
                </div>

                <div class="input-row">
                    <div class="input-area">
                        <label for="type-of-contact">Tipo de Contato</label>
                        <input type="text" id="type-of-contact" v-model="form.contact_type">
                    </div>
                    <div class="input-area">
                        <label for="phone">Telefone</label>
                        <input type="text" id="phone" v-model="form.phone" v-mask="['(##) ####-####','(##) #####-####']">
                    </div>
                </div>

                <div class="input-area">
                    <label for="email">Email</label>
                    <input type="email" id="email" v-model="form.email">
                </div>

                <div class="input-row">
                    <div class="input-area">
                        <label for="cep">CEP</label>
                        <input type="text" id="cep" v-model="form.cep" v-mask="'#####-###'">
                    </div>
                    <div class="input-area">
                        <label for="city">Cidade</label>
                        <input type="text" id="city" v-model="form.city">
                    </div>
                </div>

                <div class="input-row">
                    <div class="input-area address">
                        <label for="address">Rua</label>
                        <input type="text" id="address" v-model="form.address">
                    </div>

                    <div class="input-area address_number">
                        <label for="number">Nº</label>
                        <input type="text" id="number" v-model="form.address_number" v-mask="'########'">
                    </div>
                </div>

                <div class="input-area">
                    <label for="neighb">Bairro</label>
                    <input type="text" id="neighb" v-model="form.neighb">
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
    data(){
        return{
            form:{
                photo:'',
                name:'',
                contact_type:'',
                phone:'',
                email:'',
                cep:'',
                city:'',
                address:'',
                address_number:'',
                neighb:'',
            },
            errors:[]
        }
    },

    methods:{

        saveContact()
        {
            const formData = new FormData();
            if(this.form.photo)
            {
                formData.append('photo', this.form.photo)
            }
                formData.append('name', this.form.name)
                formData.append('contact_type', this.form.contact_type)
                formData.append('phone', this.form.phone)
                formData.append('email', this.form.email)
                formData.append('cep', this.form.cep)
                formData.append('city', this.form.city)
                formData.append('address', this.form.address)
                formData.append('address_number', this.form.address_number)
                formData.append('neighb', this.form.neighb)
            

            axios.post(route('contact.store'),formData).then(
                response=>{
                    this.hideMe('new-contact-area');
                    this.form.photo          = null;
                    this.form.name           = null;
                    this.form.contact_type   = null;
                    this.form.phone          = null;
                    this.form.email          = null;
                    this.form.cep            = null;
                    this.form.city           = null;
                    this.form.address        = null;
                    this.form.address_number = null;
                    this.form.neighb         = null;
                }
            ).catch(error=>{
                if(error.response.status == 422){
                    this.errors = error.response.data.errors
                }
            })
        },

        hideMe(className)
        {
            let section =  document.querySelector('.'+className)
                if(!section.classList.contains('hide')){
                    section.classList.add('hide');
                }
            this.$emit('cleanId');
        },
        
        
    }
    
})
</script>
