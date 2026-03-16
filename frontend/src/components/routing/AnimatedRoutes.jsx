// eslint-disable-next-line no-unused-vars
import { AnimatePresence, motion } from 'framer-motion'
import { useLocation, Outlet } from 'react-router-dom'

export default function AnimatedRoutes() {
    const location = useLocation()

    return (
        <AnimatePresence mode="wait">
            <motion.div
                key={location.pathname}
                style={{ width: '100%', minHeight: '100vh', backgroundColor: 'var(--bg-base)' }}
            >
                <Outlet />
            </motion.div>
        </AnimatePresence>
    )
}