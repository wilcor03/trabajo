import Axios from "axios";
import { getHeaders } from './Auth';
const basepath = 'https://empleo.dev/api/employee/experience';


export function storeExperience(experience)
{
    return new Promise((resolve, reject) => {
        const headers = getHeaders();
        Axios.post(`${basepath}`, experience, headers).then(res => {
            resolve(res.data)
        }).catch(err => {
            reject(err)
        })
    })
}

export function experienceOptions()
{
    return new Promise((resolve, reject) => {
        const headers = getHeaders();
        Axios.get(`${basepath}/options`, headers).then(res => {
            resolve(res.data)
        }).catch(err => {
            reject(err)
        })
    })
}

export function experienceList(){
    return new Promise((resolve, reject) => {
        const headers = getHeaders();
        Axios.get(`${basepath}`, headers).then(res => {
            resolve(res.data)
        }).catch(err => {
            reject(err)
        })
    })
}

export function deleteExperience(experience){
    return new Promise((resolve, reject) => {
        const headers = getHeaders();
        Axios.delete(`${basepath}/${experience.id}`, headers).then(res => {
            if(res.data){                
                resolve(true)
            } else {
                resolve(true)
            } 
        }).catch(err => {
            reject(err)
        });
    })
}