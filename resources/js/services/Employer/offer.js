import Axios from "axios";
import { getHeaders } from '../Auth';
const baseurl = '/api/employer/offers';


export function storeOffer(payload){
    return new Promise((resolve, reject) => {
        const headers = getHeaders();
        Axios.post(`${baseurl}`, payload, headers).then(res => {            
            resolve(res.data)
        }).catch(err => {
            reject(err)
        });
    })
}

export function attachCitiesAndDeps(payload, offerID){    
    return new Promise((resolve, reject) => {
        const headers = getHeaders();
        Axios.post(`${baseurl}/attach-cities-and-deps`, payload, headers).then(res => {
            resolve(res.data)
        }).catch(err => {
            reject(err)
        });
    })
}

export function attachCategory(payload){
    return new Promise((resolve, reject) => {
        const headers = getHeaders();
        Axios.post(`${baseurl}/attach-category`, payload, headers).then(res => {
            resolve(res.data)
        }).catch(err => {
            reject(err)
        });
    })
}

export function list(url = null){
    let apiUrl = url ? url : baseurl;
    return new Promise((resolve, reject) => {
        const headers = getHeaders();
        Axios.get(`${apiUrl}`, headers).then(res => {                        
            resolve(res.data);
        }).catch(err => {
            reject(err)
        });
    });
}

export function show(id){
    return new Promise((resolve, reject) => {
        const headers = getHeaders();
        Axios.get(`${baseurl}/show/${id}`, headers).then(res => {
            resolve(res.data)
        }).catch(err => {
            reject(err)
        })
    })    
}

export function edit(id){
    return new Promise((resolve, reject)=> {
        const headers = getHeaders();
        Axios.get(`${baseurl}/${id}/edit`, headers).then(res => {
            resolve(res.data)
        }).catch(err => {
            reject(err)
        })
    })
}

export function destroy(id){
    return new Promise((resolve, reject) => {
        const headers = getHeaders();
        Axios.delete(`${baseurl}/${id}`, headers).then(res => {
            resolve(res.data)
        }).catch(err => {
            reject(err)
        })
    })    
}