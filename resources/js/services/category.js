import Axios from 'axios';
const basepath = '/api/employee/categories';
import { getHeaders } from './Auth';

export function list(){
    return new Promise((resolve, reject)=>{
        const headers = getHeaders();
        Axios.get(`${basepath}`, headers).then(res => {
            resolve(res.data)
        }).catch(err =>{
            reject(err)
        });
    })
}

export function attach(payload){//employee
    return new Promise((resolve, reject)=>{
        const headers = getHeaders();
        Axios.post(`${basepath}/attach`, payload, headers).then(res => {
            resolve(res.data)
        }).catch(err => {
            reject(err)
        });
    })
}

export function myCategories(){
    return new Promise((resolve, reject) => {
        const headers = getHeaders();
        Axios.post(`${basepath}/my-categories`, {}, headers).then(res => {
            resolve(res.data)
        }).catch(err => {
            reject(err)
        })
    })
}