import { Navigate } from 'react-router-dom'
import useAuthStore from '../../store/useAuthStore'
import getHomeRoute from '../../utils/getHomeRoute'

export default function GuestRoute({ children }) {
    const { token } = useAuthStore()

    if (token) {
        return <Navigate to={getHomeRoute()} replace />
    }

    return children
}