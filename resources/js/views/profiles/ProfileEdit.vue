<template>
    <div id="profile-edit">
        <div v-if="Profile">
            <form-edit/>            
        </div>        
    </div>
</template>
<script>
import FormProfile from '../../components/user/FormProfile.vue';
import { createNamespacedHelpers } from 'vuex';
const { mapState, mapActions, mapGetters } = createNamespacedHelpers('ProfileStore');
export default {
    name:'profile-edit',    
    components:{
        'form-edit': FormProfile
    },            
    computed:{
        ...mapState(['Profile'])        
    }     
}
</script>