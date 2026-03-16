import './DashboardLayout.css'
import Sidebar from './components/Sidebar/Sidebar'
import TopBar from './components/TopBar/TopBar'

export default function DashboardLayout({ children, title }) {
    return (
        <div className="dashboard">
            <Sidebar />
            <div className="dashboard__main">
                <TopBar title={title} />
                <main className="dashboard__content">
                    {children}
                </main>
            </div>
        </div>
    )
}