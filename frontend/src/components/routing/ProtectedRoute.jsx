import { Navigate } from 'react-router-dom'
import useAuthStore from '../../store/useAuthStore'

function ProtectedRoute({ children, allowedRoles }) {
    const { token, role } = useAuthStore()

    if (!token) {
        return <Navigate to="/login" replace />
    }

    if (allowedRoles && !allowedRoles.includes(role)) {
        return <Navigate to="/login" replace />
    }

    return children
}

export default ProtectedRoute