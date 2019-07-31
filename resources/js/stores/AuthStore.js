import { getToken, register, getLocalUser, updateProfileTypeField } from '../services/Auth'

//const user = getLocalUser();

const AuthStore = {
  namespaced:true,
  state:{
    currentUser:null,
    isLoggedIn: false,
    socialIsConnected:false,//when the user logged with social_red
    facebookIsConnected:false,
    facebookObj:{}
  },
  getters:{
    currentUser(state){
      return state.currentUser;
    }
  },
  mutations:{
    setCurrentUser(state, payload){
      state.currentUser = payload;
    },
    setSocialIsConnected(state, payload){
      state.socialIsConnected = payload;
    },
    setFacebookIsConnected(state, payload){
      state.facebookIsConnected = payload;
    },
    setFacebookObj(state, payload){
      state.facebookObj = payload.FB;
    }
  },
  actions:{            
    async register({commit}, payload){      
      return new Promise((resolve, reject) => {
        register(payload).then(res => {        
          getToken(payload).then(localUser => resolve(localUser))
        }).catch(err => {
          reject(err)
        });
      })              
    },
    login({commit}, payload){//the credentiasl      
      return new Promise((resolve, reject) => {               
        getToken(payload).then(localUser => {
          commit('setCurrentUser', localUser);
          resolve(localUser);          
        }).catch(err => {          
          reject(err);
        })
      })
    },
    logout({state}){
      state.currentUser = null;
      localStorage.removeItem('local_user');
    },
    getLinkPassword({commit}, email){      
      return new Promise((resolve, reject) => {
        axios.post('/api/password/create', { email }).then(res => {                
            resolve(res);
        });
      })      
    },
    //// FACEBOOK    
    getFacebookData({state, commit}){
      return new Promise((resolve, reject) => {
        state.facebookObj.api('/me', 'GET', { fields: 'id,name,email' },        
          userInformation => { 
          if(userInformation.error){
            reject(userInformation.error)
            return
          }          

          this.personalID = userInformation.id;
          this.email = userInformation.email;
          this.name = userInformation.name;

          const data = {
            name:userInformation.name,
            email:userInformation.email,
            password: Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15),
            social_red:1
          };
          commit('setFacebookIsConnected', true);
          resolve(data)                                        
        })
      })
      
    },

    updateProfileTypeField(contex, newProfileType){
      return new Promise((resolve, reject) => {
        updateProfileTypeField(newProfileType).then(res => {
          resolve(res)
        });
      })
    },
    getCurrentUser({commit, state}){ 
      return new Promise((resolve, reject) => {
        if(state.currentUser != null){
          resolve(state.currentUser)
        } else {
          getLocalUser().then(user => { 
            commit('setCurrentUser', user);
            resolve(user);                    
          });
        }         
      });      
    }

  }  
};
export default AuthStore;