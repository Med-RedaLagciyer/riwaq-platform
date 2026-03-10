import { create } from 'zustand'
import { persist } from 'zustand/middleware'

const useAuthStore = create(
    persist(
        (set) => ({
            user: null,
            token: null,
            role: null,

            setAuth: (user, token, role) => set({ user, token, role }),
            clearAuth: () => set({ user: null, token: null, role: null}),

            isAuthenticated: () => {
                const state = useAuthStore.getState()
                return !!state.token
            },
        }),
        {
            name: 'riwaq-auth',
        }
    )
)

export default useAuthStore