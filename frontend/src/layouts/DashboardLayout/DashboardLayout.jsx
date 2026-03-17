import './DashboardLayout.css'
import Sidebar from './components/Sidebar/Sidebar'
import TopBar from './components/TopBar/TopBar'
import MobileNav from './components/MobileNav/MobileNav'
import { LayoutDashboard, Building2, Settings } from 'lucide-react'
import useCommandPalette from './hooks/useCommandPalette'
import CommandPalette from '../../components/ui/CommandPalette/CommandPalette'

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
    const { isOpen: isPaletteOpen, open: openPalette, close: closePalette } = useCommandPalette()

    return (
        <div className="dashboard">
            <Sidebar navGroups={navGroups} openPalette={openPalette} />
            <div className="dashboard__main">
                <TopBar title={title} />
                <main className="dashboard__content">
                    {children}
                </main>
            </div>
            <MobileNav navGroups={navGroups} onSearchOpen={openPalette} />
            <CommandPalette
                key={isPaletteOpen}
                items={navGroups.flatMap(g => g.items)}
                isOpen={isPaletteOpen}
                onClose={closePalette}
            />
        </div>
    )
}