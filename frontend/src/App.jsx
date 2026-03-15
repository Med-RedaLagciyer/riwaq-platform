import { useEffect } from 'react'
import { RouterProvider, useLocation, Outlet } from 'react-router-dom'
import { AnimatePresence } from 'framer-motion'
import router from './router/index'
import useThemeStore from './store/useThemeStore'
import ThemeToggle from './components/ui/ThemeToggle/ThemeToggle'
import Toast from './components/ui/Toast/Toast'
import LogoutButton from './components/ui/LogoutButton/LogoutButton'

function AnimatedApp() {
    const location = useLocation()
    return (
        <AnimatePresence mode="wait">
            <Outlet key={location.pathname} />
        </AnimatePresence>
    )
}

function App() {
    const { theme } = useThemeStore()

    useEffect(() => {
        document.documentElement.setAttribute('data-theme', theme)
    }, [theme])

    return (
        <>
            <RouterProvider router={router} />
            <ThemeToggle />
            <Toast />
            <LogoutButton />
        </>
    )
}

export default App