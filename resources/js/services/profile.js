import Axios from "axios";
import { getHeaders } from './Auth';
const basepath = 'https://empleo.dev/api/employee';

export function getProfile()
{
    return new Promise((resolver, reject) => {
        const headers = getHeaders();
        Axios.get(`${basepath}/profiles/my-profile`, headers).then(res => {
            resolver(res.data)
        }).catch(err => {
            reject(err)
        });
    });
}

export function storeProfile(profile)
{
    return new Promise((resolver, reject) => {  
        const headers = getHeaders();      
        Axios.post(`${basepath}/profiles`, profile, headers).then(res => {                
            resolver(res.data)                    
        }).catch(err => {
            reject(err)
        })
    })
}

export function getUserData(){
    return new Promise((resolve, reject) => {
        const headers = getHeaders();
        Axios.get(`${basepath}/user-data`, headers).then(res => {
            resolve(res.data)
        })
    })
}