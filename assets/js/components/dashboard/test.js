import Settings from '../../settings.js'
import Api from '../../modules/api.js';

const api = new Api().room();

export async function api_room(){
    const data = await api.then(res=>{
    console.log("functionapi_room -> res", res)
        return res;
    })
}

export let admin = {
    name: "John"
};

export default admin;