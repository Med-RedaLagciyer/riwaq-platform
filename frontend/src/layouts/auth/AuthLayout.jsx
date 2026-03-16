// eslint-disable-next-line no-unused-vars
import { motion } from 'framer-motion'
import './AuthLayout.css'

export default function AuthLayout({ children, title, subtitle, showBack, onBack }) {
    return (
        <motion.div
            className="auth-page"
            initial={{ opacity: 0, scale: 0.90, y: 8 }}
            animate={{ opacity: 1, scale: 1, y: 0 }}
            exit={{ opacity: 0, scale: 0.98, y: -8 }}
            transition={{ duration: 0.6, ease: [0.25, 0.1, 0.25, 1] }}
            style={{ backgroundColor: 'var(--bg-base)' }}
        >
            <div className="auth-content">
                <div className="auth-header">
                    <div className="auth-logo" />
                    <h1 className="auth-title">{title}</h1>
                    <p className="auth-subtitle">{subtitle}</p>
                </div>
                {children}
                <button
                    type="button"
                    className="auth-back"
                    onClick={onBack}
                    style={{ visibility: showBack ? 'visible' : 'hidden' }}
                >
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12" />
                        <polyline points="12 19 5 12 12 5" />
                    </svg>
                    Back
                </button>
            </div>
        </motion.div>
    )
}