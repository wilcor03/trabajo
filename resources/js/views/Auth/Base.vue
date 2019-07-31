<template>
    <div id="base-auth"> 
        <v-toolbar dark color="primary">
            <v-toolbar-side-icon><v-icon>home</v-icon></v-toolbar-side-icon>

            <v-toolbar-title class="white--text">Contabilizalo.com - Empleo</v-toolbar-title>

            <v-spacer></v-spacer>

            <v-toolbar-items class="hidden-sm-and-down">
            <v-btn flat><v-icon left>mdi-arrow-left-circle-outline</v-icon> Blog Contabilizalo</v-btn>
            <v-btn flat :to="{name:'auth.login'}"><v-icon left>mdi-login</v-icon>Ingresar</v-btn>      
            <v-btn flat :to="{name:'auth.register'}"><v-icon left>mdi-account-plus-outline</v-icon> Registrarse</v-btn>
            </v-toolbar-items>
        </v-toolbar>       
        <router-view></router-view>
    </div>
</template>
<script>
export default {
    
}
</script>