import useAuthStore from '../../../store/useAuthStore'

export default function LogoutButton() {
    const clearAuth = useAuthStore((state) => state.clearAuth)

    const handleLogout = () => {
        clearAuth()
        window.location.href = '/login'
    }

    return (
        <button onClick={handleLogout}>
            Logout
        </button>
    )
}