import { useState, useEffect } from 'react'
import { ChevronsUpDown, Plus, Building2 } from 'lucide-react'
import { motion, AnimatePresence } from 'framer-motion'
import { useNavigate } from 'react-router-dom'
import './OrganisationSelector.css'

export default function OrganisationSelector({ isOpen, onToggle, onClose }) {
    const [query, setQuery] = useState('')
    const navigate = useNavigate()
    const isMobile = window.innerWidth <= 1024

    const organisations = [] // will come from API later

    const filtered = organisations.filter(org =>
        org.name.toLowerCase().includes(query.toLowerCase())
    )

    const handleClose = () => {
        setQuery('')
        onClose()
    }

    useEffect(() => {
        const handleKeyDown = (e) => {
            if (e.key === 'Escape') handleClose()
        }
        if (isOpen) window.addEventListener('keydown', handleKeyDown)
        return () => window.removeEventListener('keydown', handleKeyDown)
    }, [isOpen, onClose])

    return (
        <div className="org-selector">
            <button
                className={`org-selector__trigger ${isOpen ? 'org-selector__trigger--open' : ''}`}
                onClick={onToggle}
            >
                <span>All Organisations</span>
                <ChevronsUpDown size={14} />
            </button>

            <AnimatePresence>
                {isOpen && (
                    <>
                        <div className="org-selector__backdrop" onClick={handleClose} />
                        <motion.div
                            className="org-selector__dropdown"
                            style={isMobile ? { left: '50%', x: '-50%' } : {}}
                            initial={{ opacity: 0, scale: 0.96, y: -4 }}
                            animate={{ opacity: 1, scale: 1, y: 0 }}
                            exit={{ opacity: 0, scale: 0.96, y: -4 }}
                            transition={{ duration: 0.15, ease: [0.25, 0.1, 0.25, 1] }}
                        >
                            <div className="org-selector__search">
                                <input
                                    className="org-selector__input"
                                    placeholder="Find Organisation..."
                                    value={query}
                                    onChange={(e) => setQuery(e.target.value)}
                                    autoFocus
                                />
                                <kbd>Esc</kbd>
                            </div>

                            <div className="org-selector__body">
                                {filtered.length > 0 ? (
                                    filtered.map(org => (
                                        <button key={org.id} className="org-selector__item">
                                            <Building2 size={15} />
                                            <span>{org.name}</span>
                                        </button>
                                    ))
                                ) : (
                                    <div className="org-selector__empty">
                                        <Building2 size={24} />
                                        <span>No organisations, yet!</span>
                                    </div>
                                )}
                            </div>

                            <div className="org-selector__footer">
                                <button
                                    className="org-selector__create"
                                    onClick={() => { navigate('/management/organisations/create'); handleClose() }}
                                >
                                    <Plus size={15} />
                                    <span>Create Organisation</span>
                                </button>
                            </div>
                        </motion.div>
                    </>
                )}
            </AnimatePresence>
        </div>
    )
}