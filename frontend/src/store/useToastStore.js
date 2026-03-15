import { create } from 'zustand'

const useToastStore = create((set) => ({
    toasts: [],

    addToast: (message, type = 'success') => {
        const id = crypto.randomUUID()
        set((state) => ({
            toasts: [...state.toasts, { id, message, type }],
        }))
        return id
    },

    removeToast: (id) => {
        set((state) => ({
            toasts: state.toasts.filter((t) => t.id !== id),
        }))
    },
}))

export default useToastStore