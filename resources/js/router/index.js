import { createRouter, createWebHistory } from 'vue-router'
import authMiddleware from '@/middleware/auth.js';


const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/',
      name: 'Home',
      component: () => import('@/pages/Index.vue')
    },
    {
      path: '/login',
      name: 'Login',
      component: () => import('@/pages/Auth/Login.vue')
    },
    {
      path: '/dashboard',
      name: 'Dashboard',
      meta:{
       can:['dashboard.show']
      },
      component: () => import('@/pages/Dashboard/Index.vue')
    },
      // crud page routes
    {
      path:'/roles',
      name:'Roles',
      meta:{
        can:['authorization.index']
      },
      component: ()=> import('@/pages/Role/Index.vue')
    },
    {
      path:'/add-role',
      name:'AddRoles',
      meta:{
        can:['authorization.create']
      },
      component: ()=> import('@/pages/Role/Add.vue')
    },
    {
      path:'/edit-role/:id',
      name:'EditRoles',
      meta:{
        can:['authorization.edit']
      },
      component: ()=> import('@/pages/Role/Edit.vue')
    },
      // user pages routes
    {
      path:'/users',
      name:'Users',
      meta:{
        can:['user.index']
      },
      component: () => import('@/pages/User/Index.vue')
    },
    {
      path:'/add-user',
      name:'AddUser',
      meta:{
        can:['user.create']
      },
      component: () => import('@/pages/User/Add.vue')
    },
    {
      path:'/edit-user/:id',
      name:'EditUser',
      meta:{
        can:['user.create']
      },
      component: () => import('@/pages/User/Edit.vue')
    },
    {
      path: '/settings',
      name: 'Settings',
      component: () => import('@/pages/Setting/ProfileSetting.vue')
    },
    {
      path: '/profile-setting',
      name: 'ProfileSetting',
      component: () => import('@/pages/Setting/ProfileSetting.vue')
    },

    {
      path:'/page-note-found',
      name:'NotFound',
      component: () => import('@/pages/Notfound.vue')
    }
  ]
})

router.beforeEach(authMiddleware)
export default router