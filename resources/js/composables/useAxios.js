import {ref} from 'vue';
import axios from 'axios';
import router from "../router/index.js";
import {useRouter} from "vue-router";
import {useToast} from "vue-toastification";

const axiosInstance = axios.create({
    baseURL: import.meta.env.VITE_APP_URL + import.meta.env.VITE_API_PREFIX,
    withCredentials: true,
    xsrfHeaderName: "X-XSRF-TOKEN",
    Accept: "application/json",
    "Content-Type": "multipart/form-data"
});

export default function useAxios() {
    const getAuthStore = async () => {
        const {useAuthStore} = await import('@/stores/useAuthStore.js');
        return useAuthStore();
    }

    const router = useRouter()
    const toast = useToast();
    const loading = ref(false);
    const error = ref(null);

    const sendRequest = async (config, globalLoading = loading) => {
        globalLoading.value = true;
        error.value = null
        try {
            const authStore = await getAuthStore();
            return await axiosInstance({
                ...config,
                headers: {
                    'Content-Type': 'multipart/form-data',
                    Authorization: `Bearer ${authStore?.user?.token}`
                }
            });
        } catch (err) {
            error.value = err;
            console.log("get err in axios", err.response.status)
            if(err.response.status === 401){
                toast.error(err.message)
                await router.push({name: "NotFound"})
            }
            throw err;
        } finally {
            globalLoading.value = false;
        }
    };

    return {
        loading,
        error,
        sendRequest,
    };
}
