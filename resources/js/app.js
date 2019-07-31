require('./bootstrap');
import Vue from 'vue';
import Vuerouter from 'vue-router';
import Vuex from 'vuex';
import MainApp from './components/MainApp';
import Vuetify from 'vuetify'
import Vuelidate from 'vuelidate';
/*import ProfileStore from './stores/ProfileStore';
import GeneralStore from './stores/GeneralStore';
import ExperienceStore from './stores/ExperienceStore';
import StudyStore from './stores/StudyStore';
import CategoryStore from './stores/CategoryStore';*/
//GLOBALS
/*import SettingsStore from './stores/SettingsStore';*/
import GlobalStore from './stores/GlobalStore';


//EMPLOYER
/*import EmployerProfileStore from './stores/Employer/EmployerProfileStore';
import EmployerOfferStore from './stores/Employer/EmployerOfferStore';*/


Vue.use(Vuerouter);
Vue.use(Vuex);
Vue.use(Vuetify,{iconfont: 'mdi'});
Vue.use(Vuelidate);

const store = new Vuex.Store(GlobalStore);

import {routes} from './routes';

const router = new Vuerouter({
    routes:routes,
    mode: 'history'
});

router.beforeEach((to, from , next) => {
    store.dispatch('AuthStore/getCurrentUser').then(currentUser => {        
        const requiresAuth = to.matched.some(record => record.meta.requiresAuth);                
        if(currentUser && currentUser.profileType === null){
            if(to.name != 'auth.preregister-a-auth'){
                next({name:'auth.preregister-a-auth'})
            }        
        }

        if(requiresAuth && !currentUser){
            next({name:'auth.login'})
        } else if((to.path == '/app/auth/login' || to.name == 'auth.register') && currentUser){                
            if(currentUser.profileType == 2){
                next('/app/employer');
            } else if(currentUser.profileType == 3){
                next('/app/employee');
            } else if(currentUser.profileType == null){ 
                next({name:'auth.preregister-a-auth'});
            }        
        } else {
            next();
        }    
    });    
    
});

router.beforeEach((to, from, next) => {    
    //EMPLOYER    

    const requiresProfileEmployer = to.matched.some(record => record.meta.requiresProfileEmployer)          
    if(requiresProfileEmployer)
    {       
        store.dispatch('EmployerProfileStore/getProfile').then(data => {            
            
            if(data)
            {
                if(to.name == 'employer.profile.add'){
                    next({name:'employer.profile'})      
                } else {
                    next()
                }                   
            } else {                
                if(to.name == 'employer.profile.edit'){                    
                    next({name:'employer.profile.add'})      
                } else if(to.name == 'employer.profile'){   
                                     
                    next({name:'employer.profile.add'})
                }                 
                next()                               
            }
        })
    } else {
        next()
    }

    //EMPLOYEE
    const requiresProfile = to.matched.some(record => record.meta.requiresProfile)          
    if(requiresProfile)
    {           
        store.dispatch('ProfileStore/getProfile').then(data => {
            if(data)
            {
                if(to.name == 'profile.create'){
                    next({name:'profile.show'})      
                } else {
                    next()
                }                   
            }else
            {
                if(to.name == 'profile.edit'){
                    next({name:'profile.create'})      
                } else {
                    next()
                }
                
            }

        })
    } else {
        next()
    }

})


//window.Vue = require('vue');

const app = new Vue({
    components:{MainApp},
    store,
    router,
    el: '#app-emp'
});
