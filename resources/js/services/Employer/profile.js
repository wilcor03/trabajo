import Axios from 'axios';
import { getHeaders } from '../Auth';

const basepath = '/api/employer/profiles'
export function getProfile(){
    return new Promise((resolve, reject)=>{
        const headers = getHeaders();
        Axios.get(`${basepath}`, headers).then(res => {
            resolve(res.data)
        }).catch(err =>{
            reject(err);
        });
    })
}

export function storeProfile(profile){
    return new Promise((resolve, reject) => {
        const headers = getHeaders();        
        Axios.post(`${basepath}`, profile, headers).then(res => {
            resolve(res.data);
        }).catch(err => {
            reject(err)
        });
    })
}