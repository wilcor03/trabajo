export default {
  methods:{
    sdkLoaded(payload) {        
        this.$store.commit('AuthStore/setFacebookObj', payload);
        if(payload.isConnected){
          this.$store.commit('AuthStore/setFacebookIsConnected', true);        
        }
      },
    loginWithButtonFacebook(){
        this.loading = true;
        if(this.facebookIsConnected){                
          this.getFacebookData().then(data => {
            this.sendingData(data);
          })
        }
      },
      onLogin() {
        if(!this.facebookIsConnected){                
          this.getFacebookData().then(data => {
            this.sendingData(data);
          });
        }      
      },
      onLogout() {      
        this.$store.commit('AuthStore/setFacebookIsConnected', false);
      },
      sendingData(data){
        this.register(data).then(localUser => {          
          if(localUser){          
            if(localUser.profileType == 2){
              this.$router.push({name:'employer.dashboard'});
            } else if(localUser.profileType == 3){
              this.$router.push({name:'gen.info'});
            } else if(localUser.profileType == null){
              this.$router.push({name:'auth.preregister-a-auth'});
            }            
          }
        }).catch(err => {
          alert('Ha ocurrido un error!')
        }).finally(() => {
          this.loading = false;
        });
      }
  }
}