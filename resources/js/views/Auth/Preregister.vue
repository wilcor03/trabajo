<template>
<div id="preregister">
  <v-container>
    <v-layout row wrap>
      <v-flex xs12 sm6 offset-sm3>
        <v-card>
          <v-toolbar color="light-blue">
            <v-toolbar-side-icon><v-icon color="white">home</v-icon></v-toolbar-side-icon>        
            <v-toolbar-title class="white--text">{{ currentTitle }}</v-toolbar-title>
          </v-toolbar>

          <v-divider></v-divider>

          <v-card-actions>
            <v-layout>
              <v-flex xs12 md6 mr-1>
                <v-card>
                  <div class="pa-3 text-xs-center">                    
                    <div class="mb-3" height="128" contain>
                      <v-icon color="indigo" size="128">mdi-office-building</v-icon>
                    </div>                   

                    <h3 class="title font-weight-light mb-2">Publicar ofertas de empleo</h3>                    
                    <span class="caption grey--text">Empleadores</span>
                  </div>
                  <v-card-actions>
                    <v-btn block color="orange" :to="{name:'auth.register', params:{type:2}}">Registro como Empleador</v-btn>                    
                  </v-card-actions>
                </v-card>
              </v-flex>

              <v-flex xs12 md6>
                <v-card>
                  <div class="pa-3 text-xs-center">                    
                    <div class="mb-3" height="128" contain>
                      <v-icon color="purple" size="128">mdi-account-arrow-right-outline</v-icon>
                    </div>                   

                    <h3 class="title font-weight-light mb-2">Publicar mi hoja de vida online</h3>                    
                    <span class="caption grey--text">Trabajadores</span>
                  </div>
                  <v-card-actions>
                    <v-btn block color="orange" :to="{name:'auth.register', params:{type:3}}">Registro como Trabajador</v-btn>                    
                  </v-card-actions>
                </v-card>
              </v-flex>
            </v-layout>
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</div>
</template>
<script>
export default {
  data:()=>({
    currentTitle:'Que desea hacer?'
  })
}
</script>