<template>
    <div id="view-profile" v-if="Profile">
        <v-layout row>
            <v-flex xs12 sm6 offset-sm3>
            <v-card>
                <v-toolbar color="light-blue" dark>
                <v-toolbar-side-icon>
                    <v-icon>person</v-icon>                    
                </v-toolbar-side-icon>

                <v-toolbar-title>Información general</v-toolbar-title>

                <v-spacer></v-spacer>               

                <v-btn icon>
                    <v-icon @click="setEditingMode">edit</v-icon>                    
                </v-btn>
                </v-toolbar>

                <v-list two-line subheader>

                <v-list-tile>
                    <v-list-tile-avatar>
                    <v-icon class="purple white--text">mdi-account-arrow-right</v-icon>
                    </v-list-tile-avatar>

                    <v-list-tile-content>
                        <v-list-tile-title>Nombre:</v-list-tile-title>
                        <v-list-tile-sub-title>{{ Profile.name }}</v-list-tile-sub-title>
                    </v-list-tile-content>                    
                </v-list-tile>

                <v-divider inset></v-divider>

                <v-list-tile>
                    <v-list-tile-avatar>
                    <v-icon class="blue white--text">email</v-icon>
                    </v-list-tile-avatar>

                    <v-list-tile-content>
                    <v-list-tile-title>Email:</v-list-tile-title>
                    <v-list-tile-sub-title>{{ Profile.email }}</v-list-tile-sub-title>
                    </v-list-tile-content>
                </v-list-tile>

                <v-divider inset></v-divider>

                <v-list-tile>
                    <v-list-tile-avatar>
                    <v-icon class="blue white--text">phone</v-icon>
                    </v-list-tile-avatar>

                    <v-list-tile-content>
                    <v-list-tile-title>Teléfono(s):</v-list-tile-title>
                    <v-list-tile-sub-title>{{ Profile.celPhone }}</v-list-tile-sub-title>
                    </v-list-tile-content>
                </v-list-tile>

                <v-divider inset></v-divider>

                <v-list-tile>
                    <v-list-tile-avatar>
                    <v-icon class="blue white--text">mdi-calendar-range</v-icon>
                    </v-list-tile-avatar>

                    <v-list-tile-content>
                    <v-list-tile-title>Fecha nacimiento:</v-list-tile-title>
                    <v-list-tile-sub-title>{{ Profile.birthDay }}</v-list-tile-sub-title>
                    </v-list-tile-content>
                </v-list-tile>
                
                <v-divider inset></v-divider>

                <v-list-tile>
                    <v-list-tile-avatar>
                    <v-icon class="warning white--text">mdi-map-marker</v-icon>
                    </v-list-tile-avatar>

                    <v-list-tile-content>
                    <v-list-tile-title>Ciudad y departamento:</v-list-tile-title>
                    <v-list-tile-sub-title>{{ Profile.city.name }} <b>({{ Profile.city.departament.name }})</b></v-list-tile-sub-title>
                    </v-list-tile-content>
                </v-list-tile>

                <v-divider inset></v-divider>

                <v-list-tile>
                    <v-list-tile-avatar>
                    <v-icon class="blue white--text">mdi-card-text</v-icon>
                    </v-list-tile-avatar>

                    <v-list-tile-content>
                    <v-list-tile-title>Descripción:</v-list-tile-title>
                    <v-list-tile-sub-title>{{ Profile.description }}</v-list-tile-sub-title>
                    </v-list-tile-content>
                </v-list-tile>

                </v-list>
            </v-card>
            </v-flex>
        </v-layout>
        
    </div>
</template>
<script>
import { createNamespacedHelpers } from 'vuex';
const { mapState, mapActions } = createNamespacedHelpers('ProfileStore');

export default {           
    methods:{
        ...mapActions(['getProfile']),
        setEditingMode(){
            this.$store.commit('ProfileStore/setEditingMode', true);
        }        
    },
    computed:{
        ...mapState(['Profile', 'loading'])        
    },
    created(){ 
        this.getProfile();
    }
}
</script>
