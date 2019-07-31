<template>
    <div id="profile-edit">
    
        <v-layout row wrap>
        <v-flex xs12 sm6 offset-sm3>
            <v-card>

            <v-toolbar color="light-blue">
                <v-toolbar-side-icon @click="goBack()"><v-icon color="white">mdi-arrow-left</v-icon></v-toolbar-side-icon>
                
                <v-toolbar-title class="white--text">Datos de mi empresa</v-toolbar-title>
            </v-toolbar>
            <v-card-text class="grey lighten-5">
                <profile-form/>
            </v-card-text>
            </v-card>
            </v-flex>
        </v-layout>
    
    </div>
</template>
<script>
import ProfileForm from '../../../components/employer/ProfileForm.vue';
export default {
    components:{
        'profile-form': ProfileForm
    },
    methods:{        
        goBack(){
            this.$router.push({name:'employer.profile'})
        }
    }
}
</script>
