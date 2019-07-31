import {getProfile, storeProfile} from '../../services/Employer/profile';
const EmployerProfileStore = {
    namespaced:true,
    state:{
        Profile:'',
        loading:false,
        saved:false
    },
    getters:{        
        profileForm: state => {
            if(state.Profile)
            {
                const newProfile = Object.assign({}, state.Profile);
                let ids = [];
                newProfile.sectors.map(item => {
                    ids.push(item.id);
                });
                newProfile.sectors = ids;
                newProfile.city_id = newProfile.city.id;
                newProfile.docType = newProfile.docType.id;
                return newProfile;
            }
            return false;
        }
    },  
    mutations:{
        setProfile(state, payload){            
            state.Profile = payload;
        },
        setLoading(state, payload){
            state.loading = payload;
        },
        setSaved(state, payload){
            state.saved = payload;
        }        
    },
    actions:{
        getProfile({commit, state}){    
            commit('setLoading', true, {root:true});        
            return new Promise((resolve, reject) => {
                if(!state.Profile){
                    getProfile().then(data => {
                        commit('setProfile', data);
                        resolve(data)
                    }).catch(err => {
                        reject(err)
                    })
                } else {                    
                    resolve(state.Profile)
                }
            }).finally(() => {
                commit('setLoading', false, {root:true});
            })
        },
        storeProfile({commit}, payload){
            commit('setLoading', true, {root:true});           
            commit('setLoading', true);
            commit('setSaved', false);
            storeProfile(payload).then(data => {
                commit('setProfile', data)
                commit('setSaved', true);
            }).catch(err => {
                
            }).finally(()=> {
                commit('setLoading', false, {root:true});           
            })
        }   
    }
};

export default EmployerProfileStore;