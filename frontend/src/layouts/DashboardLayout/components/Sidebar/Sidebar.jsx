import './Sidebar.css'
import { useState } from 'react'
import useAuthStore from '../../../../store/useAuthStore'
import UserMenu from '../UserMenu/UserMenu'
import { ChevronDown, Search } from 'lucide-react'
import Tooltip from '../../../../components/ui/Tooltip/Tooltip'
import useSidebarResize from '../../hooks/useSidebarResize'
import NavItem from '../NavItem/NavItem'

export default function Sidebar({ navGroups, openPalette }) {
    const [isUserMenuOpen, setIsUserMenuOpen] = useState(false)
    const user = useAuthStore((state) => state.user)
    const { sidebarRef, width, isDragging, isCollapsed, handleMouseDown } = useSidebarResize()

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
                    <Tooltip text="⌘K" position="right">
                        <button
                            className="sidebar__nav-item sidebar__search--collapsed"
                            onClick={openPalette}
                        >
                            <Search size={18} />
                        </button>
                    </Tooltip>
                ) : (
                    <button className="sidebar__search" onClick={openPalette}>
                        <Search size={14} />
                        <span>Search...</span>
                        <kbd>⌘K</kbd>
                    </button>
                )}

                {navGroups.map((group, groupIndex) => (
                    <div key={groupIndex} className="sidebar__nav-group">
                        {group.items.map((item) => (
                            <NavItem
                                key={item.path || item.label}
                                item={item}
                                isCollapsed={isCollapsed}
                            />
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