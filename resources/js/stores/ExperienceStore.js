import { storeExperience, experienceOptions, experienceList, deleteExperience } from '../services/experience'
const ExperienceStore = {
    namespaced:true,
    state:{        
        experiences:[],
        options:[],        
        saving: false,
        dialog: false,
        saved:  false,
        loading:false,
    },
    mutations:{        
        setOptions(state, payload){
            state.options = payload;
        },
        setExperiences(state, payload){            
            state.experiences = payload;
        },        
        setSaving(state, payload){
            state.saving = payload
        },
        setSaved(state, payload){
            state.saved = payload
        },
        setDialog(state, payload){
            state.dialog = payload
        },
        setLoading(state, payload){
            state.loading = payload;
        }
    },
    actions:{
        storeExperience({commit, state}, payload){            
            
            commit('setSaving', true)
            commit('setLoading', true);
            
            const data = {
                id: payload.id,
                company:payload.company,
                appointment:payload.appointment,
                experience_code: payload.experience_code.id,
                details:payload.details
            }

            storeExperience(data).then(data => {     
                let pos = state.experiences.findIndex(el => {
                    return el.id === data.id
                });           

                if(pos !== -1)
                {   
                    Object.assign(state.experiences[pos], data)                    
                } else {                        
                    state.experiences.push(data);
                }         
                commit('setSaving', false)
                commit('setSaved', true)
                setTimeout(() => {
                    commit('setDialog', false)
                    commit('setSaved', false)
                }, 1300)                

            }).catch(err => {
                alert('ha ocurrido un error!')
                commit('setDialog', false)
            }).finally(() => {
                commit('setLoading', false);
            })
        },
        experienceOptions({commit, state}){            
            if(!state.options.length){
                experienceOptions().then(data => {
                    commit('setOptions', data);
                }).catch(err => {
                    alert('ha ocurrido un error!')
                });
            }
        }, 
        experienceList({commit, state})
        {
            if(!state.experiences.length){
                commit('setLoading', true);
                experienceList().then(data => {
                    commit('setExperiences', data)
                }).catch(err => {
                    alert('ha ocurrido un error!')
                }).finally(() => {
                    commit('setLoading', false);
                })
            }
        },
        deleteExperience({commit, state}, payload){
            commit('setSaving', true)
            commit('setLoading', false);
            deleteExperience(payload).then(success => {
                if(success){
                    const pos = state.experiences.findIndex(el =>{
                        return el.id === payload.id
                    })
                    commit('setSaving', false)
                    state.experiences.splice(pos, 1)
                }
            }).finally(() => {
                commit('setLoading', false);
            })
        }
    }
};

export default ExperienceStore;