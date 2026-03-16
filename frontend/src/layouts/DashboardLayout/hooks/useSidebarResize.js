import { useState, useRef, useCallback, useEffect } from 'react'

const COLLAPSED_WIDTH = 56
const DEFAULT_WIDTH = 240
const MAX_WIDTH = 400
const COLLAPSE_THRESHOLD = 180

export default function useSidebarResize() {
    const sidebarRef = useRef(null)
    const [width, setWidth] = useState(DEFAULT_WIDTH)
    const [isDragging, setIsDragging] = useState(false)
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
            setWidth(clampedWidth)
        }

        const handleMouseUp = () => {
            if (!isDragging) return
            setIsDragging(false)

            const isExpanding = width > startWidthRef.current
            if (isExpanding) {
                setWidth(width > COLLAPSED_WIDTH + 30 ? DEFAULT_WIDTH : COLLAPSED_WIDTH)
            } else {
                if (width < COLLAPSE_THRESHOLD) setWidth(COLLAPSED_WIDTH)
            }
        }

        window.addEventListener('mousemove', handleMouseMove)
        window.addEventListener('mouseup', handleMouseUp)
        return () => {
            window.removeEventListener('mousemove', handleMouseMove)
            window.removeEventListener('mouseup', handleMouseUp)
        }
    }, [isDragging, width])

    return { sidebarRef, width, isDragging, isCollapsed, handleMouseDown }
}