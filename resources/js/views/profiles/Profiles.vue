<template>
<div id="profiles">  
  <template v-if="Profile">     
    <template v-if="Profile && !editingMode && isProfileComplete">
      <profile-view/>            
    </template>
    <template v-else>
      <profile-edit/>
    </template>    
  </template>    
</div>
  
</template>
<script>
import { createNamespacedHelpers } from 'vuex';
const { mapState, mapActions, mapGetters } = createNamespacedHelpers('ProfileStore');

import ProfileView from './ProfileView'
import ProfileEdit from './ProfileEdit'

export default {
  components:{
    'profile-view': ProfileView,
    'profile-edit': ProfileEdit    
  },
  computed:{
    ...mapState(['Profile', 'editingMode']),
    ...mapGetters(['isProfileComplete'])
  },
  methods:{
    ...mapActions(['getProfile'])    
  },
  created(){
    this.getProfile();
  }
}
</script>