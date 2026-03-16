import './DashboardLayout.css'
import Sidebar from './components/Sidebar/Sidebar'

export default function DashboardLayout({ children }) {
    return (
        <div className="dashboard">
            <Sidebar />
            <div className="dashboard__main">
                {children}
            </div>
        </div>
    )
}