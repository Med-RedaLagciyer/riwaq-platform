import { create } from 'zustand'

const useToastStore = create((set) => ({
    toasts: [],

    addToast: (title, type = 'success', subtext = null) => {
        const id = crypto.randomUUID()
        set((state) => ({
            toasts: [...state.toasts, { id, title, type, subtext }],
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