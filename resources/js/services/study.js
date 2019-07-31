import Axios from "axios";
import { getHeaders } from './Auth';
const basepath = '/api/employee/studies'

export function storeStudy(study)
{
    return new Promise((resolve, reject) => {
        const headers = getHeaders();
        Axios.post(`${basepath}`, study, headers).then(res => {
            resolve(res.data)
        }).catch(err => {
            reject(err)
        })
    })
}

export function studyList(){
    return new Promise((resolve, reject) => {
        const headers = getHeaders();
        Axios.get(`${basepath}`, headers).then(res => {
            resolve(res.data)
        }).catch(err => {
            reject(err)
        })
    })
}

export function deleteStudy(study){
    return new Promise((resolve, reject) => {
        const headers = getHeaders();
        Axios.delete(`${basepath}/${study.id}`, headers).then(res => {
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