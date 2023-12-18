const { default: axios } = require('axios');
const { error } = require('jquery');

window._ = require('lodash');

try {
    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

// interceptando requisiçoes
axios.interceptors.request.use(
    config => {
        config.headers.Accept = 'application/json'

        let cookie = document.cookie.split(';')
                
        let token = cookie.find(
                index => index.indexOf('token=') ==! '-1'
            )
            
        if(token){
            token = token.split('=')[1]

            config.headers.Authorization = 'Bearer ' + token
        }
        return config
    },

    error =>{
        return Promise.reject(error)
    }
)

axios.interceptors.response.use(
    response =>{
        // console.log('message de response,sucess, ', response)
        return response
    },

    error => {        
        if(error.response.data.message === 'Token has expired' && error.response.status == 401){
            axios.post('http://127.0.0.1:8000/api/refresh')
                .then(
                    response => {
                        document.cookie = 'token=' + response.data + ';SameSite=Lax'
                        window.location.reload()
                        console.log(1212121,document.cookie.token)
                        console.log(1212121,response.data)
                    }
                )
                .catch(
                    error => {
                        console.log(error)
                        return error
                    }
                )
            console.log('if confirmed')
            
        }
    
        return Promise.reject(error)
    }


)