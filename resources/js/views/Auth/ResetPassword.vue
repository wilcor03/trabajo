<template>
    <div id="reset-password">
        <v-container>
        <div
            id="e3"
            style="max-width: 400px; margin: auto;"
            class="grey lighten-3"
        >
            <v-toolbar
            color="cyan"
            dark
            >
            <v-toolbar-side-icon></v-toolbar-side-icon>
            <v-toolbar-title>Cambio de contraseña</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn icon>
                <v-icon>home</v-icon>
            </v-btn>
            </v-toolbar>

            <v-card>
            <v-container
                fluid
                grid-list-lg
            >
                <v-layout row wrap v-if="showForm && !redirect">
                <v-flex xs12>
                    <v-card>
                    <v-card-title primary-title>
                        Cambiar contraseña
                    </v-card-title>
                    <v-card-text ref="form">
                        <v-text-field
                        v-model="user.password"
                        :append-icon="showPass ? 'visibility' : 'visibility_off'"                    
                        :type="showPass ? 'text' : 'password'"
                        name="input-10-1"
                        label="Nueva contraseña"
                        hint="Al menos 8 caracteres"
                        @click:append="showPass = !showPass"      
                        :rules="passwordRules"                  
                        ></v-text-field>

                        <v-text-field
                        v-model="user.password_confirm"
                        :append-icon="showPass ? 'visibility' : 'visibility_off'"                    
                        :type="showPass ? 'text' : 'password'"
                        name="input-10-1"
                        label="Confirme la nueva contraseña"
                        hint="Al menos 8 caracteres"
                        @click:append="showPass = !showPass"
                        :rules="passwordConfirmRules"
                        ></v-text-field>

                    </v-card-text>
                    <v-card-actions>
                        <v-btn @click="submit" color="info" block>Cambiar contraseña</v-btn>
                    </v-card-actions>
                    </v-card>
                </v-flex>
                </v-layout>
                <v-layout v-if="showError && !redirect">
                    <v-flex>
                        <v-alert
                            :value="true"
                            type="error"
                            >
                            Error en el token o esta vencido, solicite uno nuevo!
                        </v-alert>                    
                        <v-btn color="info" :to="{name:'auth.link-reset-pass'}">Solicitar nuevo token</v-btn>
                    </v-flex>
                    
                </v-layout>
                <v-layout v-if="redirect">
                    <v-flex>
                        <v-alert
                            :value="true"
                            type="success"
                            >
                            Exito!
                        </v-alert>   
                        <br>                 
                        <p class="text-md-center">
                            Contraseña cambiada! ... Redireccionando...
                        </p>
                    </v-flex>
                    
                </v-layout>
            </v-container>
            </v-card>
        </div>
        </v-container>
    </div>
</template>
<script>
export default {
    data:() => ({
        user:{
            password:null,
            password_confirm:null
        },
        showPass:false,
        showForm:false,
        showError:false,
        info:null,
        redirect:false,
        passwordRules:[
            v => !!v || 'Campo requerido!',
            v => (v && v.length >= 8) || 'Inserte por lo menos 8 caractéres!'
        ],
        passwordConfirmRules:[
            v => !!v || 'Campo requerido!',
            v => (v && v.length >= 8) || 'Inserte por lo menos 8 caractéres!',
            v => (v && this.user.password == v) || 'Los campos no coinciden!'
        ]
        
    }),
    mounted(){
        const token = this.$route.params.token;
        axios.get('/api/password/find/' + token).then(res => {
            if(res.status == 200){
                this.showForm = true;
            }
            this.info = res.data;
        }).catch(err => {
            this.showError = true;
        });
    },
    methods:{
        submit(){
            if(!this.info){
                return;
            }
            const data = {
                email: this.info.email,
                password:this.user.password,
                password_confirmation:this.user.password_confirm,
                token:this.info.token
            }

            axios.post('/api/password/reset', data).then(res => {
                this.redirect = true;
                setTimeout(() => {
                    this.$router.push({name:'auth.login'});
                }, 3000);                
            });
        }
    }
}
</script>

<style>

</style>
   