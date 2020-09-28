import { HOST } from '../settings.js';

export class Auth {

    async login(params){
        let form = new FormData();
        form.append('nik', params.nik);
        form.append('password', params.password);
    
        let requestOptions = { method: 'POST', body: form }
    
        const res = await fetch('home/login', requestOptions)
            .then(result => { return result.json() })
            .catch(error => { console.log('error', error) })
        return res;
    }

}
