import { storeProfile, getProfile, getUserData } from '../services/profile'

const ProfileStore = {
    namespaced: true,
    state:{
        loading:false,
        saving: false,
        Profile:'',
        editingMode:false,
        user: ''
    },    
    getters:{
        isProfileComplete(state){
            let profile = Object.assign({}, state.Profile);            
            return profile.celPhone != "" && profile.birthDay != "" && profile.city != ""
        }, 
        profileGet(state){
            return state.Profile;
        }
    },
    mutations:{
        setProfile(state, payload)
        { 
            let theBirthDate = new Date().toISOString().substr(0, 10);            
            if(payload.birthDay != ''){                
                theBirthDate = payload.birthDay;
            }                        console.log('aja')
            
            state.Profile = {
                'name': payload.name,   
                'email':payload.email,  
                'celPhone': payload.celPhone,
                'birthDay': theBirthDate,
                'description': payload.description,
                'city_id': payload.city.id || [],
                'city': payload.city                
            };                        
        },
        setLoading(state, payload)
        {
            state.loading = payload;
        },
        setSaving(state, payload)
        {
            state.saving = payload;
        }, 
        setEditingMode(state, payload)
        {
            state.editingMode = payload;
        }
    },     
    actions:{
        getProfile({state, commit}){                                                
            return new Promise ((resolve, reject) => {                
                /*if(!state.Profile) 
                {*/                    
                    commit('setLoading', true)
                    
                    getProfile().then(data => {                        
                        commit('setProfile',data);
                        commit('setLoading', false);                        
                        resolve(data)
                    }).catch(err => {
                        reject(err) 
                    })               
                /*}
                else
                {
                    resolve(state.Profile)
                }*/
            }).finally(() => {
                commit('setLoading', false);
            })
        },        
        saveProfile({commit}, payload){
            commit('setSaving', true);
            return new Promise ((resolve, reject) => {
                storeProfile(payload).then(data => {                                
                    commit('setSaving', false);
                    commit('setProfile',data);
                    commit('setEditingMode', false);                    
                    resolve(data)
                }).catch((err) => {
                    alert('ha ocurrido un error!!')                    
                    commit('setSaving', false);                    
                });
            });
        },
        getUserData(){
            getUserData().then(data => console.log(data))
        }

    }    
}

export default ProfileStore;