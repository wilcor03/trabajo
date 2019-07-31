<template>
  <div>
    <v-toolbar flat color="white">
      <v-toolbar-title>Mis estudios</v-toolbar-title>
      <v-divider
        class="mx-2"
        inset
        vertical
      ></v-divider>
      <v-spacer></v-spacer>
      <v-dialog v-model.lazy="dialog" max-width="500px">
        <template v-slot:activator="{ on }">
          <v-btn color="primary" dark class="mb-2" v-on="on" @click="openModal">Añadir</v-btn>                          
        </template>
        <v-card>
          <v-card-title>            
            <v-progress-linear v-if="saving" :indeterminate="true"></v-progress-linear>
            <span class="headline">{{ formTitle }}</span>            
          </v-card-title>

          <v-card-text>
            <v-container grid-list-md> 
              <div v-if="saved && !saving">
                <v-alert
                  :value="true"
                  color="success"
                  icon="check_circle"
                  outline
                >
                  Elemento guardado con exito!!
                </v-alert>
              </div>

              <form @submit.prevent="submit">
              <v-layout wrap>                  
                <v-flex xs12 sm6>
                  <v-text-field 
                    v-model="study.institution" 
                    ref="inst"
                    label="Institución educativa"                     
                    hint="Institución donde realizó sus estudios"
                    @input="$v.study.institution.$touch()"
                    @blur="$v.study.institution.$touch()"
                    :error-messages="institutionErrors"       
                    :counter="100"
                  ></v-text-field>
                </v-flex>
                <v-flex xs12 sm6>
                  <v-text-field v-model="study.title" 
                  label="Título obtenido"
                  hint="Ejemplo: Contador, técnico contable"
                  @input="$v.study.title.$touch()"
                  @blur="$v.study.title.$touch()"
                  :error-messages="titleErrors"       
                  :counter="100"
                  ></v-text-field>
                </v-flex>        
                <v-flex xs12 sm6>
                  <v-text-field v-model="study.time" 
                    label="Tiempo de estudio" 
                    hint="Ejemplo: 2 años"
                    @input="$v.study.time.$touch()"
                    @blur="$v.study.time.$touch()"
                    :error-messages="timeErrors"       
                    :counter="50"
                  >
                  </v-text-field>
                </v-flex>                
                
              </v-layout>              

              <v-btn color="blue darken-1" flat type="submit">Guardar</v-btn>
              <v-btn color="blue darken-1" flat @click="close">Cancelar</v-btn>

              </form>
            </v-container>
          </v-card-text>              
          
        </v-card>
      </v-dialog>
    </v-toolbar>

    <v-progress-linear v-if="saving" :indeterminate="true"></v-progress-linear>

    <v-data-table
      :headers="headers"
      :items="studies"
      class="elevation-1"
      rowsPerPageText='Items por página'
      rowsPerPageAll="10"      
    >     

      <template v-slot:items="props"> 
        <td class="text-xs-left">{{ props.item.institution.substr(0,20) }}...</td>
        <td class="text-xs-left">{{ props.item.title.substr(0,20) }}...</td>
        <td class="text-xs-left">{{ props.item.time }}</td>        
        <td class="justify-center layout px-0">
            <v-icon
            small
            class="mr-2 mt-3"
            color="info"
            @click="editItem(props.item)"
            >
            edit
            </v-icon>
            <v-icon
            class="mr-2 mt-3"
            color="error"
            small
            @click="deleteItem(props.item)"
            >
            delete
            </v-icon>
        </td>
      </template> 
      <template v-slot:no-data>
        <v-alert :value="true" color="warning" icon="warning">
          Por favor inserte almenos un datos sobre sus estudios.
        </v-alert>
      </template>         
    </v-data-table>
  </div>
</template>
<script>
import { validationMixin } from 'vuelidate'
import { required, minLength, maxLength } from 'vuelidate/lib/validators';
import { createNamespacedHelpers } from 'vuex';
const { mapActions, mapState } = createNamespacedHelpers('StudyStore');
export default {
    mixins: [validationMixin],
    validations: {
      study: {        
        institution:{required, minLength:minLength(3), maxLength:maxLength(100)},
        title:{required, minLength:minLength(3), maxLength:maxLength(100)},
        time:{required, minLength:minLength(3), maxLength:maxLength(100)},        
      }
    }, 
    data: () => ({      
      study:{
        institution:'',
        title:'',
        time:'',        
      },      
      headers: [
        {
          text: 'Institución',
          align: 'left',
          sortable: false,
          value: 'institution'
        },                
        { text: 'Titulo optenido', value: 'title' },
        { text: 'Tiempo de estudio', value: 'time' }                
      ]      
    }),

    computed: {
      ...mapState(['studies', 'saving', 'dialog', 'saved', 'loading']),
      formTitle () {
        return this.stydy === -1 ? 'Añadir Estudios' : 'Editar Estudios'
      },
      institutionErrors(){
        const errors = []
        if (!this.$v.study.institution.$dirty) return errors        
        !this.$v.study.institution.required && errors.push('Campo requerido!')
        !this.$v.study.institution.minLength && errors.push('Inserte mínimo 3 caractéres')
        !this.$v.study.institution.maxLength && errors.push('Inserte máximo 100 caractéres')
        return errors
      },
      titleErrors(){
        const errors = []
        if (!this.$v.study.title.$dirty) return errors        
        !this.$v.study.title.required && errors.push('Campo requerido!')
        !this.$v.study.title.minLength && errors.push('Inserte mínimo 3 caractéres')
        !this.$v.study.title.maxLength && errors.push('Inserte máximo 100 caractéres')
        return errors
      },
      timeErrors(){
        const errors = []
        if (!this.$v.study.time.$dirty) return errors        
        !this.$v.study.time.required && errors.push('Campo requerido!')
        !this.$v.study.time.minLength && errors.push('Inserte mínimo 3 caractéres')
        !this.$v.study.time.maxLength && errors.push('Inserte máximo 50 caractéres')
        return errors
      }
    },

    created () {      
      this.studyList();            
    },    
    methods: {
      focusComp(){
        setTimeout(() => {          
          this.$refs.inst.focus()  
        }, 300);
      },
      submit(){
        this.$v.$touch();        
        if(!this.$v.$invalid){
          this.storeStudy(this.study);
        }
      },
      ...mapActions(['storeStudy', 'studyList', 'deleteStudy']),
      openModal(){
        this.$store.commit('StudyStore/setDialog', true); 
        this.study = Object.assign({}, {})
        this.focusComp();       
      },
      editItem (item) {        
        this.$store.commit('StudyStore/setDialog', true);
        this.study = Object.assign({}, item);                
      },
      deleteItem (item) {        
        if(confirm('Seguro que desea eliminar este item?')){
          this.deleteStudy(item);
        }
      },

      close () {
        this.$store.commit('StudyStore/setDialog', false);
        setTimeout(() => {
          this.experience = Object.assign({}, {})
        }, 300)
      },
    }
  }
</script>