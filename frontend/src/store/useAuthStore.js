import { create } from 'zustand'
import { persist } from 'zustand/middleware'

const useAuthStore = create(
    persist(
        (set) => ({
            user: null,
            token: null,
            role: null,
            refreshToken: null,
            setAuth: (user, token, role, refreshToken) => set({ user, token, role, refreshToken }),
            clearAuth: () => set({
                user: null,
                token: null,
                role: null,
                refreshToken: null,
                pendingEmail: null,
                temporaryToken: null
            }),

            isAuthenticated: () => {
                const state = useAuthStore.getState()
                return !!state.token
            },

            // We store the pending email for when a user types in email in register, it gets stored to be used in verify email, after that we clear it
            pendingEmail: null,
            setPendingEmail: (email) => set({ pendingEmail: email }),
            clearPendingEmail: () => set({ pendingEmail: null }),

            // for the temporary token for the complete register page
            temporaryToken: null,
            setTemporaryToken: (token) => set({ temporaryToken: token }),
            clearTemporaryToken: () => set({ temporaryToken: null }),
        }),
        {
            name: 'riwaq-auth',
        }
    )
)

export default useAuthStore