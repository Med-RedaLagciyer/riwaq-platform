import './TopBar.css'

export default function TopBar({ title }) {
    return (
        <header className="topbar">
            <h1 className="topbar__title">{title}</h1>
        </header>
    )
}