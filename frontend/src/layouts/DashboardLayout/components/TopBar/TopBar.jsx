import { useState } from 'react'
import { MoreHorizontal } from 'lucide-react'
import OrganisationSelector from '../OrganisationSelector/OrganisationSelector'
import './TopBar.css'

export default function TopBar({ title }) {
    const [isOrganisationSelectorOpen, setIsOrganisationSelectorOpen] = useState(false)

    return (
        <header className="topbar">
            <div className="topbar__left">
                <OrganisationSelector
                    isOpen={isOrganisationSelectorOpen}
                    onToggle={() => setIsOrganisationSelectorOpen(!isOrganisationSelectorOpen)}
                    onClose={() => setIsOrganisationSelectorOpen(false)}
                />
            </div>
            <div className="topbar__center">
                <span className="topbar__title">{title}</span>
            </div>
            <div className="topbar__right">
                <button className="topbar__more">
                    <MoreHorizontal size={18} />
                </button>
            </div>
        </header>
    )
}