import MyFriends from './components/MyFrindsComponent.vue'
import FriendRequests from './components/FriendRequestsComponent.vue'
import FindFriends from './components/FindFriendsComponent.vue'
import UserProfile from './components/UserProfileComponent.vue'
import Login from './components/auth/LoginComponent.vue'
import Register from './components/auth/RegisterComponent.vue'
import Reset from './components/auth/ResetComponent.vue'
import Email from './components/auth/EmailComponent.vue'

const routes = [
    { path: '/friends', component: MyFriends },
    { path: '/friends/find', component: FindFriends },
    { path: '/friends/requests', component: FriendRequests },
    { path: '/profile', component: UserProfile },
    { path: '/login', component: Login },
    { path: '/register', component: Register },
    { path: '/reset', component: Reset },
    { path: '/email', component: Email }
    // { path: '*', redirect: '/list' },
];

export default routes;