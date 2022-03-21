import Vue from 'vue';
import VueRouter from "vue-router";
import Contacts from "./pages/Contacts";
import Home from './pages/Home';
import Error from './pages/Error';
import PostShow from './pages/posts/Show';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
          path: '/home',
            component: Home,
            name: 'home.index',
            meta:
                {
                    title: 'Homepage',
                    nameLinkNav: 'Home'
                }
        },
        {
            path: '/contacts',
            component: Contacts,
            name: 'contacts.index',
            meta:
                {
                    title: 'Contacts',
                    nameLinkNav: 'Contacts'
                }
        },
        {
            path: '/posts/:post',
            component: PostShow,
            name: 'posts.show',
            meta:
                {
                    title: 'Dettagli Post',
                }
        },
        /*{
            il path entra in conflitto con quello dello show

            path: '/post/create',
            component: PostCreate,
            name: 'post.create',
            meta:
                {
                    title: 'Creazione Post',
                    nameLinkNav: 'Create Post'
                }
        },*/
        {
            path: '*',
            component: Error,
            name: 'error',
/*            redirect:
                {
                    name: 'home.index'
                }*/
        }
    ]
});

router.beforeEach((to, from, next) => {
    document.title = to.meta.title;
    next();
});

export default router;

// in questo modo passiamo tutto il file router.js
// se volessimo passare solo una variabile potremmo fare | export {router}; | (che in questo caso è il nome della nostra costante (const router) )
// se router fosse una variabile avremmo dovuto fare | import {router} from './router'; | nel file di destinazione
