import { useEffect, useRef, useState } from 'react'
import useToastStore from '../../../store/useToastStore'
import './Toast.css'

function ToastItem({ toast, index, total, isExpanded }) {
    const removeToast = useToastStore((state) => state.removeToast)
    const [exiting, setExiting] = useState(false)
    const [mounted, setMounted] = useState(false)
    const timerRef = useRef(null)

    const startTimer = () => {
        timerRef.current = setTimeout(() => dismiss(), 4000)
    }

    const clearTimer = () => {
        if (timerRef.current) clearTimeout(timerRef.current)
    }

    const dismiss = () => {
        setExiting(true)
        setTimeout(() => removeToast(toast.id), 500)
    }

    useEffect(() => {
        setTimeout(() => setMounted(true), 500)
        return () => clearTimer()
    }, [])

    useEffect(() => {
        clearTimer()
        if (!isExpanded) {
            startTimer()
        }
    }, [isExpanded])

    const stackOffset = index
    const scale = isExpanded ? 1 : 1 - stackOffset * 0.06
    const translateY = !mounted ? 0 : isExpanded ? stackOffset * 52 : stackOffset * 10
    const opacity = isExpanded ? 1 : 1 - stackOffset * 0.25
    const zIndex = total - stackOffset

    return (
        <div
            className="toast-wrapper"
            style={{
                transform: `translateY(${translateY}px) scale(${scale})`,
                opacity,
                zIndex,
                transition: 'transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.4s ease',
            }}
        >
            <div className={`toast toast--${toast.type} ${exiting ? 'toast--exit' : 'toast--enter'} ${toast.subtext ? 'toast--with-subtext' : ''}`}>
                <div className="toast__main">
                    <span className="toast__dot" />
                    <span className="toast__title">{toast.title}</span>
                    <button className="toast__close" onClick={dismiss}>✕</button>
                </div>
                {toast.subtext && (
                    <span className="toast__subtext">{toast.subtext}</span>
                )}
            </div>
        </div>
    )
}

export default function Toast() {
    const toasts = useToastStore((state) => state.toasts)
    const [isExpanded, setIsExpanded] = useState(false)

    return (
        <div
            className="toast-container"
            onMouseEnter={() => setIsExpanded(true)}
            onMouseLeave={() => setIsExpanded(false)}
        >
            {[...toasts].reverse().map((toast, index) => (
                <ToastItem
                    key={toast.id}
                    toast={toast}
                    index={index}
                    total={toasts.length}
                    isExpanded={isExpanded}
                />
            ))}
        </div>
    )
}