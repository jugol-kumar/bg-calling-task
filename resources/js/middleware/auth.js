import { useAuthStore } from '@/stores/useAuthStore.js'
import {useToast} from "vue-toastification";
import {ref} from "vue";

export default (to, from, next) => {
    const auth = useAuthStore()
    const supperAdmin = ref(import.meta.env.VITE_APP_SUPPERADMIN)

    const toast = useToast();
    const loginRoute = 'Login'
    const isLoginRoute = to.name === loginRoute

    if (to.meta.can) {
        const hasPermission = to.meta.can.some(permission => auth.user.can.includes(permission));
        if (supperAdmin.value !== auth.user.roles[0]?.name || !hasPermission) {
            next();
        } else {
            next({ name: 'NotFound' });
        }
    }
    if (!auth.isLoggedIn && !isLoginRoute) {
        // toast.error('Unauthorized Access. Please Login First...')
        next({ name: 'Login' })
    }else if(auth.isLoggedIn && isLoginRoute){
        toast.warning(`Can't access login page. Already Login...`)
        next({ name: 'Dashboard' })
    } else {
        next()
    }

}