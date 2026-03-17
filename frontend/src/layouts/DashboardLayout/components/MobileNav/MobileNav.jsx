import { useState, useEffect, useRef } from 'react'
import { useLocation, NavLink } from 'react-router-dom'
import { Search, Menu, X, LogOut } from 'lucide-react'
import { motion, AnimatePresence } from 'framer-motion'
import useAuthStore from '../../../../store/useAuthStore'
import './MobileNav.css'
import { User, Home } from 'lucide-react'
import useThemeStore from '../../../../store/useThemeStore'
import { useNavigate } from 'react-router-dom'

export default function MobileNav({ navGroups, onSearchOpen }) {
    const [isDrawerOpen, setIsDrawerOpen] = useState(false)
    const [isVisible, setIsVisible] = useState(true)
    const lastScrollY = useRef(0)
    const location = useLocation()

    const user = useAuthStore((state) => state.user)
    const clearAuth = useAuthStore((state) => state.clearAuth)

    const allItems = navGroups.flatMap(g => g.items)
    const currentItem = allItems.find(item => item.path === location.pathname)

    const navigate = useNavigate()
    const { theme, setTheme } = useThemeStore()

    const handleLogout = () => {
        clearAuth()
        window.location.href = '/login'
    }

    useEffect(() => {
        const handleScroll = () => {
            const currentScrollY = window.scrollY
            if (currentScrollY < lastScrollY.current) {
                setIsVisible(true)
            } else if (currentScrollY > lastScrollY.current && currentScrollY > 50) {
                setIsVisible(false)
            }
            lastScrollY.current = currentScrollY
        }

        window.addEventListener('scroll', handleScroll, { passive: true })
        return () => window.removeEventListener('scroll', handleScroll)
    }, [])

    return (
        <>
            <div className={`mobile-nav ${isVisible ? 'mobile-nav--visible' : 'mobile-nav--hidden'}`}>
                <div className="mobile-nav__logo" />
                <button className="mobile-nav__search" onClick={onSearchOpen}>
                    <Search size={18} />
                </button>
                <span className="mobile-nav__title">
                    {currentItem?.label || 'Dashboard'}
                </span>
                <button className="mobile-nav__menu" onClick={() => setIsDrawerOpen(true)}>
                    <Menu size={20} />
                </button>
            </div>

            <AnimatePresence>
                {isDrawerOpen && (
                    <>
                        <motion.div
                            className="mobile-drawer__backdrop"
                            initial={{ opacity: 0 }}
                            animate={{ opacity: 1 }}
                            exit={{ opacity: 0 }}
                            transition={{ duration: 0.2 }}
                            onClick={() => setIsDrawerOpen(false)}
                        />
                        <motion.div
                            className="mobile-drawer"
                            initial={{ y: '100%' }}
                            animate={{ y: 0 }}
                            exit={{ y: '100%' }}
                            transition={{ duration: 0.3, ease: [0.25, 0.1, 0.25, 1] }}
                        >
                            <div className="mobile-drawer__header">
                                <span className="mobile-drawer__title">Menu</span>
                                <button className="mobile-drawer__close" onClick={() => setIsDrawerOpen(false)}>
                                    <X size={18} />
                                </button>
                            </div>

                            <div className="mobile-drawer__nav">
                                {navGroups.map((group, groupIndex) => (
                                    <div key={groupIndex} className="mobile-drawer__group">
                                        {group.items.map((item) => (
                                            item.children ? (
                                                <div key={item.label}>
                                                    <div className="mobile-drawer__item mobile-drawer__item--parent">
                                                        <item.icon size={18} />
                                                        <span>{item.label}</span>
                                                    </div>
                                                    <div className="mobile-drawer__children">
                                                        {item.children.map((child) => (
                                                            <NavLink
                                                                key={child.path}
                                                                to={child.path}
                                                                className={({ isActive }) => `mobile-drawer__child ${isActive ? 'mobile-drawer__child--active' : ''}`}
                                                                onClick={() => setIsDrawerOpen(false)}
                                                            >
                                                                {child.label}
                                                            </NavLink>
                                                        ))}
                                                    </div>
                                                </div>
                                            ) : (
                                                <NavLink
                                                    key={item.path}
                                                    to={item.path}
                                                    className={({ isActive }) => `mobile-drawer__item ${isActive ? 'mobile-drawer__item--active' : ''}`}
                                                    onClick={() => setIsDrawerOpen(false)}
                                                >
                                                    <item.icon size={18} />
                                                    <span>{item.label}</span>
                                                </NavLink>
                                            )
                                        ))}
                                        {groupIndex < navGroups.length - 1 && <div className="mobile-drawer__divider" />}
                                    </div>
                                ))}
                            </div>

                            <div className="mobile-drawer__bottom">
                                <div className="mobile-drawer__user">
                                    <div className="mobile-drawer__avatar">
                                        {user?.firstName?.charAt(0)}{user?.lastName?.charAt(0)}
                                    </div>
                                    <div className="mobile-drawer__user-info">
                                        <span className="mobile-drawer__user-name">{user?.firstName} {user?.lastName}</span>
                                        <span className="mobile-drawer__user-email">{user?.email}</span>
                                    </div>
                                </div>

                                <div className="mobile-drawer__actions">
                                    <button className="mobile-drawer__action" onClick={() => { navigate('/management/profile'); setIsDrawerOpen(false) }}>
                                        <span>My Profile</span>
                                        <User size={15} />
                                    </button>
                                    <button className="mobile-drawer__action" onClick={() => { navigate('/'); setIsDrawerOpen(false) }}>
                                        <span>Home page</span>
                                        <Home size={15} />
                                    </button>
                                    <button className="mobile-drawer__action">
                                        <span>Keyboard shortcuts</span>
                                        <kbd>?</kbd>
                                    </button>
                                </div>

                                <div className="mobile-drawer__theme">
                                    <span className="mobile-drawer__theme-label">Theme</span>
                                    <div className="mobile-drawer__theme-switcher">
                                        <button className={`mobile-drawer__theme-option ${theme === 'system' ? 'mobile-drawer__theme-option--active' : ''}`} onClick={() => setTheme('system')}>System</button>
                                        <button className={`mobile-drawer__theme-option ${theme === 'light' ? 'mobile-drawer__theme-option--active' : ''}`} onClick={() => setTheme('light')}>Light</button>
                                        <button className={`mobile-drawer__theme-option ${theme === 'dark' ? 'mobile-drawer__theme-option--active' : ''}`} onClick={() => setTheme('dark')}>Dark</button>
                                    </div>
                                </div>

                                <button className="mobile-drawer__logout" onClick={handleLogout}>
                                    <LogOut size={16} />
                                    <span>Log out</span>
                                </button>
                            </div>
                        </motion.div>
                    </>
                )}
            </AnimatePresence>
        </>
    )
}