import { useEffect } from 'react'
import { RouterProvider } from 'react-router-dom'
import router from './router/index'
import useThemeStore from './store/useThemeStore'
import ThemeToggle from './components/ui/ThemeToggle/ThemeToggle'
import Toast from './components/ui/Toast/Toast'
import useAuthStore from './store/useAuthStore'

const getSystemTheme = () =>
    window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'

const applyTheme = (theme) => {
    const resolved = theme === 'system' ? getSystemTheme() : theme
    document.documentElement.setAttribute('data-theme', resolved)
}

function App() {
    const { theme } = useThemeStore()
    const token = useAuthStore((state) => state.token)

    useEffect(() => {
        applyTheme(theme)
    }, [theme])

    return (
        <>
            <RouterProvider router={router} />
            {!token && <ThemeToggle />}
            <Toast />
        </>
    )
}

export default App