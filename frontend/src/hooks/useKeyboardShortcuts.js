import { useEffect, useRef } from 'react';

function normalizeEvent(e) {
    const parts = [];

    if (e.ctrlKey || e.metaKey) parts.push('ctrl');
    if (e.altKey) parts.push('alt');
    if (e.shiftKey) parts.push('shift');

    parts.push(e.key.toLowerCase());

    return parts.join('+');
}

export function useKeyboardShortcuts(shortcuts, { enabled = true } = {}) {
    const shortcutsRef = useRef(shortcuts);

    useEffect(() => {
        shortcutsRef.current = shortcuts;
    }, [shortcuts]);

    useEffect(() => {
        if (!enabled) return;

        function handleKeyDown(e) {
            const tag = e.target?.tagName?.toLowerCase();
            const isEditable = e.target?.isContentEditable;
            if (tag === 'input' || tag === 'textarea' || tag === 'select' || isEditable) {
                if (e.key.toLowerCase() !== 'escape') return;
            }

            const key = normalizeEvent(e);
            const handler = shortcutsRef.current[key];
            if (handler) handler(e);
        }

        window.addEventListener('keydown', handleKeyDown);

        return () => {
            window.removeEventListener('keydown', handleKeyDown);
        };
    }, [enabled]);

}