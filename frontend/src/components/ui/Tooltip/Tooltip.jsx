import { useState, useRef } from 'react'
import { createPortal } from 'react-dom'
import { motion, AnimatePresence } from 'framer-motion'
import './Tooltip.css'

export default function Tooltip({ text, children, position = 'top' }) {
    const [visible, setVisible] = useState(false)
    const [coords, setCoords] = useState(null)
    const wrapperRef = useRef(null)

    const updateCoords = () => {
        if (!wrapperRef.current) return
        const rect = wrapperRef.current.getBoundingClientRect()
        setCoords({
            top: rect.top,
            left: rect.left,
            width: rect.width,
            height: rect.height,
        })
    }

    const getStyle = () => {
        if (!coords) return {}
        switch (position) {
            case 'right':
                return {
                    position: 'fixed',
                    top: coords.top + coords.height / 2,
                    left: coords.left + coords.width + 6,
                    x: 0,
                    y: '-50%',
                }
            case 'left':
                return {
                    position: 'fixed',
                    top: coords.top + coords.height / 2,
                    left: coords.left - 6,
                    x: '-100%',
                    y: '-50%',
                }
            case 'bottom':
                return {
                    position: 'fixed',
                    top: coords.top + coords.height + 6,
                    left: coords.left + coords.width / 2,
                    x: '-50%',
                    y: 0,
                }
            default: // top
                return {
                    position: 'fixed',
                    top: coords.top - 6,
                    left: coords.left + coords.width / 2,
                    x: '-50%',
                    y: '-100%',
                }
        }
    }

    return (
        <div
            ref={wrapperRef}
            className="tooltip-wrapper"
            onMouseEnter={() => {
                updateCoords()
                requestAnimationFrame(() => setVisible(true))
            }}
            onMouseLeave={() => setVisible(false)}
        >
            {children}
            {createPortal(
                <AnimatePresence>
                    {visible && coords && (
                        <motion.div
                            className="tooltip--portal"
                            style={getStyle()}
                            initial={{ opacity: 0, scale: 0.92 }}
                            animate={{ opacity: 1, scale: 1 }}
                            exit={{ opacity: 0, scale: 0.92 }}
                            transition={{ duration: 0.15, ease: [0.34, 1.56, 0.64, 1] }}
                        >
                            {text}
                        </motion.div>
                    )}
                </AnimatePresence>,
                document.body
            )}
        </div>
    )
}