import { Navigate } from 'react-router-dom'
import useAuthStore from '../../store/useAuthStore'

function ProtectedRoute({ children, allowedRoles }) {
    const { token, role } = useAuthStore()

    if (!token) {
        return <Navigate to="/login" replace />
    }

    if (allowedRoles && !allowedRoles.some(r => role?.includes(r))) {
        return <Navigate to="/unauthorized" replace />
    }

    return children
}

export default ProtectedRoute