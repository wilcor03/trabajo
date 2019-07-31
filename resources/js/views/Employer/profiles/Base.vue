<template>
    <div id="profiles">
        <router-view></router-view>
    </div>
</template>
<script>
import { mapActions } from 'vuex';
import {getProfile} from '../../../services/Employer/profile';
export default {
    /*beforeRouteEnter(to, from, next){    
        getProfile().then(data => {
            if(data){
                if(to.name == 'employer.profile.add'){
                    next({name:'employer.profile'});
                } else {
                    next(vm => {
                        vm.$store.commit('EmployerProfileStore/setProfile', data);
                    })
                }
            }            
        }).catch(err => {
            next({name:'employer.profile.add'});
        })
        next()
        next()
    }*/
}
</script>