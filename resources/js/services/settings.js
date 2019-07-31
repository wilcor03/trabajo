import Axios from "axios";
import { getHeaders } from './Auth';

const basepath = '/api/settings'
export function getDocTypes(){  
    return new Promise((resolve, reject) => {
        const headers = getHeaders();
        fetch(`${basepath}/doc-types`, headers)
        .then(res => res.json())
        .then(res => {
            resolve(res)
        })        
        .catch(err => {        
            return err;
        })           
    })
}

export function getCitiesWithDeps(){
    return new Promise((resolve, reject) => {
        const headers = getHeaders();
        Axios.get(`${basepath}/get-cites-with-deps`, headers).then((res) => {
            resolve(res.data);
        }).catch(err => {
            reject(err)
        });
    })
}

export function getSectors(){
    return new Promise((resolve, reject) => {
        const headers = getHeaders();
        Axios.get(`${basepath}/get-sectors`, headers).then((res) => {
            resolve(res.data);
        }).catch(err => {
            reject(err)
        });
    })
}

export function citiesAndDeps(){
    return new Promise((resolve, reject) => {
        const headers = getHeaders();
        Axios.get(`${basepath}/get-cities-and-deps`, headers).then(res => {
            resolve(res.data)
        }).catch(err => {
            reject(err)
        });
    });
}