import { storeOffer, attachCitiesAndDeps, attachCategory, list, show, edit, destroy } from '../../services/Employer/offer';
const EmployerOfferStore = {
    namespaced:true,
    state:{
        saved:false,
        Offer:'',
        step:1,
        totalSteps:3,
        submittingForm:false,
        offers:[],
        data:'',
        loading:false
    },    
    getters:{        
        contracts(){
            return [
                {id: 1, text: 'Indefinido' },
                {id: 2, text: 'Término fijo' },
                {id: 3, text: 'Por horas' },
                {id: 4, text: 'Obra labor' }          
              ];
        },
        visibleOpts(state){
            return [{id:1, text:'Público'}, {id: 0, text: 'Privado'}];
        }  
    },
    mutations:{
        setOffer(state, payload){
            state.Offer = payload;
        },
        setStep(state, payload){ 
            if(payload == 'back'){ 
                if(state.step > 1){
                    state.step--;
                }
            } else if(payload == 'next') { 
                if(state.step < state.totalSteps){
                    state.step++
                }
            } else { 
                state.step = payload;
            }           
        },
        setSubmttingForm(state, payload){
            state.submittingForm = payload;
        },
        setSaved(state, payload){
            state.saved = payload;
        },
        setOffers(state, offers){
            state.offers = offers;
        },
        setLoading(state, payload){
            state.loading = payload;
        },
        setData(state, data){            
            
            const offers = data.data;
            if(offers && offers.length){
                let offrs = offers.map(item => {
                    const ob = item;                
                    let  isComplete = false;
    
                    if(item.coverage == 2 && (item.categories && item.categories.length)
                        && ((item.cities && item.cities.length) || 
                        (item.departaments && item.departaments.length))
                    ){
                        isComplete = true;
                    } else if (item.coverage == 1 && (item.categories && item.categories.length)){                    
                        isComplete = true;
                    }
                    ob.isComplete = isComplete;                
                    return ob;
                })   
                
                data.data = offrs;
                state.data = data;
                
            } else {
                state.data = data;                       
            }            
        }
    },
    actions:{
        storeOffer({commit, state}, payload){
            commit('setLoading', true, {root:true});
            if(state.Offer.id != undefined){                
                payload.id = state.Offer.id;
            }
            storeOffer(payload).then(data => {
                if(data.id !=undefined){                   
                    commit('setOffer', data);
                    commit('setStep', 'next');                    
                }  
            }).finally(() => {
                commit('setSubmttingForm', false);
                commit('setLoading', false, {root:true});
            })
        },
        attachCitiesAndDeps({commit}, payload){             
            commit('setLoading', true, {root:true});           
            attachCitiesAndDeps(payload).then(data => {
                if(data){
                    commit('setStep', 'next');
                }
            }).finally(() => {
                commit('setSubmttingForm', false);
                commit('setLoading', false, {root:true});
            })
        },        
        attachCategory({commit}, payload){            
            commit('setLoading', true, {root:true});
            attachCategory(payload).then(data => {
                if(data == true){                    
                    commit('setSaved', true);                    
                }
            }).catch(err => {
                alert('Ha ocurrido un error!!')
            }).finally(() => {                
                commit('setSaved', false);
                commit('setLoading', false, {root:true});
            })
        },
        list({commit}, payload = null){             
            commit('setLoading', true, {root:true})
            //commit('setLoading', true); //rootState.globalLoading = true;
            list(payload).then(data => { //payload is the url                 
                commit('setOffers', data.data);                   
                commit('setData', data);                     
            }).catch(err => {
                alert('Ha ocurrido un error!!');
            }).finally(() => {
                //commit('setLoading', false)
                commit('setLoading', false, {root:true})
            })
        },
        showOffer({commit}, payload){ //payload is the ID
            return new Promise((resolve, reject) => {
                commit('setLoading', true, {root:true});
                show(payload).then(data => {
                    commit('setOffer', data)
                    resolve(data)
                }).catch(err => {
                    alert('Ha ocurrido un error!!');
                }).finally(() => {
                    commit('setLoading', false, {root:true});
                })
            })            
        },
        editOffer({commit}, payload){ //payload is the ID
            return new Promise((resolve, reject) => {
                commit('setLoading', true, {root:true});
                edit(payload).then(data => {
                    commit('setOffer', data);
                    resolve(data)
                }).catch(err => {
                    alert('Ha ocurrido un error!!');
                }).finally(() => {
                    commit('setLoading', false, {root:true});
                })
            })            
        },  
        deleteOffer({commit, state}, id){
            commit('setLoading', true, {root:true});
            destroy(id).then(res => {                
                if(res.success == true){ console.log('offers in delete', state.data)
                    const data = state.data.data;
                    const pos = data.findIndex(item => {
                        return item.id == id;
                    });
                    
                    if(pos != -1){                                            
                        data.splice(pos, 1);
                    }
                }                
            }).finally(() => {
                commit('setLoading', false, {root:true});
            });
        }   
    }
};

export default EmployerOfferStore;