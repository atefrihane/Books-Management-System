require('./bootstrap');

window.Vue = require('vue');
//Sweetalert
import swal2 from 'sweetalert2'
window.swal2 = swal2;
//Progressbar
import VueProgressBar from 'vue-progressbar'

Vue.use(VueProgressBar, {
        color: 'rgb(143, 255, 199)',
        failedColor: 'red',
        height: '2px'
    })
    //Toast
const toast = swal2.mixin({
    toast: true,
    position: 'center-end',
    showConfirmButton: false,
    timer: 2000,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', swal.stopTimer)
        toast.addEventListener('mouseleave', swal.resumeTimer)
    }
})
window.toast = toast;

// books
Vue.component('show-books', require('./components/ShowBooks.vue').default);
Vue.component('add-book', require('./components/ShowAddBook.vue').default);
Vue.component('update-book', require('./components/ShowUpdateBook.vue').default);





//articles

Vue.component('show-general-articles', require('./components/ShowGeneralArticles.vue').default);
Vue.component('add-article', require('./components/ShowAddArticle.vue').default);
Vue.component('update-article', require('./components/ShowUpdateArticle.vue').default);

//orders

Vue.component('show-orders', require('./components/ShowOrders.vue').default);
Vue.component('show-order', require('./components/ShowOrder.vue').default);


//supports

Vue.component('show-supports', require('./components/ShowSupports.vue').default);

//reviews

Vue.component('show-reviews', require('./components/ShowReviews.vue').default);

//authors

Vue.component('show-general-authors', require('./components/ShowGeneralAuthors.vue').default);
Vue.component('add-author', require('./components/ShowAddAuthor.vue').default);
Vue.component('update-author', require('./components/ShowUpdateAuthor.vue').default);
//users

Vue.component('show-users', require('./components/ShowUsers.vue').default);
Vue.component('add-user', require('./components/ShowAddUser.vue').default);
Vue.component('update-user', require('./components/ShowUpdateUser.vue').default);


//nested components

Vue.component('show-modal', require('./components/nested/ShowModal.vue').default);
Vue.component('show-articles', require('./components/nested/ShowArticles.vue').default);
Vue.component('show-authors', require('./components/nested/ShowAuthors.vue').default);
Vue.component('show-errors', require('./components/nested/ShowErrors.vue').default);

const app = new Vue({
    el: '#app',

    methods: {

        uploadFile(event, type) {
            let file = event.target.files[0]
            let limit = 1024 * 1024 * 5;
            let formats = []
            console.log(file);
            type == 0 ? formats = ['image/jpeg', 'image/jpg', 'image/png'] : type == 1 ? formats = ['application/pdf'] : formats = ['audio/mpeg']
            if (formats.includes(file['type']) && file['size'] < limit) {
                return new Promise((resolve, reject) => {
                    let reader = new FileReader();
                    reader.onload = () => {
                        let result = {
                            name: event.target.files[0].name,
                            link: reader.result
                        }


                        resolve(result);
                    };

                    reader.onerror = reject;

                    reader.readAsDataURL(event.target.files[0]);


                })

            }
            return false


        },
        uploadBinary(event) {


            return event.target.files[0]



        },
        destroyDataTable() {
            $('.table').DataTable().destroy();
        },
        updateDataTable() {
            this.$nextTick(() => {
                $('.table').DataTable({

                    "language": {
                        "url": "http://cdn.datatables.net/plug-ins/a5734b29083/i18n/French.json"
                    },
                    "bLengthChange": false,
                    "pageLength": 10,
                    "columnDefs": [{
                        "targets": "is-wrapped",
                        render: function(data, type, row) {
                            if (data.length > 50) {
                                return data.substr(0, 50) + '...';

                            } else {
                                return data.substr(0, 50);
                            }

                        }
                    }, ],
                    responsive: true,
                });
            });

        },
        ucfirst(string) {
            return string.charAt(0).toUpperCase() + string.slice(1)
        }



    }
});