import { storeStudy, studyList, deleteStudy } from '../services/study'
const StudyStore = {
    namespaced:true,
    state:{        
        studies:[],               
        saving: false,
        dialog: false,
        saved:  false,
        loading: false
    },
    mutations:{                
        setStudies(state, payload){            
            state.studies = payload;
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
        storeStudy({commit, state}, payload){            
            commit('setSaving', true)                        
            commit('setLoading', true);
            storeStudy(payload).then(data => {     
                let pos = state.studies.findIndex(el => {
                    return el.id === data.id
                });           

                if(pos !== -1)
                {   
                    Object.assign(state.studies[pos], data)                    
                } else {                        
                    state.studies.push(data);
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
        studyList({commit, state})
        {            
            if(!state.studies.length){
                commit('setLoading', true);
                studyList().then(data => {
                    commit('setStudies', data)
                }).catch(err => {
                    alert('ha ocurrido un error!')
                }).finally(() => {
                    commit('setLoading', false);
                })
            }            
        },
        deleteStudy({commit, state}, payload){
            commit('setSaving', true)
            commit('setLoading', true);
            deleteStudy(payload).then(success => {
                if(success){
                    const pos = state.studies.findIndex(el =>{
                        return el.id === payload.id
                    })
                    commit('setSaving', false)
                    state.studies.splice(pos, 1)
                }
            }).finally(() => {
                commit('setLoading', false);
            })
        }
    }
};

export default StudyStore;