import { create } from 'zustand'
import { persist } from 'zustand/middleware'

const getSystemTheme = () =>
    window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'

const applyTheme = (theme) => {
    const resolved = theme === 'system' ? getSystemTheme() : theme
    document.documentElement.setAttribute('data-theme', resolved)
}

const useThemeStore = create(
    persist(
        (set) => ({
            theme: 'light',
            setTheme: (theme) => {
                applyTheme(theme)
                set({ theme })
            },
        }),
        {
            name: 'riwaq-theme',
            onRehydrateStorage: () => (state) => {
                if (state?.theme) {
                    applyTheme(state.theme)
                }
            },
        }
    )
)

export default useThemeStore