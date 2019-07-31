<template>
  <div>
    <v-toolbar flat color="white">
      <v-toolbar-title>Mi experiencia laboral</v-toolbar-title>
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
                    ref="company"
                    v-model="experience.company" 
                    label="Empresa donde laboró" 
                    required
                    @input="$v.experience.company.$touch()"
                    @blur="$v.experience.company.$touch()"
                    :error-messages="experienceErrors" 
                    :counter="100"
                  >
                    </v-text-field>
                </v-flex>
                <v-flex xs12 sm6>
                  <v-text-field 
                    v-model="experience.appointment" 
                    label="Cargo desempeñado" 
                    required
                    @input="$v.experience.appointment.$touch()"
                    @blur="$v.experience.appointment.$touch()"
                    :error-messages="appointmentErrors" 
                    :counter="100"
                  ></v-text-field>
                </v-flex>                
                <v-flex xs12 sm6>
                  <v-select v-model="experience.experience_code"                    
                    :items="options"                    
                    label="Cuanto tiempo laboró"
                    required
                    item-text="name"
                    item-value="id"                    
                    persistent-hint
                    return-object
                    single-line                                      
                    
                    @input="$v.experience.experience_code.$touch()"
                    @blur="$v.experience.experience_code.$touch()"
                    :error-messages="experienceCodeErrors"                     
                  ></v-select>
                </v-flex>
              </v-layout>

              <v-layout row wrap>
                  <v-flex xs12>
                  <v-textarea v-model="experience.details"
                      name="input-7-1"
                      label="Más detalles de sus funciones en ésta empresa"
                      required
                      @input="$v.experience.details.$touch()"
                      @blur="$v.experience.details.$touch()"
                      :error-messages="detailsErrors"       
                      :counter="1000"             
                  ></v-textarea>
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
      :items="experiences"
      class="elevation-1"
      rowsPerPageText='Items por página'
      rowsPerPageAll="10"      
    >     

      <template v-slot:items="props"> 
        <td class="text-md-left text-capitalize text-truncate">{{ props.item.company }}</td>
        <td class="text-md-left text-capitalize">{{ props.item.appointment.substr(0,20) }}...</td>
        <td class="text-md-left">{{ props.item.experience_code.name }}</td>
        <td class="text-md-left text-truncate">{{ props.item.details.substr(0, 25) }}...</td>
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
            color="error"
            class="mr-2 mt-3"
            small
            @click="deleteItem(props.item)"
            >
            delete
            </v-icon>
        </td>
      </template>
      <template v-slot:no-data>
      <v-alert :value="true" color="warning" icon="warning">
        Por favor inserte almenos una referencia a su experiencia laboral.
      </v-alert>
    </template>      
    </v-data-table>
  </div>
</template>
<script>
import { validationMixin } from 'vuelidate'
import { required, minLength, maxLength, between } from 'vuelidate/lib/validators';
import { createNamespacedHelpers } from 'vuex';
const { mapActions, mapState } = createNamespacedHelpers('ExperienceStore');
export default {  
    mixins: [validationMixin],
    validations: {
      experience: {        
        company:{required, minLength:minLength(3), maxLength:maxLength(100)},
        appointment:{required, minLength:minLength(3), maxLength:maxLength(100)},
        experience_code:{required},        
        details:{required, minLength:minLength(20), maxLength:maxLength(1000)},
      }
    }, 
    data: () => ({      
      experience:{
        company:'',
        appointment:'',
        experience_code:{id: 1, name:'Menos de un año'},
        details:''
      },      
      headers: [
        {
          text: 'Empresa',
          align: 'left',
          sortable: false,
          value: 'name'
        },                
        { text: 'Cargo', value: 'experience.appointment' },
        { text: 'Tiempo laborado', value: 'experience.experience_code' },
        { text: 'Detalles', value: 'experience.details' }        
      ]      
    }),

    computed: {
      ...mapState(['options', 'experiences', 'saving', 'dialog', 'saved']),
      formTitle () {
        return this.editedIndex === -1 ? 'Añadir Experiencia' : 'Editar Experiencia'
      },
      experienceErrors() {
        const errors = []
        if (!this.$v.experience.company.$dirty) return errors        
        !this.$v.experience.company.required && errors.push('Campo requerido!')
        !this.$v.experience.company.minLength && errors.push('Inserte mínimo 3 caractéres')
        !this.$v.experience.company.maxLength && errors.push('Inserte máximo 100 caractéres')
        return errors
      },
      appointmentErrors() {
        const errors = []
        if (!this.$v.experience.appointment.$dirty) return errors        
        !this.$v.experience.appointment.required && errors.push('Campo requerido!')
        !this.$v.experience.appointment.minLength && errors.push('Inserte mínimo 3 caractéres')
        !this.$v.experience.appointment.maxLength && errors.push('Inserte máximo 100 caractéres')
        return errors
      },
      experienceCodeErrors(){
        const errors = []
        if (!this.$v.experience.experience_code.$dirty) return errors        
        !this.$v.experience.experience_code.required && errors.push('Campo requerido!')
        //!this.$v.experience.experience_code.between && errors.push('Error en la selección')        
        return errors
      },
      detailsErrors(){
        const errors = []
        if (!this.$v.experience.details.$dirty) return errors        
        !this.$v.experience.details.required && errors.push('Campo requerido!')
        !this.$v.experience.details.minLength && errors.push('Inserte mínimo 20 caractéres')
        !this.$v.experience.details.maxLength && errors.push('Inserte máximo 1000 caractéres')
        return errors
      }
    },

    created () {      
      this.experienceList();      
      this.experienceOptions();
    },    
    methods: {
      focusComp(){
        setTimeout(() => {          
          this.$refs.company.focus()  
        }, 300);
      },  
      submit(){
        this.$v.$touch();        
        if(!this.$v.$invalid){
          this.storeExperience(this.experience);
        }
      },
      ...mapActions(['storeExperience', 'experienceOptions', 'experienceList', 'deleteExperience']),
      openModal(){
        this.$store.commit('ExperienceStore/setDialog', true); 
        this.experience = Object.assign({}, {})    
        this.focusComp();   
      },
      editItem (item) {        
        this.$store.commit('ExperienceStore/setDialog', true);
        this.experience = Object.assign({}, item);                
      },
      deleteItem (item) {        
        if(confirm('Seguro que desea eliminar este item?')){
          this.deleteExperience(item);
        }
      },

      close () {
        this.$store.commit('ExperienceStore/setDialog', false);
        setTimeout(() => {
          this.experience = Object.assign({}, {})
        }, 300)
      },
    }      
  }
</script>