Vue.component('greeting', {
    template: '<h1>Welcome to coligo!</h1>'
});

var Toggle = Vue.extend({
    template: '#vue-toggle',
    props: ['values','selected','default'],
    ready: function () {
        this.selected = this.default;
    },
    methods: {
        changeSelectVal: function(val) {
            this.selected = val;
            vm.getTables();
        }
    }
});
Vue.component('vue-toggle', Toggle);

// create a new Vue instance and mount it to our div element above with the id of app
var vm = new Vue({
    el: '#dashboard',
    data:{
        date: moment().format('YYYY-MM-DD'),
        franja: '2',
        franjas: {
            '1': 'Mañana',
            '2': 'Tarde',
            '3': 'Noche'
        },
        tables:{

        }
    },
    methods: {
        getBookings: function() {

            var formData = new FormData();

            formData.append('date', vm.date);
            formData.append('franja', vm.franja);

            this.$http.post('/index.php?option=com_bookatable&task=dashboard.getBookings', formData).then((response) => {
                // success callback
            }, (response) => {
                // error callback
            });
        },
        getTables: function() {

            var formData = new FormData();

            formData.append('date', vm.date);
            formData.append('franja', vm.franja);

            this.$http.post('/index.php?option=com_bookatable&task=dashboard.getTables', formData).then((response) => {
                vm.tables = JSON.parse(response.body).tables;
            }, (response) => {
                // error callback
            });
        }
    }
});

vm.getTables();
vm.getBookings();
