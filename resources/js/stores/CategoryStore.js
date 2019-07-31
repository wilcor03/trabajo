import { list, attach, myCategories } from '../services/category';
const CategoryStore = {
    namespaced:true,
    state:{
        categories: [],
        loading:false
    },
    getters:{
        selectedCats(state){                                
            return state.categories.filter(item => {
                return item.selected
            }).map(item => {
                return item.id
            })            
        }
    },
    mutations:{
        setCategories(state, payload){
            state.categories = payload;
        },
        setLoading(state, payload){
            state.loading = payload
        }     
    },
    actions:{
        list({commit}){
            commit('setLoading', true);
            list().then(data => {
                commit('setCategories', data)
            }).finally(() => {
                commit('setLoading', false);
            })
        },
        attach({commit, state}, payload){
            commit('setLoading', true)
            return new Promise((resolve, reject) => {
                attach(payload).then(data => {                    
                    if(data){
                        resolve(true)
                    }
                    const pos = state.categories.findIndex(el => {
                        return el.id === payload.id
                    });                    
    
                    if(pos > -1){                        
                        Object.assign(state.categories[pos], payload, {selected:data});
                    }  
                    commit('setLoading', false)                     
                })
            }).catch(err => {
                alert('Ha ocurrido un error!!')
                reject(false)
                commit('setLoading', false)
            })                        
        },
        myCategories(){
            myCategories().then(data => {
                console.log(data)
            })
        }
    }
}
export default CategoryStore;