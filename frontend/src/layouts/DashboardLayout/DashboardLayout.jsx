import './DashboardLayout.css'
import Sidebar from './components/Sidebar/Sidebar'
import TopBar from './components/TopBar/TopBar'
import MobileNav from './components/MobileNav/MobileNav'
import { LayoutDashboard, Building2, Settings } from 'lucide-react'
import { useState } from 'react'
import { useKeyboardShortcuts } from '../../hooks/useKeyboardShortcuts'
import useThemeStore from '../../store/useThemeStore'
import SearchModal from '../../components/ui/SearchModal/SearchModal'
import useToastStore from '../../store/useToastStore'

const navGroups = [
    {
        items: [
            { label: 'Dashboard', path: '/management/dashboard', icon: LayoutDashboard },
            {
                label: 'Organisations',
                icon: Building2,
                children: [
                    { label: 'All Organisations', path: '/management/organisations' },
                    { label: 'Create New', path: '/management/organisations/create' },
                ]
            },
        ]
    },
    {
        items: [
            { label: 'Settings', path: '/management/settings', icon: Settings },
        ]
    },
]

export default function DashboardLayout({ children, title }) {
    const [isSearchOpen, setIsSearchOpen] = useState(false)
    const { cycleTheme } = useThemeStore()
    const addToast = useToastStore((state) => state.addToast)

    useKeyboardShortcuts({
        'ctrl+shift+f': () => setIsSearchOpen(true),
        'escape': () => setIsSearchOpen(false),
        'ctrl+shift+l': () => {
            cycleTheme()
            const newTheme = useThemeStore.getState().theme
            addToast(`${newTheme.charAt(0).toUpperCase() + newTheme.slice(1)} mode`)
        },
    })

    return (
        <div className="dashboard">
            <Sidebar navGroups={navGroups} onSearchOpen={() => setIsSearchOpen(true)} />
            <div className="dashboard__main">
                <TopBar title={title} />
                <main className="dashboard__content">
                    {children}
                </main>
            </div>
            <MobileNav navGroups={navGroups} onSearchOpen={() => setIsSearchOpen(true)} />
            <SearchModal
                items={navGroups.flatMap(g => g.items)}
                isOpen={isSearchOpen}
                onClose={() => setIsSearchOpen(false)}
            />
        </div>
    )
}