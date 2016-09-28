Vue.component('greeting', {
    template: '<h1>Welcome to coligo!</h1>'
});

// create a new Vue instance and mount it to our div element above with the id of app
var vm = new Vue({
    el: '#dashboard',
});
