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
        >
            <div className="auth-content">
                {showBack && (
                    <button type="button" className="auth-back" onClick={onBack}>
                        <svg width="10" height="18" viewBox="0 0 10 18" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round">
                            <path d="M9 1L1 9L9 17" />
                        </svg>
                        Back
                    </button>
                )}
                <div className="auth-header">
                    <div className="auth-logo" />
                    <h1 className="auth-title">{title}</h1>
                    <p className="auth-subtitle">{subtitle}</p>
                </div>
                {children}
            </div>
        </motion.div>
    )
}