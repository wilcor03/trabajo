<template>
  <div id="genera-info"> 

    <v-card flat>
    <v-toolbar
      color="primary"
      dark
      extended
      flat
    >
      <v-toolbar-side-icon></v-toolbar-side-icon>

      <v-toolbar-title class="white--text">ConTabilizalo.com - Empleo</v-toolbar-title>
      <v-spacer></v-spacer>
      <span class="text-uppercase">{{ profileGet.name }}</span>
    </v-toolbar>

    <v-layout row pb-2>
      <v-flex xs8 offset-xs2>
        <v-card class="card--flex-toolbar">
          
          <v-toolbar card prominent>
            <v-toolbar-title class="body-2 grey--text"><strong>PERFIL DEL TRABAJADOR </strong></v-toolbar-title>
            <v-spacer></v-spacer>            

            <v-menu bottom left>
              <template v-slot:activator="{ on }">
                <v-btn                  
                  icon
                  v-on="on"
                >
                  <v-icon>more_vert</v-icon>
                </v-btn>
              </template>

              <v-list>
                <v-list-tile @click="logout">
                  <v-list-tile-title>Cerrar Sesión</v-list-tile-title>
                </v-list-tile>
              </v-list>
            </v-menu> 
          </v-toolbar>

          <v-divider></v-divider>

          <v-card-title primary-title>
            <div>
              <div class="headline">Actualice su perfil</div>
              <span class="grey--text">Complete y mantenga actualizado su perfil de trabajador, ésto nos ayudará a encontrar 
                la mejor opción de trabajo para usted.
              </span>
            </div>
          </v-card-title>         

          <v-card-text>
            <v-layout>
              <v-flex>
                <v-card              
                  class="mx-auto"
                >
                  <v-card-title class="text-md-center">
                    <span>Completado de perfil: &nbsp;</span>
                    <span class="success--text" v-if="complete == 100"> 
                      <strong><u>                        
                        Gracias por completar su perfil!
                        </u> <v-icon color="success" right>mdi-check</v-icon></strong>
                    </span>
                    <v-progress-linear
                      v-model="complete"
                      color="blue-grey"
                      height="25"
                      reactive
                      :buffer-value="100"
                    >
                      <strong>{{ Math.ceil( (profileComplete) * 25 ) }}%</strong>
                    </v-progress-linear>                      
                  </v-card-title>                            
                </v-card>
              </v-flex>              
            </v-layout>           
            <v-layout sm6 v-if="selectedTab">              

              <v-stepper v-model="element" style="width:100%;">
                <v-stepper-header>
                  <v-stepper-step :complete="hasProfile" editable step="1">Información general</v-stepper-step>
                  <v-divider></v-divider>        
                  <v-stepper-step :complete="hasCategories" :editable="hasProfile" step="2">Categorías de interes</v-stepper-step>
                  <v-divider></v-divider>
                  <v-stepper-step :complete="hasExperiences" :editable="hasCategories" step="3">Experiencia laboral</v-stepper-step>
                  <v-divider></v-divider>
                  <v-stepper-step :complete="hasStudies" :editable="hasExperiences" step="4">Estudios</v-stepper-step>        
                </v-stepper-header>

                <v-stepper-items>                   
                    
                  <v-stepper-content step="1">
                    <preloader v-if="!hasProfile && loading"/>
                    <profiles/> 
                    <div v-if="hasProfile" class="text-md-right text-xs-center">
                      <v-btn color="indigo" outline @click="$store.commit('GeneralStore/setSelectedStep', 2)">
                      Continuar <v-icon>arrow_forward</v-icon>
                      </v-btn>           
                    </div>
                  </v-stepper-content>    

                  <v-stepper-content step="2">  
                    <!--<template v-if="element == 2">-->
                    <template>
                      <preloader v-if="loadingCateg"/>              
                      <categories/>  
                      <div v-if="hasCategories" class="text-md-right text-xs-center">
                        <v-btn color="indigo" outline @click="$store.commit('GeneralStore/setSelectedStep', 3)">
                          Continuar <v-icon>arrow_forward</v-icon>
                        </v-btn>           
                      </div>                  
                    </template>
                  </v-stepper-content>    

                  <v-stepper-content step="3">  
                    <!--<template v-if="element == 3">-->
                    <template>
                      <preloader v-if="experienceLoading" />              
                      <experiences/> 
                      <br>    
                      <div v-if="hasExperiences" class="text-md-right text-xs-center">
                        <v-btn color="indigo" outline @click="$store.commit('GeneralStore/setSelectedStep', 4)">
                          Continuar <v-icon>arrow_forward</v-icon>
                        </v-btn>               
                      </div>         
                    </template>          
                  </v-stepper-content>  

                  <v-stepper-content step="4">   
                    <!--<template v-if="element == 4">         -->
                    <template>
                      <preloader v-if="studyLoading" />              
                      <studies/>              
                    </template>       
                  </v-stepper-content>         

                </v-stepper-items>
              </v-stepper>
            </v-layout>
          </v-card-text>
          
        </v-card>
      </v-flex>
    </v-layout>
  </v-card>  
</div>
</template>
<script>
import Preloader from '../components/partials/Preloader';

// COMPONENTS
import Profiles from './profiles/Profiles'
import Experiences from './experiences/Experiences'
import Studies from './studies/Studies'
import Categories from './categories/Categories'
import { mapGetters } from 'vuex';

export default {  
  components:{
    'preloader': Preloader,
    'profiles': Profiles,
    'experiences': Experiences,
    'studies': Studies,
    'categories': Categories
  },
  data () {
    return {
      element: 1,
      complete:0      
    }
  },
  computed:{  
    ...mapGetters('ProfileStore', ['profileGet']),
    loading(){
      return this.$store.state.ProfileStore.loading;
    },  
    loadingCateg(){
      return this.$store.state.CategoryStore.loading;
    },
    experienceLoading(){
      return this.$store.state.ExperienceStore.loading;
    },
    studyLoading(){
      return this.$store.state.StudyStore.loading;
    },
    hasProfile(){
      const profile = this.$store.state.ProfileStore.Profile;      
      if(profile)
      {
        if(profile.nombre != "" && profile.description != "" && profile.birthDay != ""){
          return true;
        }        
      }
      return false;
    },
    hasExperiences(){
      if(this.$store.state.ExperienceStore.experiences[0] !== undefined){
        return true;
      }      
      return false;
    },
    hasStudies(){
      if(this.$store.state.StudyStore.studies[0] !== undefined){
        return true;
      }      
      return false;
    },
    hasCategories(){
      const categs = this.$store.state.CategoryStore.categories;
      if(categs[0] !== undefined){        
        const pos = categs.findIndex(item => {
          return item.selected == true;
        });
        if(pos != -1){
          return true;
        }        
      }      
      return false;
    },
    selectedTab(){
      this.element =  this.$store.state.GeneralStore.selectedStep
      return this.element
    },
    profileComplete(){
      let complete = 0;
      this.complete = 0;
      if(this.hasProfile){
        complete += 1;      
        this.complete += 25;          
      }

      if(this.hasCategories){
        complete+=1;
        this.complete += 25;
      }

      if(this.hasExperiences){
        complete+=1;
        this.complete += 25;
      }

      if(this.hasStudies){
        complete+=1;
        this.complete += 25;
      }
      return complete;
    }
  },
  watch:{
    element(val){
      this.$store.commit('GeneralStore/setSelectedStep', val);
    }
  },
  methods:{
    logout(){      
      this.$store.dispatch('AuthStore/logout');      
      this.$router.push({name:'auth.login'});
    }
  }
}
</script>