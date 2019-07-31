import Axios from "axios";
const basepath = 'https://empleo.dev/api/employee';

export default {
    state:{
        loading:false,
        saving: false,
        Profile:''
    },
    getters:{        
    },
    mutations:{
        setProfile(state, payload)
        {   
            state.Profile = payload;
        },
        setLoading(state, payload)
        {
            state.loading = payload;
        },
        setSaving(state, payload)
        {
            state.saving = payload;
        }
    },    
    actions:{
        getProfile({commit}){
            commit('setLoading', true) 
            setTimeout(() => {
                Axios.get(`${basepath}/profiles/my-profile`).then(res => {
                    commit('setProfile',res.data);
                    commit('setLoading', false);
                });
            }, 200);      
            
        },        
        storeProfile({commit}, payload){
            commit('setSaving', true);
            Axios.post(`${basepath}/profiles`, payload).then(res => {
                setTimeout(() => {
                    commit('setSaving', false);
                }, 300);                
            });
        }

    }    
}