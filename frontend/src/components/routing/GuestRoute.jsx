import { Navigate } from 'react-router-dom'
import useAuthStore from '../../store/useAuthStore'
import getHomeRoute from '../../utils/getHomeRoute'

export default function GuestRoute({ children }) {
    const { token, role } = useAuthStore()

    if (token) {
        return <Navigate to={getHomeRoute(role)} replace />
    }

    return children
}