import ProfileStore from './ProfileStore';
import GeneralStore from './GeneralStore';
import ExperienceStore from './ExperienceStore';
import StudyStore from './StudyStore';
import CategoryStore from './CategoryStore';
//GLOBALS
import SettingsStore from './SettingsStore';


//EMPLOYER
import EmployerProfileStore from './Employer/EmployerProfileStore';
import EmployerOfferStore from './Employer/EmployerOfferStore';

//AUTH
import AuthStore from './AuthStore';

import { getHeaders } from '../services/Auth'

const headers = getHeaders();

const GlobalStore = {    
    namespaced: true,
    state:{
        globalLoading:false,
        access_token:'',
        headers:headers       
    },    
    getters:{
        accessToken(state){
            return state.access_token;
        },
        headers(state){
            console.log('desde global')
            return headers;
        }
    },
    mutations:{
        setLoading(state, payload){
            state.globalLoading = payload;
        },
        setAccessToken(state, payload){                        
            state.access_token = payload;
        }, 
        headers(state, payload){
            
        }
    },    
    modules: {AuthStore, ProfileStore, GeneralStore, ExperienceStore, StudyStore, CategoryStore, SettingsStore, EmployerProfileStore, EmployerOfferStore}
}

export default GlobalStore;