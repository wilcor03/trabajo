import { getDocTypes, getCitiesWithDeps, citiesAndDeps, getSectors } from '../services/settings'

const SettingsStore = {
    namespaced:true,
    state:{
        docTypes:[],
        cities:[],
        sectorList:[],
        citiesAndDeps:[],
        loading:false
    },
    getters:{
        citiesAndDepsOpts(state){
            return state.citiesAndDeps.map(item => {
                const uniqId = item.type+item.id;
                let newName = {};
                if(item.type == 'city'){
                    newName = item.name + ' (Ciudad)';
                }else{
                    newName = item.name + ' (Departamento)';
                }                
                return Object.assign(item, {uniqId}, {name:newName})
            });
        }
    },
    mutations:{
        setCitiesWithDeps(state, payload){
            state.cities = payload;
        },
        setDocTypes(state, payload){
            state.docTypes = payload;
        },
        setSectors(state, payload){
            state.sectorList = payload;
        },
        setCitiesAndDeps(state, payload){
            state.citiesAndDeps = payload;
        }
    },
    actions:{
        getDocTypes({commit, state}){
            if(state.docTypes[0] == undefined)
            getDocTypes().then(data =>{                
                commit('setDocTypes', data);
            })
        },
        getCitiesWithDeps({commit, state}){
            if(state.cities[0] == undefined)
            getCitiesWithDeps().then(data => {
                commit('setCitiesWithDeps', data);
            }).catch(err => {
                
            });
        },
        getCitiesAndDeps({commit, state}){
            if(state.citiesAndDeps[0] == undefined)
            citiesAndDeps().then(data => {
                commit('setCitiesAndDeps', data);
            })
        },
        getSectors({commit, state}){
            if(state.sectorList[0] == undefined)
            getSectors().then(data => {
                commit('setSectors', data);
            });
        }
    }
}

export default SettingsStore;