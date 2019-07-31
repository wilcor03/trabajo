const GeneralStore = {
    namespaced: true,
    state:{
        selectedStep:1
    },
    mutations:{
        setSelectedStep(state, payload){
            state.selectedStep = payload
        }
    }
}
export default GeneralStore;
