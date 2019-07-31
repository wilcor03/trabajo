import Axios from "axios";

export function register(data){    
    localStorage.removeItem('access_token');
    return new Promise((resolve, reject) =>{
        Axios.post(`/register`, data).then(res => {
            resolve(res)
        }).catch(err => {
            reject(err)
        });
    })
}

export function getToken(user = null){        
    return new Promise((resolve, reject) => {
        const localUser = localStorage.getItem('local_user');        
        if(localUser){            
            resolve(localUser);
        } else {
            const credentials = 
            {
                grant_type: 'password',            
                client_id:2,
                client_secret:'BFRujvtVCttROxvJqjfyczjtHfNQxxhrkMPlPNrV',
                username: user.email,
                password: user.password
            };

            Axios.post('/oauth/token', credentials).then(res => {                
                const access_token = res.data.access_token;                
                let headers = {headers:{'Authorization': 'Bearer '+ access_token, 'Content-Type': 'application/json'}};                            
                Axios.post('/api/user/current-user', {}, headers).then(res => {                                        
                    let currentUser = res.data;
                    currentUser.access_token = access_token;                                        
                    const userMap = JSON.stringify(currentUser);
                    localStorage.setItem('local_user', userMap);                    
                    resolve(currentUser);
                });                               
            }).catch(err => {
                reject(err)
            });
        }       
    })
}

export function getLocalUser(){ 
    return new Promise((resolve, reject) => { 
        const user = localStorage.getItem('local_user');                
        if(user){
            const localUser = JSON.parse(user);
            resolve(localUser);
        } 
        resolve(null);

        /*const user = localStorage.getItem('local_user');        
        if(!user){
            return null;               
        }   
        return JSON.parse(user);*/
    })  
    
}

export function getHeaders(){
    const localUser = localStorage.getItem('local_user');
    if(localUser){
        const mapUser   = JSON.parse(localUser);
        let access_token = mapUser.access_token;            
        let headers = {headers:{'Authorization': 'Bearer '+ access_token, 'Content-Type': 'application/json'}};
        return headers;
    }
    return null;    
}

export function updateProfileTypeField(newProfileType){
    return new Promise((resolve, reject) => {
        const headers = getHeaders();
        axios.post('/api/user/update-profile-type-field', {profileType:newProfileType}, headers).then(res => {
            resolve(res)
        });
    })
}