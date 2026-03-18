import { useEffect } from 'react'
import { useNavigate } from 'react-router-dom'
import { motion, AnimatePresence } from 'framer-motion'
import { User, Home, Keyboard, LogOut } from 'lucide-react'
import useAuthStore from '../../../../store/useAuthStore'
import useThemeStore from '../../../../store/useThemeStore'
import './UserMenu.css'

export default function UserMenu({ isOpen, onClose }) {
    const navigate = useNavigate()
    const user = useAuthStore((state) => state.user)
    const clearAuth = useAuthStore((state) => state.clearAuth)
    const { theme, setTheme } = useThemeStore()

    useEffect(() => {
        const handleKeyDown = (e) => {
            if (e.key === 'Escape') onClose()
        }
        window.addEventListener('keydown', handleKeyDown)
        return () => window.removeEventListener('keydown', handleKeyDown)
    }, [onClose])

    const handleLogout = () => {
        clearAuth()
        window.location.href = '/login'
    }

    return (
        <AnimatePresence>
            {isOpen && (
                <>
                    <div className="user-menu__backdrop" onClick={onClose} />
                    <motion.div
                        className="user-menu"
                        initial={{ opacity: 0, scale: 0.96, y: 8 }}
                        animate={{ opacity: 1, scale: 1, y: 0 }}
                        exit={{ opacity: 0, scale: 0.96, y: 8 }}
                        transition={{ duration: 0.15, ease: [0.25, 0.1, 0.25, 1] }}
                    >
                        <div className="user-menu__section">
                            <button className="user-menu__item" onClick={() => { navigate('/management/profile'); onClose() }}>
                                <span>My Profile</span>
                                <User size={15} />
                            </button>
                            <button className="user-menu__item" onClick={() => { navigate('/'); onClose() }}>
                                <span>Home page</span>
                                <Home size={15} />
                            </button>
                            <button className="user-menu__item">
                                <span>Keyboard shortcuts</span>
                                <kbd>?</kbd>
                            </button>
                        </div>

                        <div className="user-menu__divider" />

                        <div className="user-menu__section">
                            <div className="user-menu__label">
                                Theme
                                <kbd>⌘ + ⇧ + L</kbd>
                            </div>
                            <div className="user-menu__theme-switcher">
                                <button
                                    className={`user-menu__theme-option ${theme === 'system' ? 'user-menu__theme-option--active' : ''}`}
                                    onClick={() => setTheme('system')}
                                >
                                    System
                                </button>
                                <button
                                    className={`user-menu__theme-option ${theme === 'light' ? 'user-menu__theme-option--active' : ''}`}
                                    onClick={() => setTheme('light')}
                                >
                                    Light
                                </button>
                                <button
                                    className={`user-menu__theme-option ${theme === 'dark' ? 'user-menu__theme-option--active' : ''}`}
                                    onClick={() => setTheme('dark')}
                                >
                                    Dark
                                </button>
                            </div>
                        </div>

                        <div className="user-menu__divider" />

                        <div className="user-menu__section">
                            <button className="user-menu__logout" onClick={handleLogout}>
                                <LogOut size={15} />
                                <span>Log out</span>
                            </button>
                        </div>

                        <div className="user-menu__divider" />
                    </motion.div>
                </>
            )}
        </AnimatePresence>
    )
}