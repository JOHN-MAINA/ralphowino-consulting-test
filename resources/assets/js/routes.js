import MyFriends from './components/MyFrindsComponent.vue'
import FriendRequests from './components/FriendRequestsComponent.vue'
import FindFriends from './components/FindFriendsComponent.vue'
import UserProfile from './components/UserProfileComponent.vue'
import Login from './components/auth/LoginComponent.vue'
import Register from './components/auth/RegisterComponent.vue'
import Reset from './components/auth/ResetComponent.vue'
import Email from './components/auth/EmailComponent.vue'

const routes = [
    { path: '/friends', name: 'Friends', component: MyFriends },
    { path: '/friends/find', name: 'Find_Friends', component: FindFriends },
    { path: '/friends/requests',name: 'Requests', component: FriendRequests },
    { path: '/profile', name: 'Profile', component: UserProfile },
    { path: '/login', name: 'Login', component: Login },
    { path: '/register', name: 'Register', component: Register },
    { path: '/reset', name: 'Reset_Pass', component: Reset },
    { path: '/email', name: 'Request_Token', component: Email }
    // { path: '*', redirect: '/list' },
];

export default routes;