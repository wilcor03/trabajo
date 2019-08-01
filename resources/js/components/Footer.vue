<template>
  <v-footer
    dark
    height="auto"
    width="auth"        
  >
    <v-card
      flat
      tile
      class="indigo lighten-1 white--text text-xs-center"
    >
      <v-card-text>
        <v-btn          
          class="mx-3 white--text"
          flat
          round
          @click="goOutSide('https://www.facebook.com/Contabilizalocom-559714470714981')"
        >
          FACEBOOK
          <v-icon right size="24px">mdi-facebook</v-icon>          
        </v-btn>
        <v-btn
          class="mx-3 white--text"
          flat
          round
          @click="goOutSide('https://www.youtube.com/user/ContabilizaloCom')"
        >
        YOUTUBE
          <v-icon right size="24px">mdi-youtube</v-icon>
        </v-btn>

        <v-btn
        color="white"
        flat
        round
        @click="goOutSide('https://contabilizalo.com')"
      >
        BLOG CONTABLE
        <v-icon right>mdi-link</v-icon>
      </v-btn>
      </v-card-text>

      <v-card-text class="white--text pt-0">
        <p>Dudas, preguntas y/o sugerencias al correo: <strong><a href="mailto:contabilizalo.com@gmail.com" target="_blank" class="yellow--text">contabilizalo.com@gmail.com</a></strong></p>
        <a style="color:white;" href="https://contabilizalo.com" target="_blank">
        <strong>ConTabilizalo.com</strong>
        </a> es una comunidad contable y pone a disposición del público ésta herramienta, que permitirá a empresas y trabajadores interactuar de manera eficiente. Aquí podrá publicar ofertas de trabajo y también podrá encontrar ofertas de empleo que se acomoden a su necesidad!
      </v-card-text>

      <v-divider></v-divider>

      <v-card-text class="white--text">
        &copy;2019 — 
        <a style="color:white;" href="https://contabilizalo.com" target="_blank">
          <strong>ConTabilizalo.com</strong>
        </a>
      </v-card-text>
    </v-card>
  </v-footer>
</template>

<script>
  export default {
    methods:{
      goOutSide(url){
        window.open(url)
      }
    }
  }
</script>