import MyFriends from './components/MyFrindsComponent.vue'
import FriendRequests from './components/FriendRequestsComponent.vue'
import FindFriends from './components/FindFriendsComponent.vue'
import UserProfile from './components/UserProfileComponent.vue'
import BlockedUsers from './components/BlockedUsersComponent.vue'
import Login from './components/auth/LoginComponent.vue'
import Register from './components/auth/RegisterComponent.vue'
import Reset from './components/auth/ResetComponent.vue'
import Email from './components/auth/EmailComponent.vue'
import vm from './app';

const routes = [
    {
        path: '/friends',
        name: 'Friends',
        component: MyFriends,
        meta: {requiresAuth: true}
    },
    {
        path: '/friends/find',
        name: 'Find_Friends',
        component: FindFriends,
        meta: {requiresAuth: true}
    },
    {
        path: '/friends/requests',
        name: 'Requests',
        component: FriendRequests,
        meta: {requiresAuth: true}
    },
    {
        path: '/profile/:id',
        name: 'Profile',
        component: UserProfile,
        meta: {requiresAuth: true}
    },
    {
        path: '/friends/blocked',
        name: 'Blocked',
        component: BlockedUsers,
        meta: {requiresAuth: true}
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,
    },
    {
        path: '/logout',
        name: 'Logout',
        beforeEnter: (to, from, next) => {
            localStorage.clear();
            next({name: 'Login', path: '/login'})
        }
    },
    {
        path: '/register',
        name: 'Register',
        component: Register
    },
    {
        path: '/reset',
        name: 'Reset_Pass',
        component: Reset
    },
    {
        path: '/email',
        name: 'Request_Token',
        component: Email
    }
    // { path: '*', redirect: '/list' },
];

export default routes;