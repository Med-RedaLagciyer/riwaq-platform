import { useState } from 'react'
import { useNavigate } from 'react-router-dom'
import { motion, AnimatePresence } from 'framer-motion'
import './CommandPalette.css'

export default function CommandPalette({ items, isOpen, onClose }) {
    const [query, setQuery] = useState('')
    const navigate = useNavigate()

    return (
        <AnimatePresence>
            {isOpen && (
                <motion.div
                    className="command-palette__overlay"
                    initial={{ opacity: 0 }}
                    animate={{ opacity: 1 }}
                    exit={{ opacity: 0 }}
                    transition={{ duration: 0.15 }}
                    onClick={onClose}
                >
                    <motion.div
                        className="command-palette"
                        initial={{ opacity: 0, scale: 0.96, y: -8 }}
                        animate={{ opacity: 1, scale: 1, y: 0 }}
                        exit={{ opacity: 0, scale: 0.96, y: -8 }}
                        transition={{ duration: 0.2, ease: [0.25, 0.1, 0.25, 1] }}
                        onClick={(e) => e.stopPropagation()}
                    >
                        <div className="command-palette__search">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                                <circle cx="11" cy="11" r="8" />
                                <line x1="21" y1="21" x2="16.65" y2="16.65" />
                            </svg>
                            <input
                                className="command-palette__input"
                                placeholder="Search..."
                                value={query}
                                onChange={(e) => setQuery(e.target.value)}
                                autoFocus
                            />
                        </div>
                        <div className="command-palette__results">
                            {items
                                .filter(item => item.label.toLowerCase().includes(query.toLowerCase()))
                                .map(item => (
                                    <button
                                        key={item.path}
                                        className="command-palette__item"
                                        onClick={() => {
                                            navigate(item.path)
                                            onClose()
                                        }}
                                    >
                                        <item.icon size={16} />
                                        <span>{item.label}</span>
                                    </button>
                                ))
                            }
                        </div>
                    </motion.div>
                </motion.div>
            )}
        </AnimatePresence>
    )
}