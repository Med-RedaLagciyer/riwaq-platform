import './Sidebar.css'
import { NavLink } from 'react-router-dom'
import CommandPalette from '../../../../components/ui/CommandPalette/CommandPalette'
import { useState, useEffect, useRef, useCallback } from 'react'
import useAuthStore from '../../../../store/useAuthStore'
import UserMenu from '../UserMenu/UserMenu'
import { LayoutDashboard, Building2, Settings, ChevronDown, Search } from 'lucide-react'
import Tooltip from '../../../../components/ui/Tooltip/Tooltip'

const COLLAPSED_WIDTH = 56
const DEFAULT_WIDTH = 240
const MAX_WIDTH = 400
const COLLAPSE_THRESHOLD = 180

export default function Sidebar() {
    const [isUserMenuOpen, setIsUserMenuOpen] = useState(false)
    const user = useAuthStore((state) => state.user)
    const [isPaletteOpen, setIsPaletteOpen] = useState(false)
    const sidebarRef = useRef(null)
    const [width, setWidth] = useState(DEFAULT_WIDTH)
    const [isDragging, setIsDragging] = useState(false)
    const prevWidthRef = useRef(DEFAULT_WIDTH)
    const startWidthRef = useRef(DEFAULT_WIDTH)

    const isCollapsed = width <= COLLAPSED_WIDTH

    const handleMouseDown = useCallback((e) => {
        e.preventDefault()
        startWidthRef.current = width
        setIsDragging(true)
    }, [width])

    useEffect(() => {
        const handleMouseMove = (e) => {
            if (!isDragging) return
            const newWidth = e.clientX
            const clampedWidth = Math.max(COLLAPSED_WIDTH, Math.min(MAX_WIDTH, newWidth))
            prevWidthRef.current = width
            setWidth(clampedWidth)
        }

        const handleMouseUp = () => {
            if (!isDragging) return
            setIsDragging(false)

            const isExpanding = width > startWidthRef.current

            if (isExpanding) {
                if (width > COLLAPSED_WIDTH + 30) {
                    setWidth(DEFAULT_WIDTH)
                } else {
                    setWidth(COLLAPSED_WIDTH)
                }
            } else {
                if (width < COLLAPSE_THRESHOLD) {
                    setWidth(COLLAPSED_WIDTH)
                }
            }
        }

        window.addEventListener('mousemove', handleMouseMove)
        window.addEventListener('mouseup', handleMouseUp)
        return () => {
            window.removeEventListener('mousemove', handleMouseMove)
            window.removeEventListener('mouseup', handleMouseUp)
        }
    }, [isDragging, width])

    useEffect(() => {
        const handleKeyDown = (e) => {
            if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                e.preventDefault()
                setIsPaletteOpen(true)
            }
            if (e.key === 'Escape') {
                setIsPaletteOpen(false)
            }
        }

        window.addEventListener('keydown', handleKeyDown)
        return () => window.removeEventListener('keydown', handleKeyDown)
    }, [])

    const navGroups = [
        {
            items: [
                { label: 'Dashboard', path: '/management/dashboard', icon: LayoutDashboard },
                { label: 'Organisations', path: '/management/organisations', icon: Building2 },
            ]
        },
        {
            items: [
                { label: 'Settings', path: '/management/settings', icon: Settings },
            ]
        },
    ]

    const allItems = navGroups.flatMap(group => group.items)

    return (
        <aside
            ref={sidebarRef}
            className={`sidebar ${isDragging ? 'sidebar--dragging' : ''}`}
            style={{ width: `${width}px` }}
        >
            <div className="sidebar__top">
                <div className={`sidebar__brand ${isCollapsed ? 'sidebar__brand--collapsed' : ''}`}>
                    <div className="sidebar__logo" />
                    {!isCollapsed && <span className="sidebar__brand-name">RIWAQ</span>}
                </div>
            </div>

            <nav className="sidebar__nav">

                {isCollapsed ? (
                    <>
                        <Tooltip text="⌘K" position="right">
                            <button
                                className="sidebar__nav-item sidebar__search--collapsed"
                                onClick={() => setIsPaletteOpen(true)}
                            >
                                <Search size={18} />
                            </button>
                        </Tooltip>
                        <div className="sidebar__divider" />
                    </>
                ) : (
                    <>
                        <button className="sidebar__search" onClick={() => setIsPaletteOpen(true)}>
                            <Search size={14} />
                            <span>Search...</span>
                            <kbd>⌘K</kbd>
                        </button>

                        <div className="sidebar__divider" />
                    </>
                )}

                <CommandPalette
                    key={isPaletteOpen}
                    items={allItems}
                    isOpen={isPaletteOpen}
                    onClose={() => setIsPaletteOpen(false)}
                />

                {navGroups.map((group, groupIndex) => (
                    <div key={groupIndex} className="sidebar__nav-group">
                        {group.items.map((item) => (
                            <NavLink
                                key={item.path}
                                to={item.path}
                                className={({ isActive }) => `sidebar__nav-item ${isActive ? 'sidebar__nav-item--active' : ''} ${isCollapsed ? 'sidebar__nav-item--collapsed' : ''}`}
                            >
                                <item.icon size={18} />
                                {!isCollapsed && <span>{item.label}</span>}
                            </NavLink>
                        ))}
                        {groupIndex < navGroups.length - 1 && (
                            <div className="sidebar__divider" />
                        )}
                    </div>
                ))}
            </nav>

            <div className="sidebar__bottom">
                <UserMenu
                    isOpen={isUserMenuOpen}
                    onClose={() => setIsUserMenuOpen(false)}
                />
                <Tooltip text={`${user?.firstName} ${user?.lastName}`} position={isCollapsed ? 'right' : 'top'}>
                    <button
                        className={`sidebar__user ${isUserMenuOpen ? 'sidebar__user--active' : ''}`}
                        onClick={() => setIsUserMenuOpen(!isUserMenuOpen)}
                    >
                        <div className="sidebar__avatar">
                            {user?.firstName?.charAt(0)}{user?.lastName?.charAt(0)}
                        </div>
                        {!isCollapsed && (
                            <div className="sidebar__user-info">
                                <span className="sidebar__user-name">{user?.firstName} {user?.lastName}</span>
                                <span className="sidebar__user-email">{user?.email}</span>
                            </div>
                        )}
                        {!isCollapsed && (
                            <ChevronDown size={14} className={`sidebar__user-chevron ${isUserMenuOpen ? 'sidebar__user-chevron--open' : ''}`} />
                        )}
                    </button>
                </Tooltip>
            </div>

            <div
                className={`sidebar__resize-handle ${isDragging ? 'sidebar__resize-handle--dragging' : ''}`}
                onMouseDown={handleMouseDown}
            />
        </aside>
    )
}