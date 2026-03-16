import { useState } from 'react'
import { NavLink } from 'react-router-dom'
import { ChevronDown } from 'lucide-react'
import { motion, AnimatePresence } from 'framer-motion'
import Tooltip from '../../../../components/ui/Tooltip/Tooltip'
import './NavItem.css'

export default function NavItem({ item, isCollapsed }) {
    const [isOpen, setIsOpen] = useState(false)
    const hasChildren = item.children && item.children.length > 0

    if (hasChildren) {
        return (
            <div className="nav-item">
                <button
                    className={`nav-item__trigger ${isOpen ? 'nav-item__trigger--open' : ''}`}
                    onClick={() => setIsOpen(!isOpen)}
                >
                    <item.icon size={18} />
                    {!isCollapsed && <span>{item.label}</span>}
                    {!isCollapsed && (
                        <ChevronDown
                            size={14}
                            className={`nav-item__chevron ${isOpen ? 'nav-item__chevron--open' : ''}`}
                        />
                    )}
                </button>

                <AnimatePresence>
                    {isOpen && !isCollapsed && (
                        <motion.div
                            className="nav-item__children"
                            initial={{ opacity: 0, height: 0 }}
                            animate={{ opacity: 1, height: 'auto' }}
                            exit={{ opacity: 0, height: 0 }}
                            transition={{ duration: 0.2, ease: [0.25, 0.1, 0.25, 1] }}
                            style={{ overflow: 'hidden' }}
                        >
                            {item.children.map((child) => (
                                <NavLink
                                    key={child.path}
                                    to={child.path}
                                    className={({ isActive }) => `nav-item__child ${isActive ? 'nav-item__child--active' : ''}`}
                                >
                                    {child.label}
                                </NavLink>
                            ))}
                        </motion.div>
                    )}
                </AnimatePresence>
            </div>
        )
    }

    return (
        <Tooltip text={item.label} position="right" disabled={!isCollapsed}>
            <NavLink
                to={item.path}
                className={({ isActive }) => `nav-item__link ${isActive ? 'nav-item__link--active' : ''} ${isCollapsed ? 'nav-item__link--collapsed' : ''}`}
            >
                <item.icon size={18} />
                {!isCollapsed && <span>{item.label}</span>}
            </NavLink>
        </Tooltip>
    )
}